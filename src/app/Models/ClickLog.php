<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClickLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'subscription_id',
        'clicked_at',
    ];

    public $timestamps = false;

    protected $casts = [
        'clicked_at' => 'datetime',
    ];

    public function subscription()
    {
        return $this->belongsTo(Subscription::class);
    }

    public function advertiser()
    {
        return $this->hasOneThrough(
            User::class,
            Subscription::class,
            'id',             
            'id',             
            'subscription_id',
            'offer_id'        
        )->where('role', 'advertiser');
    }

    public function offer()
    {
        return $this->hasOneThrough(
            Offer::class,
            Subscription::class,
            'id',             
            'id',             
            'subscription_id',
            'offer_id'        
        );
    }

    public function webmaster()
    {
        return $this->hasOneThrough(
            User::class,
            Subscription::class,
            'id',             
            'id',             
            'subscription_id',
            'webmaster_id'    
        )->where('role', 'webmaster');
    }
}
