<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    // カートアイテム一覧を表示するメソッド
    public function getCartItems()
    {
        // ログインしているユーザーを取得
        $user = Auth::user();

        // ユーザーのカートを取得
        $cart = Cart::where('user_id', $user->id)->first();

        // カートが存在する場合はカートアイテムを取得
        $cartItems = [];
        if ($cart) {
            // カートに関連するすべてのカートアイテムを取得
            $cartItems = CartItem::where('cart_id', $cart->id)
                ->with('product') // 商品情報も一緒に取得
                ->get();
        }

        // dd($user,$cart,$cartItems);

        // cart.blade.phpにデータを渡して表示
        return view('user.cart', compact('cartItems'));
    }

    // カートに商品を追加するメソッド
    public function addToCart(Request $request, $productId)
    {
        // ログインユーザーを取得
        $user = Auth::user();

        DB::beginTransaction(); // トランザクション開始

        try {
            // ユーザーのカートを取得、なければ作成
            $cart = Cart::firstOrCreate(['user_id' => $user->id]);

            // 特定の商品のCartItemを取得（悲観ロック）
            $cartItem = CartItem::where('cart_id', $cart->id)
                ->where('product_id', $productId)
                ->lockForUpdate() // 悲観ロックを適用
                ->first();

            if ($cartItem) {
                // すでにカートにある場合は数量を更新
                $cartItem->quantity += $request->input('quantity', 1);
                $cartItem->save();
            } else {
                // 新規カートアイテムを作成
                CartItem::create([
                    'cart_id' => $cart->id,
                    'product_id' => $productId,
                    'quantity' => $request->input('quantity', 1),
                ]);
            }

            DB::commit(); // トランザクションをコミット
            return redirect()->back()->with('success', '商品をカートに追加しました。');
        } catch (\Exception $e) {
            DB::rollBack(); // 例外が発生したらロールバック
            return redirect()->back()->with('error', 'エラーが発生しました。');
        }
    }
}
