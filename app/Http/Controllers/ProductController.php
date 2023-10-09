<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product; // Product モデルを追加
use App\Models\Company; // Company モデルを追加
use Illuminate\Support\Facades\DB; //トランザクション使用

class ProductController extends Controller
{
    public function index(Request $request)
    {   
        $sortColumn = $request->input('sort_column', 'id');
        $sortOrder = $request->input('sort_order', 'asc');
        $productSearch = $request->input('product_search', '');
        $companyName = $request->input('company_name', '');
        $companies = Company::pluck('company_name', 'id');
        $minPrice = $request->input('min_price', '');
        $maxPrice = $request->input('max_price', '');
        $minStock = $request->input('min_stock', '');
        $maxStock = $request->input('max_stock', '');
        $products = Product::with('company')
            ->withSearch($request->query('product_search'))
            ->withCompany($request->query('company_name'));
        if ($minPrice != '') {
            $products = $products->where('price', '>=', $minPrice);
        }
        if ($maxPrice != '') {
            $products = $products->where('price', '<=', $maxPrice);
        }
        if ($minStock != '') {
            $products = $products->where('stock', '>=', $minStock);
        }
        if ($maxStock != '') {
            $products = $products->where('stock', '<=', $maxStock);
        }
        $products = $products->sortable($request->query('sort_column', 'id'), 
                                         $request->query('sort_order', 'asc'))
                              ->get();
        if ($request->ajax()) {
            return response()->json(['products' => $products, 'companies' => $companies]);
        }
        return view('products.index', compact('products', 'companies'));
    }    
    //検索
    public function search(Request $request)
    {
    if ($request->ajax()) {
        $products = Product::searchProducts($request);
        return response()->json($products);//指導
    }
    }
    public function destroy(Request $request, $id)
    {
    $product = Product::findOrFail($id);
    $product->delete();
    if ($request->ajax()) {
        return response()->json(['id' => $id]);
    }
    }
    public function create()
    {
    $companies = Company::pluck('company_name', 'id'); // 企業名一覧を取得（セレクトボックス用）
    return view('products.create', compact('companies')); // 登録画面ビューを表示
    }

    public function store(Request $request) 
    {
    // フォームデータをダンプして確認
    //dd($request->all());
    
    DB::beginTransaction();// トランザクションの開始
    try {
        $productModel = new Product(); // モデルのインスタンスを作成
        $productModel->createProduct($request); // モデルのメソッドを呼び出して処理を実行
        DB::commit();// トランザクションのコミット

        return redirect()->route('products.index');// リダイレクトなどの後続処理を行う
    } catch (\Exception $e) {
        DB::rollback();// トランザクションのロールバック
        throw $e; // エラーを再スローして通知
    }
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
        DB::beginTransaction(); // トランザクションの開始
        try {
            $productModel = new Product(); // モデルのインスタンスを取得
            $productModel->updateProduct($request,$id); // モデルのメソッドを呼び出して更新処理を実行

            DB::commit(); // トランザクションのコミット

            return redirect()->route('products.index',$id); // リダイレクトなどの後続処理を行う
        } catch (\Exception $e) {
            DB::rollback(); // トランザクションのロールバック
            throw $e; // エラーを再スローして通知
        }
    }
}