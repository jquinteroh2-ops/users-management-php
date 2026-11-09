<?php

declare(strict_types=1);

require_once __DIR__ . '/../../Services/Dto/Queries/GetAllEmisorasQuery.php';

interface GetAllEmisorasUseCase
{
    /**
     * @return EmisoraModel[]
     */
    public function execute(GetAllEmisorasQuery $query): array;
}
