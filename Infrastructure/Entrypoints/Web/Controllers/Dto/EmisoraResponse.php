<?php

declare(strict_types=1);

/**
 * Datos de una emisora listos para mostrarse en una vista o en JSON.
 */
final class EmisoraResponse
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
        return $this->id;
    }

    public function getNombre(): string
    {
        return $this->nombre;
    }

    public function getCanal(): string
    {
        return $this->canal;
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
        return $this->genero;
    }

    public function getHorario(): string
    {
        return $this->horario;
    }

    public function getPatrocinador(): string
    {
        return $this->patrocinador;
    }

    public function getPais(): string
    {
        return $this->pais;
    }

    public function getDescripcion(): string
    {
        return $this->descripcion;
    }

    public function getNumProgramas(): int
    {
        return $this->numProgramas;
    }

    public function getNumCiudades(): int
    {
        return $this->numCiudades;
    }

    /** Texto para mostrar las bandas en la tabla: "95.5 FM / 1170 AM". */
    public function bandasTexto(): string
    {
        $partes = array();

        if ($this->bandaFm !== null) {
            $partes[] = number_format($this->bandaFm, 1, '.', '') . ' FM';
        }
        if ($this->bandaAm !== null) {
            $partes[] = $this->bandaAm . ' AM';
        }

        return implode(' / ', $partes);
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return array(
            'id' => $this->id,
            'nombre' => $this->nombre,
            'canal' => $this->canal,
            'bandaFm' => $this->bandaFm,
            'bandaAm' => $this->bandaAm,
            'numLocutores' => $this->numLocutores,
            'genero' => $this->genero,
            'horario' => $this->horario,
            'patrocinador' => $this->patrocinador,
            'pais' => $this->pais,
            'descripcion' => $this->descripcion,
            'numProgramas' => $this->numProgramas,
            'numCiudades' => $this->numCiudades,
        );
    }
}
