<?php

declare(strict_types=1);

require_once __DIR__ . '/../../Services/Dto/Commands/CreateEmisoraCommand.php';
require_once __DIR__ . '/../../../Domain/Models/EmisoraModel.php';

interface CreateEmisoraUseCase
{
    public function execute(CreateEmisoraCommand $command): EmisoraModel;
}
