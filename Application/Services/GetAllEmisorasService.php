<?php

declare(strict_types=1);

require_once __DIR__ . '/../Ports/In/GetAllEmisorasUseCase.php';
require_once __DIR__ . '/../Ports/Out/GetAllEmisorasPort.php';

/**
 * Consulta: listar todas las emisoras ordenadas por nombre.
 */
final class GetAllEmisorasService implements GetAllEmisorasUseCase
{
    public function __construct(private GetAllEmisorasPort $getAllEmisorasPort)
    {
    }

    /**
     * @return EmisoraModel[]
     */
    public function execute(GetAllEmisorasQuery $query): array
    {
        return $this->getAllEmisorasPort->getAll();
    }
}
