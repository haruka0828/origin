<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product; // Product モデルを使用するために追加
use App\Models\Company; // Company モデルを追加

class ProductController extends Controller
{
    
    public function index(Request $request)
    {
    $query = Product::with('company');

    // 商品名の部分一致検索
    if ($request->has('product_search')) {
        $query->where('product_name', 'like', '%' . $request->input('product_search') . '%');
    }

    // メーカー選択による絞り込み
    if ($request->has('company_name')) {
        $query->where('company_id', $request->input('company_name'));
    }

    $products = $query->get();
    $companies = Company::pluck('company_name', 'id'); // 企業名一覧を取得

    return view('products.index', compact('products', 'companies'));
    }

    public function destroy($id)
    {
    $product = Product::findOrFail($id);
    $product->delete();
    return redirect()->route('products.index')->with('status', '商品を削除しました');
    }

    public function create()
    {
    $companies = Company::pluck('company_name', 'id'); // 企業名一覧を取得（セレクトボックス用）
    return view('products.create', compact('companies')); // 登録画面ビューを表示
    }
    
    
    // フォームデータをダンプして確認
    //dd($request->all());
   
        

    public function store(Request $request) 
    {
    // カンパニーIDの取得
    $companyName = $request->input('company_name');
    $company = Company::find($companyName);

    // 商品情報の取得
    $productInfo = [
        'product_name' => $request->input('product_name'),
        'price' => $request->input('price'),
        'stock' => $request->input('stock'),
        'comment' => $request->input('comment'),
        'img_pass'=> $request->input('img_pass'),
    ];

    // カンパニーIDを関連付け
    $productInfo['company_id'] = $company->id;

    if ($request->hasFile('img_pass')) {
        $imagePath = $request->file('img_pass')->store('images', 'public');
        $productInfo['img_pass'] = $imagePath;
    }
    
    // 商品情報をデータベースに登録
    Product::create($productInfo);

    return redirect()->route('products.index');
    }
   
    
    public function show($id)
    {
    $product = Product::findOrFail($id); // 指定された商品データを取得
    return view('products.show', compact('product')); // 詳細画面ビューを表示
    }
    
    public function edit($id)
    {
    $product = Product::findOrFail($id); // 指定された商品データを取得
    $companies = Company::all(); // すべての企業情報を取得
    return view('products.edit', compact('product', 'companies')); // 編集画面ビューを表示
    }

    public function update(Request $request, $id)
    {
    $product = Product::findOrFail($id);
    
     // フォームデータを更新
     $product->product_name = $request->input('product_name');
     $product->price = $request->input('price');
     $product->stock = $request->input('stock');
     $product->company_id = $request->input('company_id'); 
     $product->comment = $request->input('comment');
    
    $product->save();
    return redirect()->route('products.index',$product->id);        
    }
}
