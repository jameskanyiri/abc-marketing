<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';

    public function customer()
    {
        return $this->belongsTo(User::class, 'purchaser_id');
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    }

    public function getOrderTotalAttribute()
    {
        return $this->items->sum(function($item) {
            return $item->product ? $item->quantity * $item->product->price : 0;
        });
    }


}
