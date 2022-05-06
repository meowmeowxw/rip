<?php


namespace App\Models;

use App\Models\Product;

class Category extends \Illuminate\Database\Eloquent\Model
{
    protected $fillable = [
        'name',
        'description',
    ];

    protected $dates = ['deleted_at'];

    public $table = 'categories';

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
