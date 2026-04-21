<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ObjetLouableController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\AvisController;
use App\Http\Controllers\PaiementController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $objets = \App\Models\ObjetLouable::with('photos')->latest()->take(6)->get();
    return view('welcome', compact('objets'));
});
Route::resource('avis', AvisController::class)->only(['index', 'show']);

Route::get('/dashboard', function () {
    $user = auth()->user();
    $objets = \App\Models\ObjetLouable::where('user_id', $user->id)->latest()->take(4)->get();
    $reservations = \App\Models\Reservation::where('user_id', $user->id)->with('objetLouable')->latest()->take(4)->get();
    return view('dashboard', compact('objets', 'reservations'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('objets', ObjetLouableController::class)->except(['index', 'show']);
    Route::post('/objets/check-title', [ObjetLouableController::class, 'checkTitle'])->name('objets.check-title');
    Route::resource('photos', \App\Http\Controllers\PhotoController::class)->only(['destroy']);
    Route::resource('reservations', ReservationController::class);
    Route::resource('messages', MessageController::class);
    Route::resource('avis', AvisController::class)->except(['index', 'show']);
    Route::resource('paiements', PaiementController::class);

    // Cart Routes
    Route::get('/cart', [\App\Http\Controllers\CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{id}', [\App\Http\Controllers\CartController::class, 'add'])->name('cart.add');
    Route::delete('/cart/remove/{id}', [\App\Http\Controllers\CartController::class, 'remove'])->name('cart.remove');
    Route::post('/cart/clear', [\App\Http\Controllers\CartController::class, 'clear'])->name('cart.clear');
});

// Public read-only routes must come AFTER auth group to prevent {objet} matching "create"
Route::resource('objets', ObjetLouableController::class)->only(['index', 'show']);

require __DIR__.'/auth.php';
