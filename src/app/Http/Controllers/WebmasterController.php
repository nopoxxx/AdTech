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
        $subscriptions = Subscription::where('webmaster_id', Auth::id())
            ->with('offer')
            ->get();
    
        $subscribedOfferIds = $subscriptions->pluck('offer_id');
    
        $availableOffers = Offer::whereNotIn('id', $subscribedOfferIds)
            ->where('status', 'active')
            ->get();
    
        $stats = [];
    
        foreach ($subscriptions as $subscription) {
            $stats[$subscription->offer->id] = [
                'daily' => $subscription->clickLogs()->whereDate('clicked_at', today())->count(),
                'monthly' => $subscription->clickLogs()->whereMonth('clicked_at', now()->month)->count(),
                'yearly' => $subscription->clickLogs()->whereYear('clicked_at', now()->year)->count(),
            ];
        }        
    
        return view('webmaster.dashboard', compact('subscriptions', 'stats', 'availableOffers'));
    }

    public function subscribeOffer(Request $request, $offerId)
    {
        $offer = Offer::findOrFail($offerId);
    
        $existing = Subscription::where('webmaster_id', Auth::id())
                                ->where('offer_id', $offerId)
                                ->first();
        if ($existing) {
            return redirect()->route('webmaster.dashboard');
        }
    
        $subscription = Subscription::create([
            'webmaster_id' => Auth::id(),
            'offer_id' => $offerId,
        ]);
    
        return redirect()->route('webmaster.dashboard');
    }
    

    public function unsubscribeOffer($offerId)
    {
        $subscription = Subscription::where('webmaster_id', Auth::id())
                                    ->where('offer_id', $offerId)
                                    ->firstOrFail();
        $subscription->delete();

        return redirect()->route('webmaster.dashboard');
    }
}
