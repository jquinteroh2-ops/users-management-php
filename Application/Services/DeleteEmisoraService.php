<?php

declare(strict_types=1);

require_once __DIR__ . '/../Ports/In/DeleteEmisoraUseCase.php';
require_once __DIR__ . '/../Ports/Out/DeleteEmisoraPort.php';
require_once __DIR__ . '/../Ports/Out/GetEmisoraByIdPort.php';
require_once __DIR__ . '/Mappers/EmisoraApplicationMapper.php';
require_once __DIR__ . '/../../Domain/Exceptions/EmisoraNotFoundException.php';

/**
 * Caso de uso: eliminar una emisora. Falla si no existe.
 */
final class DeleteEmisoraService implements DeleteEmisoraUseCase
{
    public function __construct(
        private DeleteEmisoraPort $deleteEmisoraPort,
        private GetEmisoraByIdPort $getEmisoraByIdPort
    ) {
    }

    public function execute(DeleteEmisoraCommand $command): void
    {
        $emisoraId = EmisoraApplicationMapper::fromDeleteCommandToEmisoraId($command);

        if ($this->getEmisoraByIdPort->getById($emisoraId) === null) {
            throw EmisoraNotFoundException::becauseIdWasNotFound($emisoraId->value());
        }

        $this->deleteEmisoraPort->delete($emisoraId);
    }
}
