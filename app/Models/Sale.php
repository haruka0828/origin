<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Sale extends Model
{
    use HasFactory;

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function makeSale($product_id, $quantity)
    {
        DB::beginTransaction();

        try {
            // 在庫数をチェック
            $product = DB::table('products')->where('id', $product_id)->first();
            if ($product->stock <= 0) {
               return ['status' => 'error', 'message' => '在庫がありません'];
            } else if ($product->stock < $quantity) {
               return ['status' => 'error', 'message' => '在庫が不足しています'];
            }

            // salesテーブルにレコードを追加
            DB::table('sales')->insert([
                'product_id' => $product_id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // productsテーブルの在庫数を減算
            DB::table('products')
                ->where('id', $product_id)
                ->decrement('stock', $quantity);

            DB::commit();

            return ['status' => 'success'];
        } catch (\Exception $e) {
            // エラーが発生した場合はロールバック
            DB::rollback();
            return ['status' => 'error', 'message' => 'エラー発生'];
        }
    }
}
