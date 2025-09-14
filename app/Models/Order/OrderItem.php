<?php

namespace App\Models\Order;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Products\Product;
use App\Models\Products\ProductVariant;
use App\Models\Order\Order;

class OrderItem extends Model
{
    use HasFactory;

    protected $table = 'order_items';

    protected $fillable = [
        'order_id',
        'product_id',
        'product_variant_id',
        'product_name',
        'price',
        'quantity',
        'variant',
        'total_price'
    ];

    protected $casts = [
        'variant' => 'array',
    ];

    // Mỗi order item thuộc về một order
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    // Mỗi order item thuộc về một product
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    // Mỗi order item thuộc về một product variant
    public function variant()
    {
        return $this->belongsTo(ProductVariant::class, 'product_variant_id');
    }
}
