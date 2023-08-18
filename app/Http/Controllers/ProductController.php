<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product; // Product モデルを使用するために追加


class ProductController extends Controller
{
    public function index()
    {
        return view('products.index');
    }
    // 商品一覧を表示する
    // 他のアクション（create、store、show、edit、update）の定義もここに追加することができます
    public function create()
    {
        return view('products.create');
    }
}