<?php

declare(strict_types=1);

namespace App\Domain\BookLog\ValueObjects;

use App\Domain\Common\ValueObjects\IntegerValue;

class BookRating extends IntegerValue
{
    protected const MIN_VALUE = 1;
    protected const MAX_VALUE = 10;

    public function isHighRating(): bool
    {
        return $this->value >= 8;
    }

    public function isLowRating(): bool
    {
        return $this->value <= 3;
    }

    public function isMediumRating(): bool
    {
        return $this->value >= 4 && $this->value <= 7;
    }
}
