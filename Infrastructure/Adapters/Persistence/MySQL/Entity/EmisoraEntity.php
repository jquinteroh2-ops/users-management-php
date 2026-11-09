<?php

declare(strict_types=1);

/**
 * Fila de la tabla "emisoras" leída desde MySQL.
 */
final class EmisoraEntity
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
        public readonly int $numCiudades,
        public readonly ?string $createdAt = null,
        public readonly ?string $updatedAt = null
    ) {
    }
}
