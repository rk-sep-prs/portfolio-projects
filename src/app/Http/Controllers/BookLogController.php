<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request; // Requestクラスは今回は使わないが、基本書式として入れておく
use Illuminate\View\View; // Viewの型ヒント用
use App\Application\UseCases\BookLog\ListBookLogsUseCase; // 作成したUseCaseをuse

class BookLogController extends Controller
{
    // UseCaseをプロパティとして定義
    private readonly ListBookLogsUseCase $listBookLogsUseCase;

    // コンストラクタでUseCaseを注入(DI)してもらう
    public function __construct(ListBookLogsUseCase $listBookLogsUseCase)
    {
        $this->listBookLogsUseCase = $listBookLogsUseCase;
    }

    /**
     * 読書記録の一覧を表示するアクション
     */
    public function index(): View // 戻り値はViewインスタンス
    {
        // UseCaseを実行して読書記録のリストを取得
        $bookLogs = $this->listBookLogsUseCase->execute();

        // 取得したデータを 'bookLogs' という名前で View に渡す
        return view('booklogs.index', ['bookLogs' => $bookLogs]);
    }

    // --- 今後、登録処理用の store() メソッドや、
    // --- 詳細表示用の show() メソッドなどを追加していく ---
}