<?php

namespace App\Models\Products;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category\Category;
use App\Models\Products\Brand;

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
        'status'
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
}
