<?php

namespace App\Models\Blog;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BlogContainer extends Model
{
    use HasFactory;

    protected $table = 'technology_new_blocks';

    protected $fillable = [
        'new_id', 
        'title',
        'content',
        'thumbnail'
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function new()
    {
        return $this->belongsTo(Blog::class, 'new_id');
    }

}