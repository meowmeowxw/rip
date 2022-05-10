<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SellerOrder extends Model
{
    protected $fillable = [
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

    public function profit()
    {
        $total = 0.0;
        foreach ($this->products as $p) {
            $total += $p->pivot->ordered_quantity * $p->pivot->single_price;
        }
        return $total;
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'sub_orders')->withPivot('single_price', 'ordered_quantity');
    }

    public function seller()
    {
        return $this->belongsTo(Seller::class);
    }

}
