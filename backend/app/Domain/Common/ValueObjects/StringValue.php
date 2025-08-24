<?php

declare(strict_types=1);

namespace App\Domain\Common\ValueObjects;

abstract class StringValue
{
    protected const MAX_LENGTH = 255;
    protected const MIN_LENGTH = 1;

    public function __construct(
        protected readonly string $value
    ) {
        $this->validate($this->value);
    }

    protected function validate(string $value): void
    {
        if (strlen($value) < static::MIN_LENGTH) {
            throw new \InvalidArgumentException(
                sprintf('%sは%d文字以上である必要があります', static::class, static::MIN_LENGTH)
            );
        }

        if (strlen($value) > static::MAX_LENGTH) {
            throw new \InvalidArgumentException(
                sprintf('%sは%d文字以下である必要があります', static::class, static::MAX_LENGTH)
            );
        }

        if (trim($value) === '') {
            throw new \InvalidArgumentException(
                sprintf('%sは空白のみではいけません', static::class)
            );
        }
    }

    public function value(): string
    {
        return $this->value;
    }

    public function equals(StringValue $other): bool
    {
        return $this->value === $other->value;
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
