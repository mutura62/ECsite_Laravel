<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>カートの内容</title>
    <link rel="stylesheet" href="{{ asset('css/payment.css') }}">
    <script src="https://js.stripe.com/v3/"></script>
</head>


<body>
    
    <h1>決済画面</h1>
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
                    <td>¥{{ $item->product->price }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <p><strong>合計金額: ¥{{ $cartItems->sum(fn($item) => $item->product->price * $item->quantity) }}</strong></p>

    <!-- 決済フォーム -->
    <form id="payment-form" action="{{ route('checkout.payment') }}" method="POST">
        @csrf
        <input type="hidden" name="payment_method_id" id="payment-method-id">

        <!-- 隠しフィールド stripeToken -->
        <input type="hidden" name="stripeToken" id="stripe-token">

        <!-- カード番号 -->
        <label for="card-number-element">カード番号</label>
        <div id="card-number-element"></div>

        <!-- 有効期限 -->
        <label for="card-expiry-element">有効期限</label>
        <div id="card-expiry-element"></div>

        <!-- セキュリティコード -->
        <label for="card-cvc-element">セキュリティコード</label>
        <div id="card-cvc-element"></div>

        <!-- 決済ボタン -->
        <button type="submit" class="buy-button">決済！</button>
    </form>

    <a href="{{ url('/top') }}">トップに戻る</a>

    <!-- Stripeの処理 -->
    <script>
        // Stripeの公開キーを設定
        const stripe = Stripe(
            "pk_test_51QBAdODmTmzR9ID4JjKl04sDbuRfyUzntoUWwaJYkNrRsoSKK6RRZUVeanLzF7HugLZYpzKDAxarad8sqcjRHC4c006iZnCQ0v"
        );

        // Stripe Elementsを初期化
        const elements = stripe.elements();

        // カード番号用
        const cardNumberElement = elements.create('cardNumber');
        cardNumberElement.mount('#card-number-element');
        // 有効期限用
        const cardExpiryElement = elements.create('cardExpiry');
        cardExpiryElement.mount('#card-expiry-element');
        // CVC用
        const cardCvcElement = elements.create('cardCvc');
        cardCvcElement.mount('#card-cvc-element');

        // フォームの送信処理
        const form = document.getElementById('payment-form');
        form.addEventListener('submit', async (event) => {
            event.preventDefault();

            const {
                token,
                error
            } = await stripe.createToken(cardNumberElement); // クレカ情報のトークンを作成

            if (error) {
                console.error(error);
            } else {
                console.log('クレカトークン:', token);
                // stripeTokenをフォームにセット
                document.getElementById('stripe-token').value = token.id;

                // フォーム送信を続行
                form.submit();
            }
        });
    </script>
</body>

</html>
