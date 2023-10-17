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
        // 在庫数をチェック
        $product = DB::table('products')->where('id', $product_id)->first();
        if ($product->stock <= 0) {
           return ['status' => 'error', 'code' => 'out_of_stock'];
        } else if ($product->stock < $quantity) {
           return ['status' => 'error', 'code' => 'insufficient_stock'];
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
        return ['status' => 'success'];
    }
}
