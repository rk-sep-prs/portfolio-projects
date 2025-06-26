<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>カテゴリ記録可視化アプリ</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50 min-h-screen">
    <div class="flex min-h-screen">
        <!-- サイドバー -->
        <aside class="w-64 bg-white shadow-lg flex flex-col py-6 px-4 rounded-r-2xl mr-8">
            <div class="mb-8 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-yellow-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><rect x="4" y="4" width="16" height="16" rx="2" fill="#FFEB3B" stroke="#FBC02D" stroke-width="1.5"/></svg>
                <span class="text-xl font-bold text-gray-800">MyLog</span>
            </div>
            <nav class="flex-1">
                <ul class="space-y-2">
                    <li>
                        <a href="#" class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-yellow-100 font-medium text-gray-800 text-base">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M3 6h18M3 12h18M3 18h18" stroke="#757575" stroke-width="2" stroke-linecap="round"/></svg>
                            ダッシュボード
                        </a>
                    </li>
                    <li>
                        <span class="block text-xs text-gray-400 mt-4 mb-1 ml-1">カテゴリ</span>
                        <ul class="space-y-1">
                            <li><a href="#" class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-blue-100 text-blue-700"><span class="w-2 h-2 rounded-full bg-blue-400"></span>本</a></li>
                            <li><a href="#" class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-green-100 text-green-700"><span class="w-2 h-2 rounded-full bg-green-400"></span>映画</a></li>
                            <li><a href="#" class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-pink-100 text-pink-700"><span class="w-2 h-2 rounded-full bg-pink-400"></span>アニメ</a></li>
                            <li><a href="#" class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-purple-100 text-purple-700"><span class="w-2 h-2 rounded-full bg-purple-400"></span>勉強</a></li>
                        </ul>
                        <button class="mt-3 w-full flex items-center gap-2 px-3 py-2 rounded-lg bg-gray-100 hover:bg-yellow-200 text-gray-700 text-sm font-semibold">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M12 4v16m8-8H4" stroke="#757575" stroke-width="2" stroke-linecap="round"/></svg>
                            カテゴリ追加
                        </button>
                    </li>
                    <li class="mt-6">
                        <a href="#" class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-gray-100 text-gray-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M19 7l-7 7-7-7" stroke="#757575" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            アーカイブ
                        </a>
                    </li>
                    <li>
                        <a href="#" class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-red-100 text-red-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M3 6h18M9 6v12m6-12v12" stroke="#e53e3e" stroke-width="2" stroke-linecap="round"/></svg>
                            ゴミ箱
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>
        <!-- メインコンテンツ -->
        <div class="flex-1 flex flex-col px-2 md:px-8 lg:px-16 xl:px-32 w-full max-w-7xl mx-auto">
            <nav class="bg-white shadow mb-6 rounded-lg px-8 py-4 flex items-center justify-between mt-8">
                <span class="text-2xl font-bold text-gray-800">ダッシュボード</span>
                <button class="flex items-center gap-2 px-4 py-2 bg-yellow-400 hover:bg-yellow-300 text-white font-bold rounded-lg shadow">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M12 4v16m8-8H4" stroke="#fff" stroke-width="2" stroke-linecap="round"/></svg>
                    新規記録
                </button>
            </nav>
            <main class="flex-1">
                <div class="flex flex-col gap-8 p-2">
                    <!-- カレンダー（ダミー） -->
                    <div class="bg-white rounded-xl shadow p-4 mb-2">
                        <div class="font-bold text-lg mb-2 flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><rect x="3" y="4" width="18" height="16" rx="2" fill="#E3F2FD" stroke="#42A5F5" stroke-width="1.5"/></svg>
                            カレンダー
                        </div>
                        <div class="grid grid-cols-7 gap-1 text-center text-xs">
                            <div class="font-bold">日</div><div class="font-bold">月</div><div class="font-bold">火</div><div class="font-bold">水</div><div class="font-bold">木</div><div class="font-bold">金</div><div class="font-bold">土</div>
                            <!-- 1日〜30日をダミーで表示、いくつかに色付き丸 -->
                            @for ($i = 1; $i <= 30; $i++)
                                <div class="py-1">
                                    <span class="inline-block w-6 h-6 rounded-full {{ in_array($i, [2,5,8,12,18,22,27]) ? 'bg-blue-200 text-blue-700 font-bold' : 'bg-gray-100 text-gray-500' }}">{{$i}}</span>
                                </div>
                            @endfor
                        </div>
                    </div>
                    <!-- グラフ（ダミー） -->
                    <div class="bg-white rounded-xl shadow p-4 mb-2">
                        <div class="font-bold text-lg mb-2 flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><rect x="3" y="4" width="18" height="16" rx="2" fill="#E8F5E9" stroke="#66BB6A" stroke-width="1.5"/></svg>
                            カテゴリ別活動グラフ
                        </div>
                        <div class="flex items-end gap-4 h-32 mt-4">
                            <div class="flex flex-col items-center w-12">
                                <div class="bg-blue-400 w-6 rounded-t h-16"></div>
                                <span class="text-xs mt-1 text-blue-700">本</span>
                            </div>
                            <div class="flex flex-col items-center w-12">
                                <div class="bg-green-400 w-6 rounded-t h-10"></div>
                                <span class="text-xs mt-1 text-green-700">映画</span>
                            </div>
                            <div class="flex flex-col items-center w-12">
                                <div class="bg-pink-400 w-6 rounded-t h-8"></div>
                                <span class="text-xs mt-1 text-pink-700">アニメ</span>
                            </div>
                            <div class="flex flex-col items-center w-12">
                                <div class="bg-purple-400 w-6 rounded-t h-6"></div>
                                <span class="text-xs mt-1 text-purple-700">勉強</span>
                            </div>
                        </div>
                    </div>
                    <!-- ダミーカード（縦並び） -->
                    <div class="flex flex-col gap-4">
                        <div class="bg-white rounded-xl shadow p-4 flex flex-col gap-2 border-l-4 border-blue-400">
                            <div class="flex items-center gap-2">
                                <span class="inline-block px-2 py-0.5 text-xs rounded bg-blue-100 text-blue-700 font-semibold">本</span>
                                <span class="text-xs text-gray-400">2025-06-26</span>
                            </div>
                            <div class="font-bold text-base">オブジェクト指向設計実践ガイド</div>
                            <div class="text-xs text-gray-600">Sandi Metz</div>
                            <div class="text-xs text-gray-500">Rubyを使ったオブジェクト指向設計の実践的な解説書。設計原則を具体例とともに学べる。</div>
                        </div>
                        <div class="bg-white rounded-xl shadow p-4 flex flex-col gap-2 border-l-4 border-green-400">
                            <div class="flex items-center gap-2">
                                <span class="inline-block px-2 py-0.5 text-xs rounded bg-green-100 text-green-700 font-semibold">映画</span>
                                <span class="text-xs text-gray-400">2025-06-20</span>
                            </div>
                            <div class="font-bold text-base">インセプション</div>
                            <div class="text-xs text-gray-600">クリストファー・ノーラン</div>
                            <div class="text-xs text-gray-500">夢の中の夢を舞台にしたSF映画。複雑な構造と映像美が魅力。</div>
                        </div>
                        <div class="bg-white rounded-xl shadow p-4 flex flex-col gap-2 border-l-4 border-pink-400">
                            <div class="flex items-center gap-2">
                                <span class="inline-block px-2 py-0.5 text-xs rounded bg-pink-100 text-pink-700 font-semibold">アニメ</span>
                                <span class="text-xs text-gray-400">2025-06-18</span>
                            </div>
                            <div class="font-bold text-base">鬼滅の刃</div>
                            <div class="text-xs text-gray-600">吾峠呼世晴</div>
                            <div class="text-xs text-gray-500">大正時代を舞台にしたダークファンタジーアニメ。家族愛と成長の物語。</div>
                        </div>
                        <div class="bg-white rounded-xl shadow p-4 flex flex-col gap-2 border-l-4 border-purple-400">
                            <div class="flex items-center gap-2">
                                <span class="inline-block px-2 py-0.5 text-xs rounded bg-purple-100 text-purple-700 font-semibold">勉強</span>
                                <span class="text-xs text-gray-400">2025-06-15</span>
                            </div>
                            <div class="font-bold text-base">Laravel実践開発</div>
                            <div class="text-xs text-gray-600">竹澤有貴</div>
                            <div class="text-xs text-gray-500">LaravelでのWebアプリケーション開発の実践的な内容。MVCからClean Architectureまで学べる。</div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
</body>
</html>
