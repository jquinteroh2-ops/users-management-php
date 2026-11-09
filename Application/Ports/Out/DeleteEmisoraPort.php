<?php

declare(strict_types=1);

require_once __DIR__ . '/../../../Domain/ValueObjects/EmisoraId.php';

interface DeleteEmisoraPort
{
    public function delete(EmisoraId $emisoraId): void;
}
