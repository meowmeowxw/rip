<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = [
        "star",
        "description",
        "customer_id",
        'reviewable_type',
        'reviewable_id',
    ];

    public $timestamps = false;

    public function reviewable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(Customer::class);
    }
}
?>
