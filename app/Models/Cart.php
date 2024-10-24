<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = ['user_id'];

    // カートは複数の商品（CartItem）を持つ
    public function items()
    {
        return $this->hasMany(CartItem::class);
    }

    // カートは1人のユーザーに紐づく
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
