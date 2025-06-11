<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>読書ログを編集</title>
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
    </style>
</head>
<body class="bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 min-h-screen">
    <div class="container mx-auto px-4 py-8 max-w-4xl">
        <!-- ヘッダー -->
        <div class="text-center mb-8">
            <div class="book-card text-white rounded-2xl p-6 mb-6 shadow-2xl">
                <h1 class="text-4xl font-bold mb-2">✏️ 読書ログを編集</h1>
                <p class="text-lg opacity-90">{{ $bookLog->title }} の記録を更新</p>
            </div>
        </div>

        <!-- 編集フォーム -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8">
            <form action="{{ route('booklogs.update', $bookLog->id) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- タイトル -->
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                        📖 タイトル <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        id="title" 
                        name="title" 
                        value="{{ old('title', $bookLog->title) }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200"
                        required
                        placeholder="本のタイトルを入力してください"
                    >
                    @error('title')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- 著者 -->
                <div>
                    <label for="author" class="block text-sm font-medium text-gray-700 mb-2">
                        👤 著者 <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        id="author" 
                        name="author" 
                        value="{{ old('author', $bookLog->author) }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200"
                        required
                        placeholder="著者名を入力してください"
                    >
                    @error('author')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- 感想・メモ -->
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                        💭 感想・メモ
                    </label>
                    <textarea 
                        id="description" 
                        name="description" 
                        rows="6"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200"
                        placeholder="本の感想やメモを自由に書いてください..."
                    >{{ old('description', $bookLog->description) }}</textarea>
                    @error('description')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- 読了日 -->
                <div>
                    <label for="read_at" class="block text-sm font-medium text-gray-700 mb-2">
                        📅 読了日
                    </label>
                    <input 
                        type="date" 
                        id="read_at" 
                        name="read_at" 
                        value="{{ old('read_at', $bookLog->readAt ? $bookLog->readAt->format('Y-m-d') : '') }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200"
                    >
                    @error('read_at')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-sm text-gray-500">読了していない場合は空欄でも構いません</p>
                </div>

                <!-- ボタン -->
                <div class="flex space-x-4 pt-6">
                    <button 
                        type="submit"
                        class="flex-1 bg-gradient-to-r from-indigo-500 to-purple-600 text-white font-medium py-3 px-6 rounded-lg hover:from-indigo-600 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-all duration-200 shadow-lg hover:shadow-xl"
                    >
                        💾 更新する
                    </button>
                    <a 
                        href="{{ route('booklogs.index') }}"
                        class="flex-1 bg-gray-100 text-gray-700 font-medium py-3 px-6 rounded-lg hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-all duration-200 text-center"
                    >
                        ← 戻る
                    </a>
                </div>
            </form>
        </div>

        <!-- 記録情報 -->
        <div class="mt-6 bg-gray-50 rounded-lg p-4 text-sm text-gray-600">
            <div class="flex justify-between items-center">
                <span>作成日: {{ $bookLog->createdAt ? $bookLog->createdAt->format('Y年m月d日 H:i') : '不明' }}</span>
                <span>更新日: {{ $bookLog->updatedAt ? $bookLog->updatedAt->format('Y年m月d日 H:i') : '不明' }}</span>
            </div>
        </div>
    </div>

    <!-- 成功メッセージの表示 -->
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
</body>
</html>
