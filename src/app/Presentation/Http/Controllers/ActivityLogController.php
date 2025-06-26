<?php

namespace App\Presentation\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
// ActivityLog用のUseCaseインターフェース（仮名）
use App\Application\UseCases\Queries\ActivityLog\ListActivityLogsQueryUseCaseInterface;
use App\Application\UseCases\Queries\ActivityLog\FindActivityLogByIdQueryUseCaseInterface;
use App\Application\UseCases\Commands\ActivityLog\CreateActivityLogCommandUseCaseInterface;
use App\Application\UseCases\Commands\ActivityLog\UpdateActivityLogCommandUseCaseInterface;
use App\Application\UseCases\Commands\ActivityLog\DeleteActivityLogCommandUseCaseInterface;

class ActivityLogController extends Controller
{
    private readonly ListActivityLogsQueryUseCaseInterface $listActivityLogsQueryUseCase;
    private readonly FindActivityLogByIdQueryUseCaseInterface $findActivityLogByIdQueryUseCase;
    private readonly CreateActivityLogCommandUseCaseInterface $createActivityLogCommandUseCase;
    private readonly UpdateActivityLogCommandUseCaseInterface $updateActivityLogCommandUseCase;
    private readonly DeleteActivityLogCommandUseCaseInterface $deleteActivityLogCommandUseCase;

    public function __construct(
        ListActivityLogsQueryUseCaseInterface $listActivityLogsQueryUseCase,
        FindActivityLogByIdQueryUseCaseInterface $findActivityLogByIdQueryUseCase,
        CreateActivityLogCommandUseCaseInterface $createActivityLogCommandUseCase,
        UpdateActivityLogCommandUseCaseInterface $updateActivityLogCommandUseCase,
        DeleteActivityLogCommandUseCaseInterface $deleteActivityLogCommandUseCase
    ) {
        $this->listActivityLogsQueryUseCase = $listActivityLogsQueryUseCase;
        $this->findActivityLogByIdQueryUseCase = $findActivityLogByIdQueryUseCase;
        $this->createActivityLogCommandUseCase = $createActivityLogCommandUseCase;
        $this->updateActivityLogCommandUseCase = $updateActivityLogCommandUseCase;
        $this->deleteActivityLogCommandUseCase = $deleteActivityLogCommandUseCase;
    }

    /**
     * カテゴリごとの履歴一覧
     */
    public function index(Request $request, string $category): View
    {
        $activityLogs = $this->listActivityLogsQueryUseCase->execute($category);
        return view('activitylogs.index', [
            'activityLogs' => $activityLogs,
            'category' => $category,
        ]);
    }

    /**
     * 詳細表示
     */
    public function show(string $category, string $id): View
    {
        $activityLog = $this->findActivityLogByIdQueryUseCase->execute($category, $id);
        if (!$activityLog) {
            abort(404);
        }
        return view('activitylogs.show', [
            'activityLog' => $activityLog,
            'category' => $category,
        ]);
    }

    /**
     * 作成
     */
    public function store(Request $request, string $category)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'activity_at' => 'nullable|date',
            'meta' => 'nullable|array',
        ]);
        $validatedData['category'] = $category;
        $activityLog = $this->createActivityLogCommandUseCase->execute($validatedData);
        return redirect()->route('activitylogs.index', ['category' => $category])
            ->with('success', '記録を作成しました。');
    }

    /**
     * 編集フォーム
     */
    public function edit(string $category, string $id): View
    {
        $activityLog = $this->findActivityLogByIdQueryUseCase->execute($category, $id);
        if (!$activityLog) {
            abort(404);
        }
        return view('activitylogs.edit', [
            'activityLog' => $activityLog,
            'category' => $category,
        ]);
    }

    /**
     * 更新
     */
    public function update(Request $request, string $category, string $id)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'activity_at' => 'nullable|date',
            'meta' => 'nullable|array',
        ]);
        $updateData = [
            'id' => $id,
            'category' => $category,
            'update_data' => $validatedData
        ];
        $activityLog = $this->updateActivityLogCommandUseCase->execute($updateData);
        if (!$activityLog) {
            abort(404);
        }
        return redirect()->route('activitylogs.index', ['category' => $category])
            ->with('success', '記録を更新しました。');
    }

    /**
     * 論理削除
     */
    public function destroy(string $category, string $id)
    {
        $this->deleteActivityLogCommandUseCase->execute($category, $id);
        return redirect()->route('activitylogs.index', ['category' => $category])
            ->with('success', '記録を削除しました。');
    }
}
