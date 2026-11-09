<?php

declare(strict_types=1);

require_once __DIR__ . '/../../../Domain/Models/EmisoraModel.php';

interface GetAllEmisorasPort
{
    /**
     * @return EmisoraModel[]
     */
    public function getAll(): array;
}
