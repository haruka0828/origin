<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product; // Product モデルを追加
use App\Models\Company; // Company モデルを追加
use Illuminate\Support\Facades\DB; //トランザクション使用
//use Illuminate\Support\Facades\Log;//Laravel.log

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('company');
        $products = $query->paginate(10);
        $companies = Company::pluck('company_name', 'id');
    
        if ($request->ajax()) {
            return response()->json(['products' => $products, 'companies' => $companies]);
        }

        return view('products.index', compact('products', 'companies'));
    }
    
    public function search(Request $request)
    {
        if ($request->ajax()) {
            //Log::info('Received parameters:', $request->all());//送信データログ

            // searchProductsメソッドで検索結果を取得
            $products = Product::searchProducts($request);
            // フィルタリング結果を取得
            return response()->json(['products' =>  $products]);
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
