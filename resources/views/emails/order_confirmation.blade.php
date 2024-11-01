<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>購入完了のお知らせ</title>
</head>
<body>
    <h1>ご購入ありがとうございました！</h1>
    <p>{{ $order->user->name }}様、以下の商品をご購入いただきました。</p>
    
    <ul>
        @foreach ($order->orderItems as $item)
            <li>{{ $item->product->name }} - 数量: {{ $item->quantity }} - 価格: ¥{{ number_format($item->price) }}</li>
        @endforeach
    </ul>

    <p>合計金額: ¥{{ number_format($order->total_amount) }}</p>
    <p>またのご利用をお待ちしております。</p>
</body>
</html>
