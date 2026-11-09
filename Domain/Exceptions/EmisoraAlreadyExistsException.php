<?php

declare(strict_types=1);

final class EmisoraAlreadyExistsException extends DomainException
{
    public static function becauseIdAlreadyExists(string $id): self
    {
        return new self('Ya existe una emisora con el id ' . $id . '.');
    }

    public static function becauseNombreAlreadyExists(string $nombre): self
    {
        return new self('Ya existe una emisora llamada "' . $nombre . '".');
    }
}
