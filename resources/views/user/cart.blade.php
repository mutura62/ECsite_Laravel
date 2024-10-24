<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>カートの内容</title>
    <link rel="stylesheet" href="{{ asset('css/cart.css') }}">
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

    <h1>カート</h1>

    @if (empty($cartItems) || $cartItems->isEmpty())
        <p>カートに商品がありません。</p>
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
                @foreach ($cartItems as $item)
                    <tr>
                        <td>{{ $item->product->name }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>¥{{ number_format($item->product->price) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <p><strong>合計金額: ¥{{ number_format($cartItems->sum(fn($item) => $item->product->price * $item->quantity)) }}</strong></p>
        <a href="{{ url('/payment') }}" class="buy-button">購入</a>

        @endif
    <a href="{{ url('/top') }}">トップに戻る</a>
</body>

</html>
