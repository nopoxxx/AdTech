<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Subscription;
use App\Models\ClickLog;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $request->validate(['password' => 'required']);

        if ($request->password === config('admin.password')) {
            session(['is_admin' => true]);
            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors(['password' => 'Неверный пароль']);
    }

    public function logout()
    {
        session()->forget('is_admin');
        return redirect()->route('admin.login');
    }

    public function dashboard()
    {
        if (!session('is_admin')) {
            return redirect()->route('admin.login');
        }

        $users = User::all();

        $totalRevenue = DB::table('click_logs')
            ->join('subscriptions', 'click_logs.subscription_id', '=', 'subscriptions.id')
            ->join('offers', 'subscriptions.offer_id', '=', 'offers.id')
            ->sum('offers.cost_per_click');

        $totalLinks = Subscription::count();
        $totalClicks = ClickLog::count();

        return view('admin.dashboard', [
            'users' => $users,
            'totalRevenue' => $totalRevenue,
            'totalLinks' => $totalLinks,
            'totalClicks' => $totalClicks,
        ]);
    }

    public function deactivate(User $user)
    {
        if (!session('is_admin')) return abort(403);
        $user->delete();
        return back();
    }
}
