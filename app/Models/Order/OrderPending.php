<?php

namespace App\Models\Order;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;
use App\Models\Order\Order;
use App\Models\User;
use App\Models\Notification;

class OrderPending extends Model
{
    use HasFactory;

    // Nếu bảng không theo chuẩn số nhiều -> phải khai báo
    protected $table = 'order_pending';

    protected $fillable = [
        'order_id',
        'user_id',
        'reason',
        'status',
        'order_code'
    ];

    /**
     * Quan hệ: Yêu cầu hủy đơn thuộc về một đơn hàng
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    /**
     * Quan hệ: Yêu cầu hủy đơn thuộc về một user
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function notifications()
    {
        return $this->morphMany(Notification::class, 'notifiable');
    }
}
