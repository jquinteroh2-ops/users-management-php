<?php

declare(strict_types=1);

require_once __DIR__ . '/../../../Domain/Models/EmisoraModel.php';

interface UpdateEmisoraPort
{
    public function update(EmisoraModel $emisora): EmisoraModel;
}
