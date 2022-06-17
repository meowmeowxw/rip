<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Customer extends \Illuminate\Database\Eloquent\Model
{

    use HasFactory;

    protected $fillable = [
    ];

    protected $dates = ['deleted_at'];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function shippingInfos()
    {
        return $this->hasMany(ShippingInfo::class);
    }

    public function paymentInfos()
    {
        return $this->hasMany(PaymentInfo::class);
    }

    public function user()
    {
        return $this->morphOne(User::class , 'userable');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

}
