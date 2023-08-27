<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_name',
    ];
    // Product モデルとの関連付け（逆方向）
    public function products()
    {
        return $this->hasMany(Product::class, 'company_id');
    }
}


