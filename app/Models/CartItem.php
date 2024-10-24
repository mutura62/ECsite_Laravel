<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    protected $fillable = ['cart_id', 'product_id', 'quantity'];

    // CartItemは1つのカートに紐づく
    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    // CartItemは1つの製品に紐づく
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
