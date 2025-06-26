@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto py-2 px-2">
    <h1 class="text-xl font-bold mb-4">{{ $category }} 履歴</h1>
    <div class="space-y-3">
        @forelse ($activityLogs->sortByDesc('activity_at') as $log)
            <div class="flex items-start gap-2 bg-white rounded shadow p-3 text-sm">
                <div class="flex flex-col items-center pt-1">
                    <div class="w-2 h-2 rounded-full bg-blue-400 mb-1"></div>
                    <div class="h-full w-px bg-gray-200 flex-1"></div>
                </div>
                <div class="flex-1">
                    <div class="flex items-center gap-2 mb-0.5">
                        <span class="inline-block px-1.5 py-0.5 text-xs rounded bg-blue-100 text-blue-700 font-semibold">
                            {{ $log->category }}
                        </span>
                        <span class="text-xs text-gray-500">{{ $log->activity_at ? \Carbon\Carbon::parse($log->activity_at)->format('Y-m-d') : '' }}</span>
                    </div>
                    <div class="font-bold text-base leading-tight">{{ $log->title }}</div>
                    <div class="text-gray-700 text-xs mb-0.5">{{ $log->author }}</div>
                    @if ($log->description)
                        <div class="text-gray-500 text-xs mt-0.5">{{ $log->description }}</div>
                    @endif
                </div>
            </div>
        @empty
            <div class="text-gray-500">履歴がありません。</div>
        @endforelse
    </div>
    <div class="flex gap-2 mt-6 text-sm">
        <a href="{{ route('main.index') }}" class="btn btn-secondary">ダッシュボードへ戻る</a>
        <a href="#" class="btn btn-primary">新しい記録を作成</a>
    </div>
</div>
@endsection
