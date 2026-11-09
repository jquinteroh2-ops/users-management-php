<?php

declare(strict_types=1);

/** Comando CQRS: eliminar una emisora por id. */
final class DeleteEmisoraCommand
{
    private string $id;

    public function __construct(string $id)
    {
        $this->id = trim($id);
    }

    public function getId(): string
    {
        return $this->id;
    }
}
