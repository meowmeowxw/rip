<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_seller',
        'userable_type',
        'userable_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the type of user (Customer or Seller)
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function userable()
    {
        return $this->morphTo();
    }

    public function seller()
    {
        return $this->hasOne(Seller::class);
    }

    /**
     * Get the user role (Customer or Seller), abstraction of userable
     * @return mixed
     */
    public function role()
    {
        return $this->userable;
    }

    public function saveAll()
    {
        $this->save();
        $this->role()->save();
    }

    public function customer()
    {
        return $this->hasOne(Customer::class);
    }

    public function is_seller()
    {
        return $this->userable instanceof Seller;
    }
}
