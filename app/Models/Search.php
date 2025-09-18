<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use App\Models\User;

class Search extends Model
{
    use HasFactory;

    protected $table = 'search_history';

    protected $fillable = [
        'user_id',
        'keyword',
    ];

    /**
     * Quan hệ: SearchHistory thuộc về một User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
