<?php

declare(strict_types=1);

/**
 * Comando CQRS: datos para actualizar una emisora existente (identificada por id).
 */
final class UpdateEmisoraCommand
{
    public function __construct(
        private string $id,
        private string $nombre,
        private string $canal,
        private ?float $bandaFm,
        private ?int $bandaAm,
        private int $numLocutores,
        private string $genero,
        private string $horario,
        private string $patrocinador,
        private string $pais,
        private string $descripcion,
        private int $numProgramas,
        private int $numCiudades
    ) {
    }

    public function getId(): string
    {
        return trim($this->id);
    }

    public function getNombre(): string
    {
        return trim($this->nombre);
    }

    public function getCanal(): string
    {
        return trim($this->canal);
    }

    public function getBandaFm(): ?float
    {
        return $this->bandaFm;
    }

    public function getBandaAm(): ?int
    {
        return $this->bandaAm;
    }

    public function getNumLocutores(): int
    {
        return $this->numLocutores;
    }

    public function getGenero(): string
    {
        return strtoupper(trim($this->genero));
    }

    public function getHorario(): string
    {
        return trim($this->horario);
    }

    public function getPatrocinador(): string
    {
        return trim($this->patrocinador);
    }

    public function getPais(): string
    {
        return trim($this->pais);
    }

    public function getDescripcion(): string
    {
        return trim($this->descripcion);
    }

    public function getNumProgramas(): int
    {
        return $this->numProgramas;
    }

    public function getNumCiudades(): int
    {
        return $this->numCiudades;
    }
}
