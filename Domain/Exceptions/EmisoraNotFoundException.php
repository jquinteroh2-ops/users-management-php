<?php

declare(strict_types=1);

final class EmisoraNotFoundException extends DomainException
{
    public static function becauseIdWasNotFound(string $id): self
    {
        return new self('No existe una emisora con el id ' . $id . '.');
    }
}
