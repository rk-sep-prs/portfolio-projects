<?php

declare(strict_types=1);

namespace App\Application\UseCases\BookLog; // 名前空間を確認

// 依存するインターフェースを use
use App\Domain\Repositories\BookLogRepositoryInterface;
use App\Domain\Entities\BookLog; // 戻り値の型ヒント用に use
use Illuminate\Support\Collection; // Laravel Collection を使う場合

class ListBookLogsUseCase
{
    // 依存するものをプロパティとして定義 (PHP 8 の Constructor Property Promotion を使用)
    public function __construct(
        private readonly BookLogRepositoryInterface $bookLogRepository // ★ Repositoryインターフェースを注入
    ) {
    }

    /**
     * 読書記録の一覧を取得するユースケースを実行します。
     *
     * @return Collection<int, BookLog> BookLogエンティティのコレクション
     */
    public function execute(): Collection
    {
        // ★ リポジトリインターフェースのメソッドを呼び出してデータを取得
        return $this->bookLogRepository->findAll();
    }

    // __invoke メソッドを使えば、クラスインスタンスを関数のように呼び出せる
    // public function __invoke(): Collection
    // {
    //     return $this->execute();
    // }
}