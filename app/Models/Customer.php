<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Customer extends \Illuminate\Database\Eloquent\Model
{

    use HasFactory;

    protected $fillable = [
        'credit_card',
        'street',
        'city',
    ];

    protected $dates = ['deleted_at'];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function user()
    {
        return $this->morphOne(User::class , 'userable');
        // return $this->belongsTo(User::class);
    }

}
