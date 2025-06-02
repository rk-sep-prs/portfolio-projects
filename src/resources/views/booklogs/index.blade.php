<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>読書ログ一覧</title>
    {{-- ここにCSSなどを読み込むリンクを追加できます --}}
</head>
<body>
    <h1>読書ログ一覧</h1>

    {{-- 将来的に登録フォームへのリンクなどを置く --}}
    {{-- <a href="#">新規登録</a> --}}

    <hr>

    {{-- Controllerから渡された $bookLogs を使って一覧表示 --}}
    @if ($bookLogs->isEmpty())
        <p>まだ読書ログはありません。</p>
    @else
        <ul>
            {{-- 本来はエンティティではなくDTOをループするのが望ましい場合が多い --}}
            @foreach ($bookLogs as $log)
                <li>
                    <strong>{{ $log->title }}</strong> / {{ $log->author }}
                    @if ($log->impression)
                        <p>{{ Str::limit($log->impression, 100) }}</p> {{-- 感想を100文字に制限して表示 (例) --}}
                    @endif
                    {{-- 評価や読了日なども表示 --}}
                </li>
            @endforeach
        </ul>
    @endif

</body>
</html>