<?php

namespace App\Models\Blog;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Blog extends Model
{
    use HasFactory;

    protected $table = 'technology_news';

    protected $fillable = [
        'title',
        'slug',
        'author',
        'thumbnail'
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function container()
    {
        return $this->hasMany(BlogContainer::class, 'new_id');
    }

}