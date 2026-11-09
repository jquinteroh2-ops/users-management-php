<?php

declare(strict_types=1);

require_once __DIR__ . '/../Exceptions/InvalidEmisoraException.php';

/**
 * Género o formato principal de la programación de una emisora.
 */
final class GeneroEmisoraEnum
{
    const NOTICIAS = 'NOTICIAS';
    const MUSICAL = 'MUSICAL';
    const DEPORTIVA = 'DEPORTIVA';
    const CULTURAL = 'CULTURAL';
    const RELIGIOSA = 'RELIGIOSA';
    const EDUCATIVA = 'EDUCATIVA';
    const COMUNITARIA = 'COMUNITARIA';
    const VARIEDADES = 'VARIEDADES';

    /**
     * @return string[]
     */
    public static function values(): array
    {
        return array(
            self::NOTICIAS,
            self::MUSICAL,
            self::DEPORTIVA,
            self::CULTURAL,
            self::RELIGIOSA,
            self::EDUCATIVA,
            self::COMUNITARIA,
            self::VARIEDADES,
        );
    }

    public static function isValid(string $value): bool
    {
        return in_array($value, self::values(), true);
    }

    public static function ensureIsValid(string $value): void
    {
        if (!self::isValid($value)) {
            throw InvalidEmisoraException::becauseGeneroIsInvalid($value);
        }
    }
}
