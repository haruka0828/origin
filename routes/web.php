<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
// 商品一覧ページの表示と検索機能
Route::get('/products', [App\Http\Controllers\ProductController::class, 'index'])->name('products.index');
// 商品のメーカー検索と価格在庫範囲検索を非同期で実行するルート
Route::get('/products/search', [App\Http\Controllers\ProductController::class, 'search'])->name('products.search');
// 商品登録ページの表示
Route::get('/products/create', [App\Http\Controllers\ProductController::class, 'create'])->name('products.create');
// 商品登録処理
Route::post('/products', [App\Http\Controllers\ProductController::class, 'store'])->name('products.store');
// 商品詳細
Route::get('/show/{id}', [App\Http\Controllers\ProductController::class, 'show'])->name('products.show');
// 商品削除
Route::delete('/products/{product}', [App\Http\Controllers\ProductController::class, 'destroy'])->name('products.destroy');
// 商品編集
Route::get('/products/{product}/edit', [App\Http\Controllers\ProductController::class, 'edit'])->name('products.edit');
// 更新処理
Route::put('/products/{product}', [App\Http\Controllers\ProductController::class, 'update'])->name('products.update');