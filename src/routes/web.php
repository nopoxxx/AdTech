<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdvertiserController;
use App\Http\Controllers\WebmasterController;
use App\Http\Controllers\LinkRedirectController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->prefix('advertiser')->name('advertiser.')->group(function () {
    Route::get('/dashboard', [AdvertiserController::class, 'index'])->name('dashboard');
    Route::post('/create-offer', [AdvertiserController::class, 'createOffer'])->name('createOffer');
    Route::post('/deactivate-offer/{id}', [AdvertiserController::class, 'deactivateOffer'])->name('deactivateOffer');
    Route::post('/reactivate-offer/{id}', [AdvertiserController::class, 'reactivateOffer'])->name('reactivateOffer');
});

Route::middleware('auth')->prefix('webmaster')->name('webmaster.')->group(function () {
    Route::get('/dashboard', [WebmasterController::class, 'index'])->name('dashboard');
    Route::post('/subscribe/{offerId}', [WebmasterController::class, 'subscribeOffer'])->name('subscribeOffer');
    Route::post('/unsubscribe/{offerId}', [WebmasterController::class, 'unsubscribeOffer'])->name('unsubscribeOffer');
});

Route::get('/go/{custom_url}', LinkRedirectController::class)->name('redirect');

Route::get('/admin/login', [AdminController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/logout', [AdminController::class, 'logout'])->name('admin.logout');
Route::post('/admin/login', [AdminController::class, 'login']);
Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
Route::patch('/users/{user}/activate', [AdminController::class, 'activate'])->name('admin.activate');
Route::patch('/users/{user}/deactivate', [AdminController::class, 'deactivate'])->name('admin.deactivate');

