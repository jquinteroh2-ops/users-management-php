<?php

declare(strict_types=1);

require_once __DIR__ . '/../../../../../Application/Ports/Out/SaveEmisoraPort.php';
require_once __DIR__ . '/../../../../../Application/Ports/Out/UpdateEmisoraPort.php';
require_once __DIR__ . '/../../../../../Application/Ports/Out/GetEmisoraByIdPort.php';
require_once __DIR__ . '/../../../../../Application/Ports/Out/GetEmisoraByNombrePort.php';
require_once __DIR__ . '/../../../../../Application/Ports/Out/GetAllEmisorasPort.php';
require_once __DIR__ . '/../../../../../Application/Ports/Out/DeleteEmisoraPort.php';
require_once __DIR__ . '/../Mapper/EmisoraPersistenceMapper.php';

/**
 * Adaptador de salida: implementa los puertos de persistencia de Emisora con PDO + MySQL.
 */
final class EmisoraRepositoryMySQL implements
    SaveEmisoraPort,
    UpdateEmisoraPort,
    GetEmisoraByIdPort,
    GetEmisoraByNombrePort,
    GetAllEmisorasPort,
    DeleteEmisoraPort
{
    private const COLUMNS = '
        id, nombre, canal, banda_fm, banda_am, num_locutores, genero, horario,
        patrocinador, pais, descripcion, num_programas, num_ciudades, created_at, updated_at
    ';

    public function __construct(
        private PDO $pdo,
        private EmisoraPersistenceMapper $mapper
    ) {
    }

    public function save(EmisoraModel $emisora): EmisoraModel
    {
        $dto = $this->mapper->fromModelToDto($emisora);

        $sql = '
            INSERT INTO emisoras (
                id, nombre, canal, banda_fm, banda_am, num_locutores, genero, horario,
                patrocinador, pais, descripcion, num_programas, num_ciudades, created_at, updated_at
            ) VALUES (
                :id, :nombre, :canal, :banda_fm, :banda_am, :num_locutores, :genero, :horario,
                :patrocinador, :pais, :descripcion, :num_programas, :num_ciudades, NOW(), NOW()
            )
        ';

        $this->pdo->prepare($sql)->execute($dto->toParameters());

        return $this->findOrFail($emisora->id(), 'save');
    }

    public function update(EmisoraModel $emisora): EmisoraModel
    {
        $dto = $this->mapper->fromModelToDto($emisora);

        $sql = '
            UPDATE emisoras
               SET nombre = :nombre,
                   canal = :canal,
                   banda_fm = :banda_fm,
                   banda_am = :banda_am,
                   num_locutores = :num_locutores,
                   genero = :genero,
                   horario = :horario,
                   patrocinador = :patrocinador,
                   pais = :pais,
                   descripcion = :descripcion,
                   num_programas = :num_programas,
                   num_ciudades = :num_ciudades,
                   updated_at = NOW()
             WHERE id = :id
        ';

        $this->pdo->prepare($sql)->execute($dto->toParameters());

        return $this->findOrFail($emisora->id(), 'update');
    }

    public function getById(EmisoraId $emisoraId): ?EmisoraModel
    {
        $statement = $this->pdo->prepare(
            'SELECT ' . self::COLUMNS . ' FROM emisoras WHERE id = :id LIMIT 1'
        );
        $statement->execute(array(':id' => $emisoraId->value()));
        $row = $statement->fetch();

        return $row === false ? null : $this->mapper->fromRowToModel($row);
    }

    public function getByNombre(EmisoraNombre $nombre): ?EmisoraModel
    {
        $statement = $this->pdo->prepare(
            'SELECT ' . self::COLUMNS . ' FROM emisoras WHERE LOWER(nombre) = LOWER(:nombre) LIMIT 1'
        );
        $statement->execute(array(':nombre' => $nombre->value()));
        $row = $statement->fetch();

        return $row === false ? null : $this->mapper->fromRowToModel($row);
    }

    /**
     * @return EmisoraModel[]
     */
    public function getAll(): array
    {
        $statement = $this->pdo->query(
            'SELECT ' . self::COLUMNS . ' FROM emisoras ORDER BY nombre ASC'
        );

        return $this->mapper->fromRowsToModels($statement->fetchAll());
    }

    public function delete(EmisoraId $emisoraId): void
    {
        $statement = $this->pdo->prepare('DELETE FROM emisoras WHERE id = :id');
        $statement->execute(array(':id' => $emisoraId->value()));
    }

    private function findOrFail(EmisoraId $emisoraId, string $operation): EmisoraModel
    {
        $emisora = $this->getById($emisoraId);

        if ($emisora === null) {
            throw new RuntimeException('No se pudo recuperar la emisora después de ' . $operation . '.');
        }

        return $emisora;
    }
}
