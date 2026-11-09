<?php

declare(strict_types=1);

require_once __DIR__ . '/../../Services/Dto/Commands/UpdateEmisoraCommand.php';
require_once __DIR__ . '/../../../Domain/Models/EmisoraModel.php';

interface UpdateEmisoraUseCase
{
    public function execute(UpdateEmisoraCommand $command): EmisoraModel;
}
