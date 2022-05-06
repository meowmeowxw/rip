<?php


namespace App\Models;

use App\Models\User;
use App\Models\Product;

class Order extends \Illuminate\Database\Eloquent\Model
{
    protected $fillable = [
        'price',
        'credit_card',
        'street',
        'city',
    ];

    protected $dates = ['deleted_at'];

    public function sellerOrders()
    {
        return $this->hasMany(SellerOrder::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
