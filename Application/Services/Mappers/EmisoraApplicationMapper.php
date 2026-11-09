<?php

declare(strict_types=1);

require_once __DIR__ . '/../Dto/Commands/CreateEmisoraCommand.php';
require_once __DIR__ . '/../Dto/Commands/UpdateEmisoraCommand.php';
require_once __DIR__ . '/../Dto/Commands/DeleteEmisoraCommand.php';
require_once __DIR__ . '/../Dto/Queries/GetEmisoraByIdQuery.php';
require_once __DIR__ . '/../../../Domain/Models/EmisoraModel.php';

/**
 * Convierte comandos y consultas de la capa de aplicación en objetos del dominio.
 */
final class EmisoraApplicationMapper
{
    public static function fromCreateCommandToModel(CreateEmisoraCommand $command): EmisoraModel
    {
        return new EmisoraModel(
            new EmisoraId($command->getId()),
            new EmisoraNombre($command->getNombre()),
            $command->getCanal(),
            BandaFm::fromNullable($command->getBandaFm()),
            BandaAm::fromNullable($command->getBandaAm()),
            $command->getNumLocutores(),
            $command->getGenero(),
            $command->getHorario(),
            $command->getPatrocinador(),
            $command->getPais(),
            $command->getDescripcion(),
            $command->getNumProgramas(),
            $command->getNumCiudades()
        );
    }

    public static function fromUpdateCommandToModel(UpdateEmisoraCommand $command): EmisoraModel
    {
        return new EmisoraModel(
            new EmisoraId($command->getId()),
            new EmisoraNombre($command->getNombre()),
            $command->getCanal(),
            BandaFm::fromNullable($command->getBandaFm()),
            BandaAm::fromNullable($command->getBandaAm()),
            $command->getNumLocutores(),
            $command->getGenero(),
            $command->getHorario(),
            $command->getPatrocinador(),
            $command->getPais(),
            $command->getDescripcion(),
            $command->getNumProgramas(),
            $command->getNumCiudades()
        );
    }

    public static function fromGetByIdQueryToEmisoraId(GetEmisoraByIdQuery $query): EmisoraId
    {
        return new EmisoraId($query->getId());
    }

    public static function fromDeleteCommandToEmisoraId(DeleteEmisoraCommand $command): EmisoraId
    {
        return new EmisoraId($command->getId());
    }
}
