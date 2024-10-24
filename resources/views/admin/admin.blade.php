<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>管理者ページ</title>
    <link rel="stylesheet" href="{{ asset('css/admin_top.css') }}">
</head>
<body>
    <h1>管理者ページ</h1>

    <form action="{{ url('/admin/products') }}" method="get">
        <button type="submit">商品管理</button>
    </form>

    <form action="{{ url('/admin/users') }}" method="get">
        <button type="submit">ユーザー管理</button>
    </form>

    <p>
        <a href="{{ url('/login') }}" class="btn">ログイン画面に戻る</a>
    </p>

</body>
</html>
