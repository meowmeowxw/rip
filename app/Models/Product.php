<?php


namespace App\Models;

use App\Models\Category;
use App\Models\Order;

class Product extends \Illuminate\Database\Eloquent\Model
{

    protected $fillable = [
        'active',
        'name',
        'description',
        'price',
        'quantity',
        'alcohol',
        'cl',
        'path',
    ];

    protected $dates = ['deleted_at'];

    public function orders()
    {
        return $this->belongsToMany(SellerOrder::class, 'sub_orders')->withPivot('single_price', 'ordered_quantity');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function seller()
    {
        return $this->belongsTo(Seller::class);
    }

    public function isAvailable()
    {
        return $this->quantity > 0;
    }
}
