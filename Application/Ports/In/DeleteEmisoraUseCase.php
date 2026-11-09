<?php

declare(strict_types=1);

require_once __DIR__ . '/../../Services/Dto/Commands/DeleteEmisoraCommand.php';

interface DeleteEmisoraUseCase
{
    public function execute(DeleteEmisoraCommand $command): void;
}
