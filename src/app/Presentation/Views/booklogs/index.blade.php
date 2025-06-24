<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>読書ログ一覧</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@300;400;500;600;700&display=swap');
        body {
            font-family: 'Noto Sans JP', sans-serif;
        }
        .book-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            background-size: 200% 200%;
            animation: gradientShift 8s ease infinite;
        }
        @keyframes gradientShift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        .book-hover:hover {
            transform: translateY(-2px);
            transition: all 0.3s ease;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 min-h-screen">
    @if(session('success'))
        <div class="fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50" id="success-message">
            ✅ {{ session('success') }}
        </div>
        <script>
            setTimeout(() => {
                const successMessage = document.getElementById('success-message');
                if (successMessage) {
                    successMessage.style.opacity = '0';
                    setTimeout(() => successMessage.remove(), 300);
                }
            }, 3000);
        </script>
    @endif

    <div class="container mx-auto px-4 py-8 max-w-6xl">
        <!-- ヘッダー -->
        <div class="text-center mb-12">
            <div class="book-card text-white rounded-2xl p-8 mb-6 shadow-2xl">
                <h1 class="text-5xl font-bold mb-4">📚 読書ログ</h1>
                <p class="text-xl opacity-90">あなたの知識の旅を記録しましょう</p>
            </div>
        </div>

        <!-- 将来的に登録フォームへのリンクなどを置く -->
        <div class="mb-8 text-center">
            <button class="bg-white hover:bg-gray-50 text-gray-800 px-8 py-3 rounded-full font-medium shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-200">
                ➕ 新しい本を追加
            </button>
        </div>

        <!-- Controllerから渡された $bookLogs を使って一覧表示 -->
        @if ($bookLogs->isEmpty())
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-12 text-center">
                <div class="text-gray-300 text-8xl mb-6">📖</div>
                <h3 class="text-2xl font-bold text-gray-700 mb-3">まだ読書ログはありません</h3>
                <p class="text-gray-500 text-lg">最初の本を追加して、読書の記録を始めましょう！</p>
            </div>
        @else
            <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-3">
                {{-- 本来はエンティティではなくDTOをループするのが望ましい場合が多い --}}
                @foreach ($bookLogs as $log)
                    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6 book-hover">
                        <div class="flex flex-col h-full">
                            <!-- ステータスバッジ -->
                            <div class="flex justify-between items-start mb-4">
                                <div class="flex-1">
                                    @if ($log->readAt)
                                        <span class="bg-green-100 text-green-700 text-sm px-3 py-1 rounded-full font-medium">✅ 読了済み</span>
                                    @else
                                        <span class="bg-blue-100 text-blue-700 text-sm px-3 py-1 rounded-full font-medium">📖 読書中</span>
                                    @endif
                                </div>
                            </div>
                            
                            <!-- 本の情報 -->
                            <div class="flex-1">
                                <h3 class="text-xl font-bold text-gray-800 mb-2 line-clamp-2">{{ $log->title }}</h3>
                                <p class="text-gray-600 mb-4 flex items-center">
                                    <span class="mr-2">👤</span>
                                    <span class="font-medium">{{ $log->author }}</span>
                                </p>
                                
                                @if ($log->description)
                                    <div class="bg-gray-50 rounded-xl p-4 mb-4">
                                        <div class="flex items-center mb-2">
                                            <span class="text-sm font-medium text-gray-700">💭 メモ</span>
                                        </div>
                                        <p class="text-gray-700 text-sm leading-relaxed">{{ Str::limit($log->description, 120) }}</p>
                                    </div>
                                @endif
                            </div>
                            
                            <!-- 読了日 -->
                            <div class="border-t border-gray-100 pt-4 mt-4">
                                @if ($log->readAt)
                                    <div class="flex items-center text-sm text-gray-600 mb-3">
                                        <span class="mr-2">📅</span>
                                        <span>読了日: </span>
                                        <time class="font-medium text-gray-800 ml-1">
                                            {{ $log->readAt->format('Y年m月d日') }}
                                        </time>
                                    </div>
                                @endif
                                
                                <!-- アクションボタン -->
                                <div class="flex gap-2 mt-2">
                                    <a 
                                        href="{{ route('booklogs.edit', $log->id) }}"
                                        class="flex-1 bg-gradient-to-r from-indigo-500 to-purple-600 text-white text-center py-2 px-4 rounded-lg hover:from-indigo-600 hover:to-purple-700 transition-all duration-200 font-medium text-sm inline-block"
                                    >
                                        ✏️ 編集する
                                    </a>
                                    <form method="POST" action="{{ route('booklogs.destroy', $log->id) }}" class="flex-1" onsubmit="return confirmDelete(event)">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-full bg-gradient-to-r from-red-400 to-pink-500 text-white text-center py-2 px-4 rounded-lg hover:from-red-500 hover:to-pink-600 transition-all duration-200 font-medium text-sm inline-block">
                                            🗑️ 削除
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <!-- 統計情報 -->
            <div class="mt-12 bg-white rounded-2xl shadow-lg border border-gray-100 p-8">
                <h3 class="text-2xl font-bold text-gray-800 mb-6 text-center">📊 読書統計</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="text-center p-6 bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl">
                        <div class="text-4xl font-bold text-blue-600 mb-2">{{ $bookLogs->count() }}</div>
                        <div class="text-gray-700 font-medium">📚 総登録数</div>
                    </div>
                    <div class="text-center p-6 bg-gradient-to-br from-green-50 to-green-100 rounded-xl">
                        <div class="text-4xl font-bold text-green-600 mb-2">{{ $bookLogs->whereNotNull('readAt')->count() }}</div>
                        <div class="text-gray-700 font-medium">✅ 読了済み</div>
                    </div>
                    <div class="text-center p-6 bg-gradient-to-br from-orange-50 to-orange-100 rounded-xl">
                        <div class="text-4xl font-bold text-orange-600 mb-2">{{ $bookLogs->whereNull('readAt')->count() }}</div>
                        <div class="text-gray-700 font-medium">📖 読書中</div>
                    </div>
                </div>
            </div>
        @endif
        
        <!-- フッター -->
        <div class="mt-16 text-center text-gray-500 text-sm">
            <p>📚 読書を通じて、新しい世界を発見しよう</p>
        </div>
    </div>

    <script>
        function confirmDelete(event) {
            if (!confirm('本当に削除してよろしいですか？')) {
                event.preventDefault();
                return false;
            }
            return true;
        }
    </script>
</body>
</html>