<?php

declare(strict_types=1);

require_once __DIR__ . '/../Ports/In/CreateEmisoraUseCase.php';
require_once __DIR__ . '/../Ports/Out/SaveEmisoraPort.php';
require_once __DIR__ . '/../Ports/Out/GetEmisoraByIdPort.php';
require_once __DIR__ . '/../Ports/Out/GetEmisoraByNombrePort.php';
require_once __DIR__ . '/Mappers/EmisoraApplicationMapper.php';
require_once __DIR__ . '/../../Domain/Exceptions/EmisoraAlreadyExistsException.php';

/**
 * Caso de uso: registrar una emisora. El id y el nombre no pueden repetirse.
 */
final class CreateEmisoraService implements CreateEmisoraUseCase
{
    public function __construct(
        private SaveEmisoraPort $saveEmisoraPort,
        private GetEmisoraByIdPort $getEmisoraByIdPort,
        private GetEmisoraByNombrePort $getEmisoraByNombrePort
    ) {
    }

    public function execute(CreateEmisoraCommand $command): EmisoraModel
    {
        $emisora = EmisoraApplicationMapper::fromCreateCommandToModel($command);

        if ($this->getEmisoraByIdPort->getById($emisora->id()) !== null) {
            throw EmisoraAlreadyExistsException::becauseIdAlreadyExists($emisora->id()->value());
        }

        if ($this->getEmisoraByNombrePort->getByNombre($emisora->nombre()) !== null) {
            throw EmisoraAlreadyExistsException::becauseNombreAlreadyExists($emisora->nombre()->value());
        }

        return $this->saveEmisoraPort->save($emisora);
    }
}
