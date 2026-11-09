<?php

declare(strict_types=1);

require_once __DIR__ . '/../Ports/In/GetEmisoraByIdUseCase.php';
require_once __DIR__ . '/../Ports/Out/GetEmisoraByIdPort.php';
require_once __DIR__ . '/Mappers/EmisoraApplicationMapper.php';
require_once __DIR__ . '/../../Domain/Exceptions/EmisoraNotFoundException.php';

/**
 * Consulta: obtener una emisora por su id.
 */
final class GetEmisoraByIdService implements GetEmisoraByIdUseCase
{
    public function __construct(private GetEmisoraByIdPort $getEmisoraByIdPort)
    {
    }

    public function execute(GetEmisoraByIdQuery $query): EmisoraModel
    {
        $emisoraId = EmisoraApplicationMapper::fromGetByIdQueryToEmisoraId($query);
        $emisora = $this->getEmisoraByIdPort->getById($emisoraId);

        if ($emisora === null) {
            throw EmisoraNotFoundException::becauseIdWasNotFound($emisoraId->value());
        }

        return $emisora;
    }
}
