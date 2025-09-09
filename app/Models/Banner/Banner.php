<?php

namespace App\Models\Banner;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    use HasFactory;

    // Tên bảng (nếu khác với mặc định số nhiều của model)
    protected $table = 'slides';

    // Các cột được phép gán dữ liệu hàng loạt
    protected $fillable = [
        'title',
        'description',
        'link',
        'image',
        'status'
    ];
}
