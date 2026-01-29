<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, Notifiable;

    protected $fillable = ['name', 'email', 'password'];
    protected $hidden = ['password', 'remember_token'];
    protected $casts = ['email_verified_at' => 'datetime', 'password' => 'hashed'];


    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    public function likedItems()
    {
        return $this->belongsToMany(Item::class, 'item_likes', 'user_id', 'item_id');
    }

    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }
}
