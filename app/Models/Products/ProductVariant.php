<?php

namespace App\Models\Products;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Order\OrderItem;

class ProductVariant extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'code',
        'color',
        'storage',
        'price',
        'sale_price',
        'quantity',
        'thumbnail',
        'status',
        'info'
    ];

    protected $table = 'product_variants';

    protected $casts = [
        'storage' => 'array',
        'info' => 'array'
    ];

    /**
     * Một biến thể thuộc về một sản phẩm
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Một biến thể có thể có nhiều order item
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'product_variant_id');
    }
}
