<?php

namespace App\Presentation\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Application\UseCases\Queries\BookLog\ListBookLogsQueryUseCaseInterface;
use App\Application\UseCases\Queries\BookLog\FindBookLogByIdQueryUseCaseInterface;
use App\Application\UseCases\Commands\BookLog\CreateBookLogCommandUseCaseInterface;
use App\Application\UseCases\Commands\BookLog\UpdateBookLogCommandUseCaseInterface;

class BookLogController extends Controller
{
    // CQRS UseCaseインターフェースをプロパティとして定義
    private readonly ListBookLogsQueryUseCaseInterface $listBookLogsQueryUseCase;
    private readonly FindBookLogByIdQueryUseCaseInterface $findBookLogByIdQueryUseCase;
    private readonly CreateBookLogCommandUseCaseInterface $createBookLogCommandUseCase;
    private readonly UpdateBookLogCommandUseCaseInterface $updateBookLogCommandUseCase;

    // コンストラクタでCQRS UseCaseインターフェースを注入(DI)してもらう
    public function __construct(
        ListBookLogsQueryUseCaseInterface $listBookLogsQueryUseCase,
        FindBookLogByIdQueryUseCaseInterface $findBookLogByIdQueryUseCase,
        CreateBookLogCommandUseCaseInterface $createBookLogCommandUseCase,
        UpdateBookLogCommandUseCaseInterface $updateBookLogCommandUseCase
    ) {
        $this->listBookLogsQueryUseCase = $listBookLogsQueryUseCase;
        $this->findBookLogByIdQueryUseCase = $findBookLogByIdQueryUseCase;
        $this->createBookLogCommandUseCase = $createBookLogCommandUseCase;
        $this->updateBookLogCommandUseCase = $updateBookLogCommandUseCase;
    }

    /**
     * 読書記録の一覧を表示するアクション
     */
    public function index(): View // 戻り値はViewインスタンス
    {
        // Query UseCaseを実行して読書記録のリストを取得
        $bookLogs = $this->listBookLogsQueryUseCase->execute();

        // 取得したデータを 'bookLogs' という名前で View に渡す
        return view('booklogs.index', ['bookLogs' => $bookLogs]);
    }

    /**
     * 読書記録の詳細を表示するアクション
     */
    public function show(string $id): View
    {
        $bookLog = $this->findBookLogByIdQueryUseCase->execute($id);
        
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

        $bookLog = $this->createBookLogCommandUseCase->execute($validatedData);

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

        $bookLog = $this->updateBookLogCommandUseCase->execute($updateData);

        if (!$bookLog) {
            abort(404);
        }

        return redirect()->route('booklogs.show', $id)
            ->with('success', '読書記録を更新しました。');
    }

    // --- 今後、登録フォーム表示用の create() メソッドや、
    // --- 編集フォーム表示用の edit() メソッドなどを追加していく ---
}