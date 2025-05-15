<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WebmasterController extends Controller
{
    public function index()
    {
        $subscriptions = Subscription::where('user_id', Auth::id())->get();
        $stats = [];

        foreach ($subscriptions as $subscription) {
            $offer = $subscription->offer;
            $stats[$offer->id] = [
                'daily' => $subscription->clicks()->whereDate('created_at', today())->count(),
                'monthly' => $subscription->clicks()->whereMonth('created_at', now()->month)->count(),
                'yearly' => $subscription->clicks()->whereYear('created_at', now()->year)->count(),
            ];
        }

        return view('webmaster.dashboard', compact('subscriptions', 'stats'));
    }

    public function subscribeOffer(Request $request, $offerId)
    {
        $validated = $request->validate([
            'cost_per_click' => 'required|numeric',
        ]);

        $subscription = Subscription::create([
            'user_id' => Auth::id(),
            'offer_id' => $offerId,
            'cost_per_click' => $validated['cost_per_click'],
        ]);

        return redirect()->route('webmaster.dashboard');
    }

    public function unsubscribeOffer($offerId)
    {
        $subscription = Subscription::where('user_id', Auth::id())
                                    ->where('offer_id', $offerId)
                                    ->firstOrFail();
        $subscription->delete();

        return redirect()->route('webmaster.dashboard');
    }
}
