<?php

declare(strict_types=1);

/**
 * Pruebas del dominio y de los casos de uso de Emisora, sin base de datos.
 *
 * Ejecutar:  php tests/EmisoraDomainTest.php
 * Termina con código 1 si alguna prueba falla (lo usa GitHub Actions).
 */

require_once __DIR__ . '/../Domain/Models/EmisoraModel.php';
require_once __DIR__ . '/../Domain/Exceptions/EmisoraNotFoundException.php';
require_once __DIR__ . '/../Domain/Exceptions/EmisoraAlreadyExistsException.php';
require_once __DIR__ . '/../Application/Services/CreateEmisoraService.php';
require_once __DIR__ . '/../Application/Services/UpdateEmisoraService.php';
require_once __DIR__ . '/../Application/Services/DeleteEmisoraService.php';
require_once __DIR__ . '/../Application/Services/GetEmisoraByIdService.php';
require_once __DIR__ . '/../Application/Services/GetAllEmisorasService.php';

/** Repositorio en memoria que implementa los puertos de salida (sustituye a MySQL). */
final class InMemoryEmisoraRepository implements
    SaveEmisoraPort, UpdateEmisoraPort, GetEmisoraByIdPort, GetEmisoraByNombrePort, GetAllEmisorasPort, DeleteEmisoraPort
{
    /** @var array<string, EmisoraModel> */
    public array $items = array();

    public function save(EmisoraModel $emisora): EmisoraModel
    {
        return $this->items[$emisora->id()->value()] = $emisora;
    }

    public function update(EmisoraModel $emisora): EmisoraModel
    {
        return $this->items[$emisora->id()->value()] = $emisora;
    }

    public function getById(EmisoraId $emisoraId): ?EmisoraModel
    {
        return $this->items[$emisoraId->value()] ?? null;
    }

    public function getByNombre(EmisoraNombre $nombre): ?EmisoraModel
    {
        foreach ($this->items as $item) {
            if ($item->nombre()->equals($nombre)) {
                return $item;
            }
        }
        return null;
    }

    public function getAll(): array
    {
        return array_values($this->items);
    }

    public function delete(EmisoraId $emisoraId): void
    {
        unset($this->items[$emisoraId->value()]);
    }
}

$passed = 0;
$failed = 0;

function check(string $name, callable $test): void
{
    global $passed, $failed;
    try {
        $test();
        $passed++;
        echo "  [OK]   {$name}\n";
    } catch (Throwable $e) {
        $failed++;
        echo "  [FAIL] {$name}: " . get_class($e) . ' - ' . $e->getMessage() . "\n";
    }
}

function expectThrows(string $class, callable $fn): void
{
    try {
        $fn();
    } catch (Throwable $e) {
        if ($e instanceof $class) {
            return;
        }
        throw new RuntimeException('Se esperaba ' . $class . ' y se obtuvo ' . get_class($e));
    }
    throw new RuntimeException('Se esperaba la excepción ' . $class);
}

function assertSame(mixed $expected, mixed $actual): void
{
    if ($expected !== $actual) {
        throw new RuntimeException('Esperado ' . var_export($expected, true) . ', obtenido ' . var_export($actual, true));
    }
}

function command(string $id, string $nombre, ?float $fm = 95.5, ?int $am = null): CreateEmisoraCommand
{
    return new CreateEmisoraCommand($id, $nombre, 'HJKC', $fm, $am, 5, 'musical', '24 horas', '', 'Colombia', '', 10, 2);
}

echo "Pruebas de Emisora\n";

check('Crea una emisora válida y normaliza nombre y género', function (): void {
    $model = EmisoraApplicationMapper::fromCreateCommandToModel(command('e1', '  Radio   Uno '));
    assertSame('Radio Uno', $model->nombre()->value());
    assertSame('MUSICAL', $model->genero());
    assertSame(true, $model->transmiteEnFm());
});

check('Rechaza emisora sin banda FM ni AM', function (): void {
    expectThrows(InvalidEmisoraException::class, fn() => EmisoraApplicationMapper::fromCreateCommandToModel(command('e1', 'Radio', null, null)));
});

check('Rechaza FM fuera de 87.5-108.0', function (): void {
    expectThrows(InvalidEmisoraException::class, fn() => new BandaFm(120.0));
    expectThrows(InvalidEmisoraException::class, fn() => new BandaFm(87.4));
});

check('Rechaza AM fuera de 530-1710', function (): void {
    expectThrows(InvalidEmisoraException::class, fn() => new BandaAm(529));
    expectThrows(InvalidEmisoraException::class, fn() => new BandaAm(1711));
});

check('Rechaza nombre de menos de 3 caracteres', function (): void {
    expectThrows(InvalidEmisoraException::class, fn() => new EmisoraNombre('Ra'));
});

check('Rechaza género desconocido', function (): void {
    expectThrows(InvalidEmisoraException::class, fn() => GeneroEmisoraEnum::ensureIsValid('ROCKOLA'));
});

check('Crear guarda y luego rechaza el nombre repetido', function (): void {
    $repo = new InMemoryEmisoraRepository();
    $service = new CreateEmisoraService($repo, $repo, $repo);
    $service->execute(command('e1', 'Radio Uno'));
    assertSame(1, count($repo->items));
    expectThrows(EmisoraAlreadyExistsException::class, fn() => $service->execute(command('e2', 'radio uno')));
    expectThrows(EmisoraAlreadyExistsException::class, fn() => $service->execute(command('e1', 'Otra Radio')));
});

check('Actualizar cambia los datos y conserva el propio nombre', function (): void {
    $repo = new InMemoryEmisoraRepository();
    (new CreateEmisoraService($repo, $repo, $repo))->execute(command('e1', 'Radio Uno'));
    $update = new UpdateEmisoraService($repo, $repo, $repo);
    $updated = $update->execute(new UpdateEmisoraCommand('e1', 'Radio Uno', 'HJKC', null, 1170, 8, 'NOTICIAS', '05-23', '', 'Colombia', '', 3, 1));
    assertSame(1170, $updated->bandaAm()?->value());
    assertSame(false, $updated->transmiteEnFm());
});

check('Actualizar una emisora inexistente lanza EmisoraNotFoundException', function (): void {
    $repo = new InMemoryEmisoraRepository();
    $update = new UpdateEmisoraService($repo, $repo, $repo);
    expectThrows(EmisoraNotFoundException::class, fn() => $update->execute(new UpdateEmisoraCommand('x', 'Radio X', 'C', 90.0, null, 1, 'MUSICAL', 'h', '', 'Colombia', '', 0, 1)));
});

check('Consultar, listar y eliminar', function (): void {
    $repo = new InMemoryEmisoraRepository();
    (new CreateEmisoraService($repo, $repo, $repo))->execute(command('e1', 'Radio Uno'));
    assertSame('Radio Uno', (new GetEmisoraByIdService($repo))->execute(new GetEmisoraByIdQuery('e1'))->nombre()->value());
    assertSame(1, count((new GetAllEmisorasService($repo))->execute(new GetAllEmisorasQuery())));
    (new DeleteEmisoraService($repo, $repo))->execute(new DeleteEmisoraCommand('e1'));
    expectThrows(EmisoraNotFoundException::class, fn() => (new GetEmisoraByIdService($repo))->execute(new GetEmisoraByIdQuery('e1')));
    expectThrows(EmisoraNotFoundException::class, fn() => (new DeleteEmisoraService($repo, $repo))->execute(new DeleteEmisoraCommand('e1')));
});

echo "\nResultado: {$passed} correctas, {$failed} fallidas\n";
exit($failed === 0 ? 0 : 1);
