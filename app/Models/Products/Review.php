<?php

namespace App\Models\Products;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Order\Order;
use App\Models\Products\Product;

class Review extends Model
{
    use HasFactory;

    // Tên bảng (nếu khác với chuẩn "product_reviews")
    protected $table = 'product_review';

    // Các cột có thể gán giá trị hàng loạt
    protected $fillable = [
        'user_id',
        'order_id',
        'product_id',
        'content',
    ];

    /*
    |--------------------------------------------------------------------------
    | Quan hệ
    |--------------------------------------------------------------------------
    */

    // Review thuộc về 1 user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Review thuộc về 1 order
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // Review thuộc về 1 product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
