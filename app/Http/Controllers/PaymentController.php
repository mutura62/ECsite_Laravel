<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Mail\OrderConfirmationMail;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Stripe\Stripe;
use Stripe\Charge;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class PaymentController extends Controller
{

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
        return view('user.payment', compact('cartItems'));
    }

    public function handlePayment(Request $request)
    {
        DB::beginTransaction(); // トランザクション開始

        $user = Auth::user();
        $cart = Cart::where('user_id', $user->id)->first();

        if (!$cart) {
            return redirect()->back()->withErrors('カートが空です');
        }

        $cartItems = CartItem::where('cart_id', $cart->id)->get();
        $totalAmount = $cartItems->sum(function ($cartItem) {
            return $cartItem->product->price * $cartItem->quantity;
        });
        Stripe::setApiKey('sk_test_51QBAdODmTmzR9ID4FCX0hiCVCoCo0HPsneD8imkX1ilD0mVTGNNw9jnkScofDYqpj1JKSnyjljuZeTjLMh4sEixc00ayccG1hA');

        try {
            $charge = Charge::create([
                'amount' => $totalAmount * 100, // 円を基準にする場合、Stripeは最小単位で金額を設定
                'currency' => 'jpy',
                'source' => $request->stripeToken,
                'description' => '商品の購入',
            ]);

            // ① ordersテーブルとorder_itemsテーブルにレコードを追加
            $newOrder = new Order();
            $newOrder->user_id = $user->id;
            $newOrder->total_amount = $totalAmount;
            $newOrder->save();

            foreach ($cartItems as $cartItem) {
                $newOrderItem = new OrderItem();
                $newOrderItem->order_id = $newOrder->id;
                $newOrderItem->product_id = $cartItem->product_id;
                $newOrderItem->quantity = $cartItem->quantity;
                $newOrderItem->price = $cartItem->product->price;
                $newOrderItem->save();
            }

            // ② productsテーブルの在庫を減らす
            foreach ($cartItems as $cartItem) {
                $product = $cartItem->product;

                if ($product->stock >= $cartItem->quantity) {
                    $product->stock -= $cartItem->quantity;
                    $product->save();
                } else {
                    throw new \Exception('在庫が不足しています: ' . $product->name);
                }
            }

            // ③ cartsテーブルとcart_itemsテーブルのレコードを削除
            CartItem::where('cart_id', $cart->id)->delete();
            $cart->delete();

            // メール送信
            $newOrder->load('user', 'orderItems.product');
            Mail::to($user->email)->send(new OrderConfirmationMail($newOrder));

            DB::commit(); // トランザクションをコミット
            return redirect()->route('cart')->with('success', '決済が完了しました！');
        } catch (\Exception $e) {
            DB::rollBack(); // 例外が発生したらロールバック
            return redirect()->route('cart')->with('error', '決済エラーが発生しました: ' . $e->getMessage());
        }
    }
}
