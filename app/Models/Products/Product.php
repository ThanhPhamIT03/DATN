<?php

namespace App\Models\Products;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category\Category;
use App\Models\Products\Brand;
use App\Models\Products\ProductVariant;
use App\Models\Order\OrderItem;
use App\Models\Products\Review;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'model',
        'description',
        'thumbnail',
        'brand_id',
        'condition',
        'images',
        'is_featured',
        'status',
        'discount',
    ];

    /**
     * Quan hệ 1-1 với bảng brands
     */
    public function brand()
    {
        return $this->hasOne(Brand::class, 'id', 'brand_id');
    }

    /**
     * Quan hệ 1-1 với bảng categories
     */
    public function category()
    {
        return $this->hasOne(Category::class, 'id', 'category_id');
    }

    /**
     * Một sản phẩm có nhiều biến thể
     */
    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }

    // Một sản phẩm có thể có nhiều order item
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'product_id');
    }

    // Quan hệ với bảng review
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class, 'product_id');
    }
}
