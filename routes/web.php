<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PaymentController;



Route::get('/', function () {
    return view('welcome');
});

// ログイン画面のルート
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
//管理者ページ
Route::get('/admin/products', [ProductController::class, 'index'])->middleware('auth');
Route::post('/admin/products/update', [ProductController::class, 'update'])->middleware('auth');
Route::get('/admin/users', [UserController::class, 'index'])->middleware('auth');
Route::post('/admin/users/update', [UserController::class, 'update'])->middleware('auth');
//ユーザーページ
Route::get('/top', [ProductController::class, 'userTop'])->middleware('auth');
Route::post('/cart/add/{productId}', [CartController::class, 'addToCart'])->middleware('auth');
Route::get('/profile', [ProfileController::class, 'showOrderHistory'])->name('profile')->middleware('auth');

//カートページ
Route::get('/cart', [CartController::class, 'getCartItems'])->middleware('auth');
Route::get('/cart', [CartController::class, 'getCartItems'])->name('cart')->middleware('auth');

//決済ページ
Route::get('/payment', [PaymentController::class, 'getCartItems'])->middleware('auth');
Route::post('/store', [PaymentController::class, 'store'])->middleware('auth');
Route::post('/checkout/payment', [PaymentController::class, 'handlePayment'])->name('checkout.payment');



Route::get('/admin', function () {
    return view('admin.admin');
})->middleware('auth');
