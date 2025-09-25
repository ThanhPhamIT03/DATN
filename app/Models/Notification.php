<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = [
        'notifiable_id',
        'notifiable_type',
        'type',
        'is_read',
    ];

    /**
     * Quan hệ polymorphic tới Order hoặc OrderPending
     */
    public function notifiable()
    {
        return $this->morphTo();
    }
}
