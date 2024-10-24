<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ユーザー管理ページ</title>
    <link rel="stylesheet" href="{{ asset('css/admin_edit.css') }}">
    <script>
        // 新しい行を追加するJavaScript関数
        function addNewRow() {
            const table = document.getElementById('userTableBody');

            // 既存の行数を取得行数をIDとして利用
            const rowCount = table.getElementsByTagName('tr').length;
            const newId = rowCount + 1; // 行数 + 1 を新しいIDに

            // 新しい行を作成
            const newRow = document.createElement('tr');
            newRow.innerHTML = `
                <td><input type="text" name="users[${newId}][name]" placeholder="名前"></td>
                <td><input type="text" name="users[${newId}][password]" placeholder="パスワード"></td>
                <td><input type="text" name="users[${newId}][email]" placeholder="メールアドレス"></td>
                <td><input type="text" name="users[${newId}][address]" placeholder="住所"></td>
                <td><input type="number" name="users[${newId}][is_admin]" placeholder="管理者ステータス"></td>
            `;
            // 新しい行をテーブルに追加
            table.appendChild(newRow);
        }
    </script>
</head>

<body>

    <h1>ユーザー管理ページ</h1>
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
    <form action="{{ url('/admin/users/update') }}" method="POST">
        @csrf
        <!-- ユーザー情報の一覧テーブル -->
        <table>
            <tr>
                <th>名前</th>
                <th>パスワード</th>
                <th>メールアドレス</th>
                <th>住所</th>
                <th>管理者ステータス</th>
            </tr>

            <!-- 既存のユーザー情報 -->
            <tbody id="userTableBody">
                @foreach ($users as $user)
                    <tr>
                        <td><input type="text" placeholder="名前" name="users[{{ $user->id }}][name]"
                                value="{{ $user->name }}"></td>
                        <td><input type="text" placeholder="パスワード（変更する場合のみ入力）"
                                name="users[{{ $user->id }}][password]"></td>
                        <td><input type="text" placeholder="メールアドレス" name="users[{{ $user->id }}][email]"
                                value="{{ $user->email }}"></td>
                        <td><input type="text" placeholder="住所" name="users[{{ $user->id }}][address]"
                                value="{{ $user->address }}"></td>
                        <td><input type="number" placeholder="管理者ステータス" name="users[{{ $user->id }}][is_admin]"
                                value="{{ $user->is_admin }}"></td>
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
