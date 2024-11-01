<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    // ユーザーとのリレーション
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // 注文アイテムとのリレーション
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
