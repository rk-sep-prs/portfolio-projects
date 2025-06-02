<?php

declare(strict_types=1);

namespace App\Domain\Entities;

use DateTimeImmutable; // 不変な日時クラスを使用

class BookLog
{
    // プロパティ: 型を厳密に指定し、外部から変更されたくないものは readonly にします
    public readonly string $id;         // UUIDなどを想定
    public readonly string $title;      // 本のタイトル
    public readonly string $author;     // 著者名
    public ?string $impression;         // 感想 (後から編集する可能性を考慮し、一旦 readonly なし)
    public readonly ?DateTimeImmutable $finishedDate; // 読了日 (Nullable)
    public readonly ?int $rating;       // 評価 (1-5など？ Nullable)
    public readonly DateTimeImmutable $createdAt;    // 作成日時
    public DateTimeImmutable $updatedAt;    // 更新日時 (更新されるので readonly なし)

    // コンストラクタ: エンティティ作成時に必要な情報を設定
    public function __construct(
        string $id,
        string $title,
        string $author,
        ?string $impression,
        ?DateTimeImmutable $finishedDate,
        ?int $rating,
        DateTimeImmutable $createdAt,
        DateTimeImmutable $updatedAt
    ) {
        $this->id = $id;
        $this->title = $title;
        $this->author = $author;
        $this->impression = $impression;
        $this->finishedDate = $finishedDate;
        $this->rating = $rating; // TODO: バリデーション (例: 1-5の範囲内か)
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }

    // 必要に応じて更新用のメソッドなどを追加
    public function updateImpression(string $impression): void
    {
        $this->impression = $impression;
        $this->updatedAt = new DateTimeImmutable(); // 更新日時を更新
    }

    // 他のプロパティを更新するメソッドも同様に定義可能
}