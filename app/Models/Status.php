<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    protected $fillable = [
        'name',
        'description',
    ];

    protected $table = 'status';

    public function sellerOrders()
    {
        return $this->hasMany(SellerOrder::class);
    }

}
