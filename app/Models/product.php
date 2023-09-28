<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_name',
        'price',
        'stock',
        'company_id',
        'comment',
        'img_pass',
    ];
    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }

    public static function searchProducts($request)
    {
        $query = self::with('company');
        if ($request->has('product_search')) {
            $query->where('product_name', 'like', '%' . $request->input('product_search') . '%');
        }
        if ($request->has('company_name')) {
            $query->where('company_id', $request->input('company_name'));
        }
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->input('min_price'));
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->input('max_price'));
        }
        if ($request->filled('min_stock')) {
            $query->where('stock', '>=', $request->input('min_stock'));
        }
        if ($request->filled('max_stock')) {
            $query->where('stock', '<=', $request->input('max_stock'));
        }
    $products = $query->get(); return $products;
    }
    //store
    public function createProduct($request)
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
            //'img_pass'=> $request->input('img_pass'),
        ];
        // カンパニーIDを関連付け
        $productInfo['company_id'] = $company->id;
        if ($request->hasFile('img_pass')) {
            $imagePath = $request->file('img_pass')->store('images', 'public');
            $productInfo['img_pass'] = $imagePath;
        }
        // 商品情報をデータベースに登録
        $this->create($productInfo);
    }
    // update
    public function updateProduct($request,$id)
    {
        // カンパニーIDの取得
        $companyId = $request->input('company_id');
        // 商品情報の取得
        $productInfo = [
            'product_name' => $request->input('product_name'),
            'price' => $request->input('price'),
            'stock' => $request->input('stock'),
            'comment' => $request->input('comment'),
            //'img_pass'=> $request->input('img_pass'),
        ];
        // カンパニーIDを関連付け
        $productInfo['company_id'] = $companyId;
        // 画像ファイルの処理
        if ($request->hasFile('img_pass')) {
            $imagePath = $request->file('img_pass')->store('images', 'public');
            $productInfo['img_pass'] = $imagePath;
        }
        // 既存の画像を削除
        $existingProduct = Product::findOrFail($id);
        if ($existingProduct->img_pass) {
        Storage::disk('public')->delete($existingProduct->img_pass);
        }
        else {
        // 新しい画像がアップロードされない場合、既存の画像パスを代入
        $existingProduct = Product::findOrFail($id);
        $productInfo['img_pass'] = $existingProduct->img_pass;
        }
        // 商品情報を更新
        Product::findOrFail($id)->update($productInfo);
    }
}