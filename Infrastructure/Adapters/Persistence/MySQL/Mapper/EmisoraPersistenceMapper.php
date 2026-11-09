<?php

declare(strict_types=1);

require_once __DIR__ . '/../Dto/EmisoraPersistenceDto.php';
require_once __DIR__ . '/../Entity/EmisoraEntity.php';
require_once __DIR__ . '/../../../../../Domain/Models/EmisoraModel.php';

/**
 * Traduce entre el modelo de dominio y las filas de la tabla "emisoras".
 */
final class EmisoraPersistenceMapper
{
    public function fromModelToDto(EmisoraModel $emisora): EmisoraPersistenceDto
    {
        return new EmisoraPersistenceDto(
            $emisora->id()->value(),
            $emisora->nombre()->value(),
            $emisora->canal(),
            $emisora->bandaFm()?->value(),
            $emisora->bandaAm()?->value(),
            $emisora->numLocutores(),
            $emisora->genero(),
            $emisora->horario(),
            $emisora->patrocinador(),
            $emisora->pais(),
            $emisora->descripcion(),
            $emisora->numProgramas(),
            $emisora->numCiudades()
        );
    }

    /**
     * @param array<string, mixed> $row
     */
    public function fromRowToEntity(array $row): EmisoraEntity
    {
        return new EmisoraEntity(
            (string) $row['id'],
            (string) $row['nombre'],
            (string) $row['canal'],
            $row['banda_fm'] === null ? null : (float) $row['banda_fm'],
            $row['banda_am'] === null ? null : (int) $row['banda_am'],
            (int) $row['num_locutores'],
            (string) $row['genero'],
            (string) $row['horario'],
            (string) ($row['patrocinador'] ?? ''),
            (string) $row['pais'],
            (string) ($row['descripcion'] ?? ''),
            (int) $row['num_programas'],
            (int) $row['num_ciudades'],
            isset($row['created_at']) ? (string) $row['created_at'] : null,
            isset($row['updated_at']) ? (string) $row['updated_at'] : null
        );
    }

    public function fromEntityToModel(EmisoraEntity $entity): EmisoraModel
    {
        return new EmisoraModel(
            new EmisoraId($entity->id),
            new EmisoraNombre($entity->nombre),
            $entity->canal,
            BandaFm::fromNullable($entity->bandaFm),
            BandaAm::fromNullable($entity->bandaAm),
            $entity->numLocutores,
            $entity->genero,
            $entity->horario,
            $entity->patrocinador,
            $entity->pais,
            $entity->descripcion,
            $entity->numProgramas,
            $entity->numCiudades
        );
    }

    /**
     * @param array<string, mixed> $row
     */
    public function fromRowToModel(array $row): EmisoraModel
    {
        return $this->fromEntityToModel($this->fromRowToEntity($row));
    }

    /**
     * @param array<int, array<string, mixed>> $rows
     * @return EmisoraModel[]
     */
    public function fromRowsToModels(array $rows): array
    {
        $models = array();

        foreach ($rows as $row) {
            $models[] = $this->fromRowToModel($row);
        }

        return $models;
    }
}
