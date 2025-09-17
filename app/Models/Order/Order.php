<?php

namespace App\Models\Order;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Order\Bill;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';

    protected $fillable = [
        'user_id',
        'order_code',
        'status',
        'customer_info',
        'payment_method',
        'status'
    ];

    protected $casts = [
        'customer_info' => 'array',
    ];

    /**
     * Mỗi order thuộc về một user
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Mỗi order có nhiều order item
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    }

    // Mỗi order có một bill
    public function bill()
    {
        return $this->hasOne(Bill::class, 'order_id');
    }
}
