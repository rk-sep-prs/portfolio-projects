<?php

declare(strict_types=1);

namespace App\Domain\BookLog\ValueObjects;

use App\Domain\Common\ValueObjects\StringValue;

class BookTitle extends StringValue
{
    // BookTitle固有のバリデーションがあればここに追加
    // 現在は基底クラスのStringValueのバリデーションを使用
}
