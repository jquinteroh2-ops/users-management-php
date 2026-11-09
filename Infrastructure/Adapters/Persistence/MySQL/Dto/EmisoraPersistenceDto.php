<?php

declare(strict_types=1);

/**
 * Datos de una emisora tal como se envían a la base de datos.
 */
final class EmisoraPersistenceDto
{
    public function __construct(
        public readonly string $id,
        public readonly string $nombre,
        public readonly string $canal,
        public readonly ?float $bandaFm,
        public readonly ?int $bandaAm,
        public readonly int $numLocutores,
        public readonly string $genero,
        public readonly string $horario,
        public readonly string $patrocinador,
        public readonly string $pais,
        public readonly string $descripcion,
        public readonly int $numProgramas,
        public readonly int $numCiudades
    ) {
    }

    /**
     * Parámetros con nombre para las sentencias preparadas de PDO.
     *
     * @return array<string, mixed>
     */
    public function toParameters(): array
    {
        return array(
            ':id' => $this->id,
            ':nombre' => $this->nombre,
            ':canal' => $this->canal,
            ':banda_fm' => $this->bandaFm,
            ':banda_am' => $this->bandaAm,
            ':num_locutores' => $this->numLocutores,
            ':genero' => $this->genero,
            ':horario' => $this->horario,
            ':patrocinador' => $this->patrocinador,
            ':pais' => $this->pais,
            ':descripcion' => $this->descripcion,
            ':num_programas' => $this->numProgramas,
            ':num_ciudades' => $this->numCiudades,
        );
    }
}
