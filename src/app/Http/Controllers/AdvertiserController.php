<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdvertiserController extends Controller
{
    public function index()
    {
        $offers = Offer::where('advertiser_id', Auth::id())->get();
        $stats = [];

        foreach ($offers as $offer) {
            $stats = [];
            foreach ($offers as $offer) {
                $stats[$offer->id] = [
                    'daily' => $offer->clickLogs()->whereDate('clicked_at', today())->count(),
                    'monthly' => $offer->clickLogs()->whereMonth('clicked_at', now()->month)->count(),
                    'yearly' => $offer->clickLogs()->whereYear('clicked_at', now()->year)->count(),
                ];
            }
        }

        return view('advertiser.dashboard', compact('offers', 'stats'));
    }

    public function createOffer(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'cost_per_click' => 'required|numeric|min:0.01',
            'target_url' => 'required|url',
        ]);

        $offer = new Offer();
        $offer->name = $request->name;
        $offer->cost_per_click = $request->cost_per_click;
        $offer->target_url = $request->target_url;
        $offer->advertiser_id = auth()->id();
        $offer->save();

        return redirect()->route('dashboard');
    }

    public function deactivateOffer($id)
    {
        $offer = Offer::where('advertiser_id', Auth::id())->findOrFail($id);
        $offer->update(['status' => 'inactive']);

        return redirect()->route('dashboard');
    }
    
    public function reactivateOffer($id)
    {
        $offer = Offer::where('advertiser_id', Auth::id())->findOrFail($id);
        $offer->update(['status' => 'active']);

        return redirect()->route('dashboard');
    }
}
