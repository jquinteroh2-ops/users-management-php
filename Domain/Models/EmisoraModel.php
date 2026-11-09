<?php

declare(strict_types=1);

require_once __DIR__ . '/../ValueObjects/EmisoraId.php';
require_once __DIR__ . '/../ValueObjects/EmisoraNombre.php';
require_once __DIR__ . '/../ValueObjects/BandaFm.php';
require_once __DIR__ . '/../ValueObjects/BandaAm.php';
require_once __DIR__ . '/../Enums/GeneroEmisoraEnum.php';
require_once __DIR__ . '/../Exceptions/InvalidEmisoraException.php';

/**
 * Entidad de dominio Emisora (ejercicio 25).
 *
 * Es inmutable. Las reglas de un solo atributo viven en los Value Objects
 * (EmisoraNombre, BandaFm, BandaAm); las que dependen de varios atributos,
 * como "debe transmitir al menos en FM o en AM", se validan aquí.
 */
final class EmisoraModel
{
    private EmisoraId $id;
    private EmisoraNombre $nombre;
    private string $canal;
    private ?BandaFm $bandaFm;
    private ?BandaAm $bandaAm;
    private int $numLocutores;
    private string $genero;
    private string $horario;
    private string $patrocinador;
    private string $pais;
    private string $descripcion;
    private int $numProgramas;
    private int $numCiudades;

    public function __construct(
        EmisoraId $id,
        EmisoraNombre $nombre,
        string $canal,
        ?BandaFm $bandaFm,
        ?BandaAm $bandaAm,
        int $numLocutores,
        string $genero,
        string $horario,
        string $patrocinador,
        string $pais,
        string $descripcion,
        int $numProgramas,
        int $numCiudades
    ) {
        if ($bandaFm === null && $bandaAm === null) {
            throw InvalidEmisoraException::becauseHasNoBand();
        }

        $genero = strtoupper(trim($genero));
        GeneroEmisoraEnum::ensureIsValid($genero);

        $this->id = $id;
        $this->nombre = $nombre;
        $this->canal = self::required($canal, 'canal');
        $this->bandaFm = $bandaFm;
        $this->bandaAm = $bandaAm;
        $this->numLocutores = self::atLeast($numLocutores, 1, 'numLocutores');
        $this->genero = $genero;
        $this->horario = self::required($horario, 'horario');
        $this->patrocinador = trim($patrocinador);
        $this->pais = self::required($pais, 'pais');
        $this->descripcion = trim($descripcion);
        $this->numProgramas = self::atLeast($numProgramas, 0, 'numProgramas');
        $this->numCiudades = self::atLeast($numCiudades, 1, 'numCiudades');
    }

    public function id(): EmisoraId
    {
        return $this->id;
    }

    public function nombre(): EmisoraNombre
    {
        return $this->nombre;
    }

    public function canal(): string
    {
        return $this->canal;
    }

    public function bandaFm(): ?BandaFm
    {
        return $this->bandaFm;
    }

    public function bandaAm(): ?BandaAm
    {
        return $this->bandaAm;
    }

    public function numLocutores(): int
    {
        return $this->numLocutores;
    }

    public function genero(): string
    {
        return $this->genero;
    }

    public function horario(): string
    {
        return $this->horario;
    }

    public function patrocinador(): string
    {
        return $this->patrocinador;
    }

    public function pais(): string
    {
        return $this->pais;
    }

    public function descripcion(): string
    {
        return $this->descripcion;
    }

    public function numProgramas(): int
    {
        return $this->numProgramas;
    }

    public function numCiudades(): int
    {
        return $this->numCiudades;
    }

    public function transmiteEnFm(): bool
    {
        return $this->bandaFm !== null;
    }

    public function transmiteEnAm(): bool
    {
        return $this->bandaAm !== null;
    }

    private static function required(string $value, string $field): string
    {
        $normalized = trim($value);

        if ($normalized === '') {
            throw InvalidEmisoraException::becauseFieldIsRequired($field);
        }

        return $normalized;
    }

    private static function atLeast(int $value, int $minimum, string $field): int
    {
        if ($value < $minimum) {
            throw InvalidEmisoraException::becauseValueIsBelowMinimum($field, $minimum);
        }

        return $value;
    }
}
