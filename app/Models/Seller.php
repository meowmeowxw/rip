<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Seller extends \Illuminate\Database\Eloquent\Model
{

    use HasFactory;

    protected $fillable = [
        'company',
        'description',
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
        return $this->morphOne(User::class, 'userable');
    }

}
