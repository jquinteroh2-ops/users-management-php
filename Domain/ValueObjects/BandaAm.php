<?php

declare(strict_types=1);

require_once __DIR__ . '/../Exceptions/InvalidEmisoraException.php';

/**
 * Frecuencia en la banda AM, en kHz (530 a 1710).
 */
final class BandaAm
{
    public const MINIMUM = 530;
    public const MAXIMUM = 1710;

    private int $kilohertz;

    public function __construct(int $kilohertz)
    {
        if ($kilohertz < self::MINIMUM || $kilohertz > self::MAXIMUM) {
            throw InvalidEmisoraException::becauseAmIsOutOfRange(self::MINIMUM, self::MAXIMUM);
        }

        $this->kilohertz = $kilohertz;
    }

    /** Devuelve null si la emisora no transmite en AM. */
    public static function fromNullable(?int $kilohertz): ?self
    {
        return $kilohertz === null ? null : new self($kilohertz);
    }

    public function value(): int
    {
        return $this->kilohertz;
    }

    public function __toString(): string
    {
        return $this->kilohertz . ' kHz';
    }
}
