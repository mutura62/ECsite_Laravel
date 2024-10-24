<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ログイン</title>
    <!-- CSSファイルの読み込み -->
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>
<body>
    <h1>ログイン</h1>
    <p>管理者ID: Kinoshita@example.com</p>
    <p>Pass: password</p>

    <p>一般ID: mutsura@example.com</p>
    <p>Pass: password</p>

    <!-- エラーメッセージの表示 -->
    @if (session('error'))
        <div>
            <p>{{ session('error') }}</p>
        </div>
    @endif

    <form action="{{ route('login') }}" method="POST">
        @csrf
        <div>
            <label for="email">メールアドレス:</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}" required>
        </div>
        <div>
            <label for="password">パスワード:</label>
            <input type="password" name="password" id="password" required>
        </div>
        <div>
            <button type="submit">ログイン</button>
        </div>
    </form>
</body>
</html>
