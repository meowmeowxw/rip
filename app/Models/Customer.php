<?php


namespace App\Models;

class Customer extends \Illuminate\Database\Eloquent\Model
{

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
        return $this->belongsTo(User::class);
    }

}
