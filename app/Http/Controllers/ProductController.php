<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // 商品一覧を表示するメソッド
    public function index()
    {
        // 商品情報をすべて取得
        $products = Product::all();

        return view('admin.products_edit', compact('products'));
    }

    public function userTop()
    {
        // 商品情報をすべて取得
        $products = Product::all();

        return view('user.top', compact('products'));
    }

    public function update(Request $request)
    {
        // バリデーション
        $validatedData = $request->validate([
            'products.*.name' => 'required|string|max:255', // 商品名は必須
            'products.*.price' => 'required|numeric|min:0', // 金額は必須かつ0以上
            'products.*.stock' => 'required|integer|min:0', // 在庫は必須かつ0以上
        ], [
            'products.*.name.required' => '商品名は必須です。',
            'products.*.price.required' => '価格は必須です。',
            'products.*.price.min' => '価格は0以上である必要があります。',
            'products.*.stock.required' => '在庫は必須です。',
            'products.*.stock.min' => '在庫は0以上である必要があります。',
        ]);

        foreach ($request->products as $id => $productData) {
            // 商品IDで商品を検索
            $product = Product::find($id);

            if ($product) {
                // 既存商品のフィールドを個別に更新
                $product->name = $productData['name'];
                $product->description = $productData['description'];
                $product->price = $productData['price'];
                $product->stock = $productData['stock'];

                // 更新を保存
                $product->save();
            } else {
                // 商品が存在しない場合、新規商品として追加（
                $newProduct = new Product();
                $newProduct->name = $productData['name'];
                $newProduct->description = $productData['description'];
                $newProduct->price = $productData['price'];
                $newProduct->stock = $productData['stock'];

                // 新規商品を保存
                $newProduct->save();
            }
        }
        return redirect()->back()->with('success', '商品情報が更新されました。');
    }
}
