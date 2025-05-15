<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'offer_id',
        'webmaster_id',
        'custom_url',
        'cost_per_click',
        'active',
    ];

    protected $casts = [
        'active' => 'boolean',
    ];

    public function offer()
    {
        return $this->belongsTo(Offer::class);
    }

    public function webmaster()
    {
        return $this->belongsTo(User::class, 'webmaster_id');
    }

    public function clickLogs()
    {
        return $this->hasMany(ClickLog::class);
    }

    public function getRedirectUrlAttribute()
    {
        return url("/go/{$this->custom_url}");
    }
}
