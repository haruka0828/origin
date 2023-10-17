<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;
use DB;

class SalesController extends Controller
{
    public function purchase(Request $request)
    {
        // リクエストから下記情報を取得
        $product_id = $request->input('product_id');//商品ID
        $quantity = $request->input('quantity');//購入数量

        DB::beginTransaction();

        try {
            // Saleモデルを使用して購入処理
            $sale = new Sale();
            $result = $sale->makeSale($product_id, $quantity);
        
            if ($result['status'] == 'success') {
                DB::commit();
                return response()->json(['message' => '購入完了'], 200);
            } else {
                DB::rollback();
                switch ($result['code']) {
                    case 'out_of_stock':
                        $message = '在庫がありません';
                        break;
                    case 'insufficient_stock':
                        $message = '在庫が不足しています';
                        break;
                    case 'db_error':
                        $message = 'エラー発生';
                        break;
                }
                return response()->json(['message' => $message], 400);
            }
        } catch (\Exception $e) {
            // エラーが発生した場合はロールバック
            DB::rollback();
            return response()->json(['message' => '接続エラー'], 400);
        }
    }
}