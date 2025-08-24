<?php

declare(strict_types=1);

namespace App\Domain\Common\ValueObjects;

abstract class IntegerValue
{
    protected const MIN_VALUE = PHP_INT_MIN;
    protected const MAX_VALUE = PHP_INT_MAX;

    public function __construct(
        protected readonly int $value
    ) {
        $this->validate($this->value);
    }

    protected function validate(int $value): void
    {
        if ($value < static::MIN_VALUE || $value > static::MAX_VALUE) {
            throw new \InvalidArgumentException(
                sprintf('%sは%dから%dの間である必要があります', static::class, static::MIN_VALUE, static::MAX_VALUE)
            );
        }
    }

    public function value(): int
    {
        return $this->value;
    }

    public function equals(IntegerValue $other): bool
    {
        return $this->value === $other->value;
    }

    public function isGreaterThan(IntegerValue $other): bool
    {
        return $this->value > $other->value;
    }

    public function isLessThan(IntegerValue $other): bool
    {
        return $this->value < $other->value;
    }

    public function __toString(): string
    {
        return (string) $this->value;
    }
}
