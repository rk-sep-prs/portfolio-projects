<?php

namespace App\Presentation\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Application\Interactors\BookLog\ListBookLogsInteractor;
use App\Application\Interactors\BookLog\FindBookLogByIdInteractor;
use App\Application\Interactors\BookLog\CreateBookLogInteractor;
use App\Application\Interactors\BookLog\UpdateBookLogInteractor;

class BookLogController extends Controller
{
    // Interactorをプロパティとして定義
    private readonly ListBookLogsInteractor $listBookLogsInteractor;
    private readonly FindBookLogByIdInteractor $findBookLogByIdInteractor;
    private readonly CreateBookLogInteractor $createBookLogInteractor;
    private readonly UpdateBookLogInteractor $updateBookLogInteractor;

    // コンストラクタでInteractorを注入(DI)してもらう
    public function __construct(
        ListBookLogsInteractor $listBookLogsInteractor,
        FindBookLogByIdInteractor $findBookLogByIdInteractor,
        CreateBookLogInteractor $createBookLogInteractor,
        UpdateBookLogInteractor $updateBookLogInteractor
    ) {
        $this->listBookLogsInteractor = $listBookLogsInteractor;
        $this->findBookLogByIdInteractor = $findBookLogByIdInteractor;
        $this->createBookLogInteractor = $createBookLogInteractor;
        $this->updateBookLogInteractor = $updateBookLogInteractor;
    }

    /**
     * 読書記録の一覧を表示するアクション
     */
    public function index(): View // 戻り値はViewインスタンス
    {
        // Interactorを実行して読書記録のリストを取得
        $bookLogs = $this->listBookLogsInteractor->execute();

        // 取得したデータを 'bookLogs' という名前で View に渡す
        return view('booklogs.index', ['bookLogs' => $bookLogs]);
    }

    /**
     * 読書記録の詳細を表示するアクション
     */
    public function show(string $id): View
    {
        $bookLog = $this->findBookLogByIdInteractor->execute($id);
        
        if (!$bookLog) {
            abort(404);
        }

        return view('booklogs.show', ['bookLog' => $bookLog]);
    }

    /**
     * 読書記録を作成するアクション
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'description' => 'nullable|string',
            'read_at' => 'nullable|date',
        ]);

        $bookLog = $this->createBookLogInteractor->execute($validatedData);

        return redirect()->route('booklogs.index')
            ->with('success', '読書記録を作成しました。');
    }

    /**
     * 読書記録を更新するアクション
     */
    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'description' => 'nullable|string',
            'read_at' => 'nullable|date',
        ]);

        $updateData = [
            'id' => $id,
            'update_data' => $validatedData
        ];

        $bookLog = $this->updateBookLogInteractor->execute($updateData);

        if (!$bookLog) {
            abort(404);
        }

        return redirect()->route('booklogs.show', $id)
            ->with('success', '読書記録を更新しました。');
    }

    // --- 今後、登録フォーム表示用の create() メソッドや、
    // --- 編集フォーム表示用の edit() メソッドなどを追加していく ---
}