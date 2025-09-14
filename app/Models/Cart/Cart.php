<?php

namespace App\Models\Cart;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use App\Models\User;
use App\Models\Products\Product;
use App\Models\Products\ProductVariant;


class Cart extends Model
{
    use HasFactory;

    protected $table = 'cart'; 

    protected $fillable = [
        'user_id',
        'product_id',
        'product_variant_id',
        'quantity',
        'price',
        'info',
    ];

    protected $casts = [
        'info' => 'array',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    // 1 dòng giỏ hàng thuộc về 1 user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // 1 dòng giỏ hàng thuộc về 1 sản phẩm
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    // 1 dòng giỏ hàng có thể thuộc về 1 biến thể
    public function variant()
    {
        return $this->belongsTo(ProductVariant::class, 'product_variant_id');
    }
}
