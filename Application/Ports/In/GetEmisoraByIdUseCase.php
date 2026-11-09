<?php

declare(strict_types=1);

require_once __DIR__ . '/../../Services/Dto/Queries/GetEmisoraByIdQuery.php';
require_once __DIR__ . '/../../../Domain/Models/EmisoraModel.php';

interface GetEmisoraByIdUseCase
{
    public function execute(GetEmisoraByIdQuery $query): EmisoraModel;
}
