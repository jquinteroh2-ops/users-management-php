<?php

declare(strict_types=1);

/**
 * Se lanza cuando un dato de la emisora no cumple las reglas del dominio.
 */
final class InvalidEmisoraException extends DomainException
{
    public static function becauseIdIsEmpty(): self
    {
        return new self('El id de la emisora no puede estar vacío.');
    }

    public static function becauseNombreIsEmpty(): self
    {
        return new self('El nombre de la emisora es obligatorio.');
    }

    public static function becauseNombreIsTooShort(int $minimum): self
    {
        return new self(sprintf('El nombre de la emisora debe tener al menos %d caracteres.', $minimum));
    }

    public static function becauseFieldIsRequired(string $field): self
    {
        return new self(sprintf('El campo "%s" es obligatorio.', $field));
    }

    public static function becauseFmIsOutOfRange(float $min, float $max): self
    {
        return new self(sprintf('La banda FM debe estar entre %.1f y %.1f MHz.', $min, $max));
    }

    public static function becauseAmIsOutOfRange(int $min, int $max): self
    {
        return new self(sprintf('La banda AM debe estar entre %d y %d kHz.', $min, $max));
    }

    public static function becauseHasNoBand(): self
    {
        return new self('La emisora debe transmitir en FM, en AM o en ambas bandas.');
    }

    public static function becauseValueIsBelowMinimum(string $field, int $minimum): self
    {
        return new self(sprintf('El campo "%s" debe ser como mínimo %d.', $field, $minimum));
    }

    public static function becauseGeneroIsInvalid(string $value): self
    {
        return new self(sprintf('El género "%s" no es válido.', $value));
    }
}
