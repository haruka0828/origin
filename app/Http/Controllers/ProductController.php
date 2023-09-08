<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product; // Product モデルを追加
use App\Models\Company; // Company モデルを追加
use Illuminate\Support\Facades\DB; //トランザクション使用
//use Illuminate\Support\Facades\Storage; // 追加

class ProductController extends Controller
{
    public function index(Request $request)
    {
    // 通常のHTTPリクエストの場合にも $products 変数を設定
    $products = Product::getFilteredProducts($request);
    if ($request->ajax()) {
        return response()->json(['products' => $products]);
    }
    // 通常のHTTPリクエストの場合、通常通りビューを返す
    $companies = Company::pluck('company_name', 'id');
    return view('products.index', compact('products', 'companies'));
    }

    public function search(Request $request)
    {
    if ($request->ajax()) {
        $products = Product::getFilteredProducts($request);
        return response()->json(['products' => $products]);
    }
    }

    public function destroy($id)
    {
    DB::beginTransaction(); // トランザクションの開始
    try {
        $product = Product::findOrFail($id);
        $product->delete();
        DB::commit(); // トランザクションのコミット
        return redirect()->route('products.index')->with('status', '商品を削除しました');
    } catch (\Exception $e) {
        DB::rollback(); // トランザクションのロールバック
        return redirect()->route('products.index')->with('error', '商品の削除に失敗しました');
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
