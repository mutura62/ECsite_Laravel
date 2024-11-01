<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>トップページ</title>
    <link rel="stylesheet" href="{{ asset('css/top.css') }}">
</head>

<body>

    <!-- ヘッダー -->
    <header>
        <!-- 検索バー -->
        <div class="search-bar">
            <input type="text" placeholder="商品を検索">
            <button>検索</button>
        </div>

        <!-- ユーザー情報とカート -->
        <div class="user-cart">
            <div>
                <button onclick="location.href='{{ url('/profile') }}'">{{ Auth::user()->name }}</button>
            </div>
            <div>
                <button onclick="location.href='{{ url('/cart') }}'">カートを見る</button>
            </div>
        </div>
    </header>

    @if (session('success'))
        <div style="color: green; font-weight: bold;">
            {{ session('success') }}
        </div>
    @endif

    <!-- 商品情報 -->
    <main>
        <h1>商品一覧</h1>
        <div style="display: flex; flex-wrap: wrap; gap: 75px;">
            @foreach ($products as $product)
                <div class="product-item">
                    <h2>{{ $product->name }}</h2>
                    <p>{{ $product->description }}</p>
                    <p>¥{{ $product->price }}</p>

                    <!-- カートに追加するフォーム -->
                    <form action="{{ url('/cart/add/' . $product->id) }}" method="POST">
                        @csrf
                        <button type="submit">カートに追加</button>
                    </form>
                </div>
            @endforeach
        </div>

    </main>
</body>

</html>
