<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    use HasFactory;

    protected $fillable = [
        'advertiser_id',
        'name',
        'cost_per_click',
        'target_url',
        'status',
        'topics',
    ];

    protected $casts = [
        'topics' => 'array',
    ];

    public function advertiser()
    {
        return $this->belongsTo(User::class, 'advertiser_id');
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class, 'offer_id');
    }

    public function clickLogs()
    {
        return $this->hasManyThrough(ClickLog::class, Subscription::class, 'offer_id', 'subscription_id');
    }

    public function getSubscriberCount()
    {
        return $this->subscriptions()->count();
    }
}
