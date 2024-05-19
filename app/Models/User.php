<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory;

    protected $table = 'users';

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'user_category', 'user_id', 'category_id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'purchaser_id');
    }

    public function referredDistributors()
    {
        return $this->hasMany(User::class, 'referred_by');
    }

    public function referrer()
    {
        return $this->belongsTo(User::class, 'referred_by');
    }

    public function referredOrders()
    {
        return $this->hasManyThrough(Order::class, User::class, 'referred_by', 'purchaser_id', 'id', 'id');
    }

}
