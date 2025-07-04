<?php

namespace App\Presentation\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Application\UseCases\Queries\BookLog\ListBookLogsQueryUseCaseInterface;
use App\Application\UseCases\Queries\BookLog\FindBookLogByIdQueryUseCaseInterface;
use App\Application\UseCases\Commands\BookLog\CreateBookLogCommandUseCaseInterface;
use App\Application\UseCases\Commands\BookLog\UpdateBookLogCommandUseCaseInterface;
use App\Application\UseCases\Commands\BookLog\DeleteBookLogCommandUseCaseInterface;

class BookLogController extends Controller
{
    // CQRS UseCaseインターフェースをプロパティとして定義
    private readonly ListBookLogsQueryUseCaseInterface $listBookLogsQueryUseCase;
    private readonly FindBookLogByIdQueryUseCaseInterface $findBookLogByIdQueryUseCase;
    private readonly CreateBookLogCommandUseCaseInterface $createBookLogCommandUseCase;
    private readonly UpdateBookLogCommandUseCaseInterface $updateBookLogCommandUseCase;
    private readonly DeleteBookLogCommandUseCaseInterface $deleteBookLogCommandUseCase;

    // コンストラクタでCQRS UseCaseインターフェースを注入(DI)してもらう
    public function __construct(
        ListBookLogsQueryUseCaseInterface $listBookLogsQueryUseCase,
        FindBookLogByIdQueryUseCaseInterface $findBookLogByIdQueryUseCase,
        CreateBookLogCommandUseCaseInterface $createBookLogCommandUseCase,
        UpdateBookLogCommandUseCaseInterface $updateBookLogCommandUseCase,
        DeleteBookLogCommandUseCaseInterface $deleteBookLogCommandUseCase // 追加
    ) {
        $this->listBookLogsQueryUseCase = $listBookLogsQueryUseCase;
        $this->findBookLogByIdQueryUseCase = $findBookLogByIdQueryUseCase;
        $this->createBookLogCommandUseCase = $createBookLogCommandUseCase;
        $this->updateBookLogCommandUseCase = $updateBookLogCommandUseCase;
        $this->deleteBookLogCommandUseCase = $deleteBookLogCommandUseCase;
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
            'rating' => 'required|integer|min:1|max:10', // 必須に変更
        ]);

        $bookLog = $this->createBookLogCommandUseCase->execute($validatedData);

        return redirect()->route('booklogs.index')
            ->with('success', '読書記録を作成しました。');
    }

    /**
     * 読書記録の編集フォームを表示するアクション
     */
    public function edit(string $id): View
    {
        $bookLog = $this->findBookLogByIdQueryUseCase->execute($id);
        
        if (!$bookLog) {
            abort(404);
        }

        return view('booklogs.edit', ['bookLog' => $bookLog]);
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
            'rating' => 'required|integer|min:1|max:10', // 必須に変更
        ]);

        $updateData = [
            'id' => $id,
            'update_data' => $validatedData
        ];

        try {
            $bookLog = $this->updateBookLogCommandUseCase->execute($updateData);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput();
        }

        if (!$bookLog) {
            abort(404);
        }

        // YAGNI: showページは後で実装するので、一覧に戻る
        return redirect()->route('booklogs.index')
            ->with('success', '読書記録を更新しました。');
    }

    /**
     * 読書記録を論理削除するアクション
     */
    public function destroy(string $id)
    {
        $this->deleteBookLogCommandUseCase->execute($id);
        return redirect()->route('booklogs.index')
            ->with('success', '読書記録を削除しました。');
    }

    // --- 今後、登録フォーム表示用の create() メソッドや、
    // --- 編集フォーム表示用の edit() メソッドなどを追加していく ---
}