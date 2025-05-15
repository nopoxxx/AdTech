<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use App\Models\ClickLog;
use Illuminate\Support\Carbon;

class LinkRedirectController extends Controller
{
    public function __invoke(string $custom_url)
    {
        $subscription = Subscription::where('custom_url', $custom_url)
            ->where('active', true)
            ->with('offer')
            ->first();

        if (! $subscription || ! $subscription->offer || $subscription->offer->status !== 'active') {
            abort(404, 'Invalid or inactive link');
        }

        ClickLog::create([
            'subscription_id' => $subscription->id,
            'clicked_at' => Carbon::now(),
        ]);

        return redirect()->away($subscription->offer->target_url);
    }
}
