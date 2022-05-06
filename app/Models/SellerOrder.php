<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SellerOrder extends Model
{
    protected $fillable = [
        'profit'
    ];

    protected $dates = ['deleted_at'];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'sub_orders')->withPivot('total_price', 'single_price', 'ordered_quantity');
    }

    public function seller()
    {
        return $this->belongsTo(Seller::class);
    }

}
