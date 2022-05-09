<?php


namespace App\Models;

use App\Models\User;
use App\Models\Product;

class Order extends \Illuminate\Database\Eloquent\Model
{
    protected $fillable = [
        'price',
    ];

    protected $dates = ['deleted_at'];

    public function paymentInfo()
    {
        return $this->belongsTo(PaymentInfo::class);
    }

    public function price()
    {
        return 1;
    }

    public function shippingInfo()
    {
        return $this->belongsTo(ShippingInfo::class);
    }

    public function sellerOrders()
    {
        return $this->hasMany(SellerOrder::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
