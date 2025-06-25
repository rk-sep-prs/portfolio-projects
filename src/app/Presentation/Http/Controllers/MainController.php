<?php

declare(strict_types=1);

namespace App\Presentation\Http\Controllers;

use App\Application\UseCases\Queries\BookLog\ListBookLogsQueryUseCaseInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class MainController extends Controller
{
    private ListBookLogsQueryUseCaseInterface $listBookLogsQueryUseCase;

    public function __construct(ListBookLogsQueryUseCaseInterface $listBookLogsQueryUseCase)
    {
        $this->listBookLogsQueryUseCase = $listBookLogsQueryUseCase;
    }

    public function index()
    {
        // BookLog一覧を取得
        $bookLogs = $this->listBookLogsQueryUseCase->execute();

        // 仮カテゴリデータ（本来はDBやリポジトリから取得）
        $categories = [
            ['id' => 1, 'name' => '本'],
            ['id' => 2, 'name' => '映画'],
            ['id' => 3, 'name' => 'アニメ'],
        ];

        // カレンダー用の仮データ（本来は履歴やアクションから生成）
        $calendarActions = [
            '2025-06-20' => true,
            '2025-06-22' => true,
            '2025-06-25' => true,
        ];

        return view('main.index', [
            'bookLogs' => $bookLogs,
            'categories' => $categories,
            'calendarActions' => $calendarActions,
        ]);
    }
}
