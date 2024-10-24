<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // ユーザー一覧を表示するメソッド
    public function index()
    {
        // ユーザー情報をすべて取得
        $users = User::all();

        // user_edit.blade.phpにデータを渡して表示
        return view('admin.users_edit', compact('users'));
    }

    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'users.*.name' => 'required|string|max:255',
            // 'users.*.password' => 'required',
            'users.*.email' => 'required|email',
            'users.*.address' => 'required',
            'users.*.is_admin' => 'required|integer',
        ], [
            'users.*.name.required' => '名前は必須です。',
            // 'users.*.password.required' => 'パスワードは必須です。',
            'users.*.stock.required' => '在庫は必須です。',
            'users.*.address.required' => '住所は必須です。',
            'users.*.is_admin.required' => '管理者ステータスは必須です。',
        ]);
        // dd($request->users,$request);
        foreach ($request->users as $id => $userData) {
            $user = User::find($id);
            if ($user) {
                $user->name = $userData['name'];
                $user->email = $userData['email'];
                $user->address = $userData['address'];
                $user->is_admin = $userData['is_admin'];

                // パスワードが入力されている場合のみ更新
                if (!empty($userData['password'])) {
                    $user->password = bcrypt($userData['password']);
                }

                $user->save();
            } else {
                // 商品が存在しない場合、新規商品として追加（
                $newUser = new User();
                $newUser->name = $userData['name'];
                $newUser->password = bcrypt($userData['password']);
                $newUser->email = $userData['email'];
                $newUser->address = $userData['address'];
                $newUser->is_admin = $userData['is_admin'];

                // 新規商品を保存
                $newUser->save();
            }
        }
        return redirect()->back()->with('success', 'ユーザー情報が更新されました。');
    }
}
