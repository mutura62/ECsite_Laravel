<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>プロフィール</title>
    <link rel="stylesheet" href="{{ asset('css/order.css') }}">
</head>

<body>
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <h1>購入履歴</h1>

    @if ($orderItems->isEmpty())
        <p>購入履歴はありません。</p>
    @else
        <table border="1">
            <thead>
                <tr>
                    <th>商品名</th>
                    <th>数量</th>
                    <th>価格</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orderItems as $item)
                    <tr>
                        <td>{{ $item->product->name }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>¥{{ number_format($item->product->price) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
    <a href="{{ url('/top') }}">トップに戻る</a>
</body>

</html>
