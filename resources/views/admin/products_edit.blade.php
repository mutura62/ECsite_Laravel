<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>商品管理ページ</title>
    <link rel="stylesheet" href="{{ asset('css/admin_edit.css') }}">
    <script>
        // 新しい行を追加するJavaScript関数
        function addNewRow() {
            const table = document.getElementById('productTableBody');

            // 既存の行数を取得行数をIDとして利用
            const rowCount = table.getElementsByTagName('tr').length;
            const newId = rowCount + 1; // 行数 + 1 を新しいIDに

            // 新しい行を作成
            const newRow = document.createElement('tr');
            newRow.innerHTML = `
                <td><input type="text" name="products[${newId}][name]" placeholder="商品名"></td>
                <td><input type="text" name="products[${newId}][description]" placeholder="新規商品の説明"></td>
                <td><input type="number" name="products[${newId}][price]" placeholder="価格"></td>
                <td><input type="number" name="products[${newId}][stock]" placeholder="在庫数"></td>
            `;

            // 新しい行をテーブルに追加
            table.appendChild(newRow);
        }
    </script>
</head>

<body>

    <h1>商品管理ページ</h1>
    @if (session('success'))
        <div style="color: green; font-weight: bold;">
            {{ session('success') }}
        </div>
    @endif

    {{-- バリデーションエラー --}}
    @if ($errors->any())
        <div style="color: red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- 更新用フォーム -->
    <form action="{{ url('/admin/products/update') }}" method="POST">
        @csrf
        <!-- 商品情報の一覧テーブル -->
        <table>
            <tr>
                <th>商品名</th>
                <th>説明</th>
                <th>価格</th>
                <th>在庫数</th>
            </tr>

            <!-- 既存の商品情報 -->
            <tbody id="productTableBody">
                @foreach ($products as $product)
                    <tr>
                        <td><input type="text" placeholder="商品名" name="products[{{ $product->id }}][name]"
                                value="{{ $product->name }}"></td>
                        <td><input type="text" placeholder="新規商品の説明"
                                name="products[{{ $product->id }}][description]" value="{{ $product->description }}">
                        </td>
                        <td><input type="number" placeholder="価格" name="products[{{ $product->id }}][price]"
                                value="{{ $product->price }}"></td>
                        <td><input type="number" placeholder="在庫数" name="products[{{ $product->id }}][stock]"
                                value="{{ $product->stock }}"></td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- 新規行追加ボタン -->
        <button type="button" onclick="addNewRow()">新規行追加</button>

        <!-- 更新ボタン -->
        <button type="submit">更新</button>

        <!-- 管理画面トップに戻るリンク -->
        <p><a href="{{ url('/admin') }}" class="btn">管理画面トップに戻る</a></p>
    </form>

</body>

</html>
