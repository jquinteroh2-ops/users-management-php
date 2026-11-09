<?php

declare(strict_types=1);

/** Consulta CQRS: obtener una emisora por id. */
final class GetEmisoraByIdQuery
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
