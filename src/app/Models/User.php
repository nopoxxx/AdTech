<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'username',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function offers()
    {
        return $this->hasMany(Offer::class, 'advertiser_id');
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class, 'webmaster_id');
    }

    public function isAdvertiser()
    {
        return $this->role === 'advertiser';
    }

    public function isWebmaster()
    {
        return $this->role === 'webmaster';
    }
}
