<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order; // Orderモデルがある場合
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function showOrderHistory()
    {
        // ログイン中のユーザーの注文履歴を取得
        $user = Auth::user();
        $orderItems = Order::where('user_id', $user->id)
            ->with('orderItems.product') // orderItemsの中の各商品の詳細も取得
            ->get()
            ->flatMap->orderItems; // 各注文のアイテムをまとめて取得

        // ビューにデータを渡す
        return view('user.profile', compact('orderItems'));
    }
}