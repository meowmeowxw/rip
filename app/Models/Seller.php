<?php


namespace App\Models;

class Seller extends \Illuminate\Database\Eloquent\Model
{

    protected $fillable = [
        'company',
        'credit_card',
    ];

    protected $dates = ['deleted_at'];

    public function orders()
    {
        return $this->hasMany(SellerOrder::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
