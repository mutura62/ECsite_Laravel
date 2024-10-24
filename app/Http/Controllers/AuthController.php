<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // ログインフォームを表示する
    public function showLoginForm()
    {
        return view('login');
    }

    // ログイン処理
    public function login(Request $request)
    {
        // 入力されたメールアドレスとパスワードを取得
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // ログイン成功
            $user = Auth::user();  // 現在ログインしているユーザーを取得

            if ($user->is_admin) {
                // 管理者なら管理者ページにリダイレクト
                return redirect()->intended('/admin');
            } else {
                // 一般ユーザーならユーザーページにリダイレクト
                return redirect()->intended('/top');
            }
        }

        // 認証失敗時
        return redirect()->back()->with('error', 'メールアドレスまたはパスワードが間違っています。');
    }
}
