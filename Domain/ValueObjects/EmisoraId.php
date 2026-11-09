<?php

declare(strict_types=1);

require_once __DIR__ . '/../Exceptions/InvalidEmisoraException.php';

/**
 * Identificador único de una emisora (UUID generado por el sistema o "emi-001").
 */
final class EmisoraId
{
    private string $value;

    public function __construct(string $value)
    {
        $normalized = trim($value);

        if ($normalized === '') {
            throw InvalidEmisoraException::becauseIdIsEmpty();
        }

        $this->value = $normalized;
    }

    public function value(): string
    {
        return $this->value;
    }

    public function equals(EmisoraId $other): bool
    {
        return $this->value === $other->value();
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
