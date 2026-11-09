<?php

declare(strict_types=1);

require_once __DIR__ . '/../Exceptions/InvalidEmisoraException.php';

/**
 * Nombre comercial de la emisora: mínimo 3 caracteres y sin espacios repetidos.
 */
final class EmisoraNombre
{
    private const MINIMUM_LENGTH = 3;

    private string $value;

    public function __construct(string $value)
    {
        $normalized = trim((string) preg_replace('/\s+/u', ' ', $value));

        if ($normalized === '') {
            throw InvalidEmisoraException::becauseNombreIsEmpty();
        }

        if (mb_strlen($normalized) < self::MINIMUM_LENGTH) {
            throw InvalidEmisoraException::becauseNombreIsTooShort(self::MINIMUM_LENGTH);
        }

        $this->value = $normalized;
    }

    public function value(): string
    {
        return $this->value;
    }

    public function equals(EmisoraNombre $other): bool
    {
        return mb_strtolower($this->value) === mb_strtolower($other->value());
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
