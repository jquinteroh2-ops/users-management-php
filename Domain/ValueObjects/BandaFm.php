<?php

declare(strict_types=1);

require_once __DIR__ . '/../Exceptions/InvalidEmisoraException.php';

/**
 * Frecuencia en la banda FM, en MHz (87.5 a 108.0).
 */
final class BandaFm
{
    public const MINIMUM = 87.5;
    public const MAXIMUM = 108.0;

    private float $megahertz;

    public function __construct(float $megahertz)
    {
        if ($megahertz < self::MINIMUM || $megahertz > self::MAXIMUM) {
            throw InvalidEmisoraException::becauseFmIsOutOfRange(self::MINIMUM, self::MAXIMUM);
        }

        $this->megahertz = round($megahertz, 1);
    }

    /** Devuelve null si la emisora no transmite en FM. */
    public static function fromNullable(?float $megahertz): ?self
    {
        return $megahertz === null ? null : new self($megahertz);
    }

    public function value(): float
    {
        return $this->megahertz;
    }

    public function __toString(): string
    {
        return number_format($this->megahertz, 1, '.', '') . ' MHz';
    }
}
