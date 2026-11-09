<?php

declare(strict_types=1);

require_once __DIR__ . '/../../../Domain/Models/EmisoraModel.php';
require_once __DIR__ . '/../../../Domain/ValueObjects/EmisoraId.php';

interface GetEmisoraByIdPort
{
    public function getById(EmisoraId $emisoraId): ?EmisoraModel;
}
