<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use App\Models\Order\Order;
use App\Models\Order\Bill;
use App\Models\Products\Review;
use App\Models\Search;
use App\Models\Order\OrderPending;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'code',
        'address',
        'birthday',
        'role',
        'promo_register',
        'social_id',
        'default_address'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'address' => 'array'
        ];
    }

    // Quan hệ một nhiều với bảng orders
    public function orders()
    {
        return $this->hasMany(Order::class, 'user_id');
    }

    // Quan hệ một nhiều với bảng bills
    public function bills()
    {
        return $this->hasMany(Bill::class, 'user_id');
    }

    // Quan hệ với bảng lịch sử tìm kiếm
    public function searchHistory()
    {
        return $this->hasMany(Search::class, 'user_id');
    }

    // Quan hệ với bảng review
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class, 'user_id');
    }

    // Quan hệ với bảng order pending
    public function orderPending(): HasMany
    {
        return $this->hasMany(OrderPending::class, 'user_id');
    }
}