<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'offer_id',
        'webmaster_id',
        'custom_url',
        'active',
    ];

    protected $casts = [
        'active' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($subscription) {
            if (empty($subscription->custom_url)) {
                $subscription->custom_url = self::generateUniqueToken();
            }
        });
    }

    protected static function generateUniqueToken(): string
    {
        do {
            $token = Str::random(12);
        } while (self::where('custom_url', $token)->exists());

        return $token;
    }

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
