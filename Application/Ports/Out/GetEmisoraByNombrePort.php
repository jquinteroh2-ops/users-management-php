<?php

declare(strict_types=1);

require_once __DIR__ . '/../../../Domain/Models/EmisoraModel.php';
require_once __DIR__ . '/../../../Domain/ValueObjects/EmisoraNombre.php';

interface GetEmisoraByNombrePort
{
    public function getByNombre(EmisoraNombre $nombre): ?EmisoraModel;
}
