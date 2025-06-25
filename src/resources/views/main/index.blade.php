@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8">
    <h1 class="text-2xl font-bold mb-6">タイムライン</h1>
    <div class="space-y-6">
        @forelse ($bookLogs->sortByDesc('readAt') as $log)
            <div class="flex items-start gap-4 bg-white rounded shadow p-4">
                <div class="flex flex-col items-center">
                    <div class="w-3 h-3 rounded-full bg-blue-400 mb-1"></div>
                    <div class="h-full w-px bg-gray-300 flex-1"></div>
                </div>
                <div class="flex-1">
                    <div class="flex items-center gap-2 mb-1">
                        {{-- カテゴリバッジ（仮: すべて本）--}}
                        <span class="inline-block px-2 py-1 text-xs rounded bg-blue-100 text-blue-700 font-semibold">
                            {{ $log->category ?? '本' }}
                        </span>
                        <span class="text-xs text-gray-500">{{ $log->readAt ? $log->readAt->format('Y-m-d') : '' }}</span>
                    </div>
                    <div class="font-bold text-lg">{{ $log->title }}</div>
                    <div class="text-gray-700 text-sm mb-1">{{ $log->author }}</div>
                    @if ($log->description)
                        <div class="text-gray-500 text-xs mt-1">{{ $log->description }}</div>
                    @endif
                </div>
            </div>
        @empty
            <div class="text-gray-500">履歴がありません。</div>
        @endforelse
    </div>
    <div class="flex gap-4 mt-8">
        <a href="{{ route('booklogs.index') }}" class="btn btn-primary">本履歴一覧へ</a>
        <a href="#" class="btn btn-secondary">新しいカテゴリの記録を作成</a>
    </div>
</div>
@endsection
