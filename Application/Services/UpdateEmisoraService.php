<?php

declare(strict_types=1);

require_once __DIR__ . '/../Ports/In/UpdateEmisoraUseCase.php';
require_once __DIR__ . '/../Ports/Out/UpdateEmisoraPort.php';
require_once __DIR__ . '/../Ports/Out/GetEmisoraByIdPort.php';
require_once __DIR__ . '/../Ports/Out/GetEmisoraByNombrePort.php';
require_once __DIR__ . '/Mappers/EmisoraApplicationMapper.php';
require_once __DIR__ . '/../../Domain/Exceptions/EmisoraNotFoundException.php';
require_once __DIR__ . '/../../Domain/Exceptions/EmisoraAlreadyExistsException.php';

/**
 * Caso de uso: actualizar una emisora existente sin repetir el nombre de otra.
 */
final class UpdateEmisoraService implements UpdateEmisoraUseCase
{
    public function __construct(
        private UpdateEmisoraPort $updateEmisoraPort,
        private GetEmisoraByIdPort $getEmisoraByIdPort,
        private GetEmisoraByNombrePort $getEmisoraByNombrePort
    ) {
    }

    public function execute(UpdateEmisoraCommand $command): EmisoraModel
    {
        $emisora = EmisoraApplicationMapper::fromUpdateCommandToModel($command);

        if ($this->getEmisoraByIdPort->getById($emisora->id()) === null) {
            throw EmisoraNotFoundException::becauseIdWasNotFound($emisora->id()->value());
        }

        $sameNombre = $this->getEmisoraByNombrePort->getByNombre($emisora->nombre());
        if ($sameNombre !== null && !$sameNombre->id()->equals($emisora->id())) {
            throw EmisoraAlreadyExistsException::becauseNombreAlreadyExists($emisora->nombre()->value());
        }

        return $this->updateEmisoraPort->update($emisora);
    }
}
