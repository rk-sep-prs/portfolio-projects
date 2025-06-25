@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8">
    <h1 class="text-2xl font-bold mb-6">メインページ</h1>
    <!-- カテゴリ・履歴一覧表示エリア -->
    <div class="mb-8">
        <h2 class="text-xl font-semibold mb-2">カテゴリ別履歴</h2>
        <div class="bg-white rounded shadow p-4">
            <ul>
                @foreach ($categories as $category)
                    <li class="font-bold mt-2">{{ $category['name'] }}</li>
                    <ul class="ml-4 mb-2">
                        @foreach ($bookLogs as $log)
                            {{-- 仮: カテゴリ判定は未実装。全て表示 --}}
                            <li>
                                <span class="text-gray-700">{{ $log->title }}</span>（{{ $log->author }}）
                                @if ($log->readAt)
                                    <span class="text-xs text-gray-500">{{ $log->readAt->format('Y-m-d') }}</span>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                @endforeach
            </ul>
        </div>
    </div>
    <!-- カレンダー表示エリア -->
    <div class="mb-8">
        <h2 class="text-xl font-semibold mb-2">アクションカレンダー</h2>
        <div class="bg-white rounded shadow p-4">
            <div class="grid grid-cols-7 gap-2">
                @php
                    $today = new DateTime('2025-06-25');
                    $start = (clone $today)->modify('-15 days');
                    for ($i = 0; $i < 30; $i++) {
                        $date = (clone $start)->modify("+{$i} days");
                        $dateStr = $date->format('Y-m-d');
                        $isAction = $calendarActions[$dateStr] ?? false;
                @endphp
                    <div class="text-center p-2 border rounded {{ $isAction ? 'bg-green-200' : 'bg-gray-100' }}">
                        {{ $date->format('m/d') }}
                        @if ($isAction)
                            <span class="text-green-600">✔</span>
                        @endif
                    </div>
                @php } @endphp
            </div>
        </div>
    </div>
    <!-- リンクエリア -->
    <div class="flex gap-4">
        <a href="{{ route('booklogs.index') }}" class="btn btn-primary">本履歴一覧へ</a>
        <a href="#" class="btn btn-secondary">新しいカテゴリの記録を作成</a>
    </div>
</div>
@endsection
