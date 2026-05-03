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

Route::get('/mentions-legales', [\App\Http\Controllers\LegalController::class, 'mentionsLegales'])->name('mentions-legales');
Route::get('/confidentialite', [\App\Http\Controllers\LegalController::class, 'confidentialite'])->name('confidentialite');
Route::resource('avis', AvisController::class)->only(['index', 'show']);

Route::get('/dashboard', function () {
    $user = auth()->user();
    $objets = \App\Models\ObjetLouable::where('user_id', $user->id)->latest()->paginate(5, ['*'], 'objets_page')->onEachSide(1);
    $reservations = \App\Models\Reservation::where('user_id', $user->id)->with('objetLouable')->latest()->take(4)->get();
    
    // Demandes de location reçues sur mes objets
    $demandesRecues = \App\Models\Reservation::whereHas('objetLouable', function($query) use ($user) {
        $query->where('user_id', $user->id);
    })->with(['objetLouable', 'user'])->latest()->take(5)->get();

    return view('dashboard', compact('objets', 'reservations', 'demandesRecues'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::patch('/reservations/{reservation}/accept', [\App\Http\Controllers\ReservationController::class, 'accept'])->name('reservations.accept');
    Route::patch('/reservations/{reservation}/reject', [\App\Http\Controllers\ReservationController::class, 'reject'])->name('reservations.reject');
    Route::get('/messages', [\App\Http\Controllers\MessageController::class, 'index'])->name('messages.index');
    Route::get('/messages/{interlocuteur}', [\App\Http\Controllers\MessageController::class, 'conversation'])->name('messages.show');
    Route::post('/messages', [\App\Http\Controllers\MessageController::class, 'store'])->name('messages.store');
    Route::delete('/messages/{message}', [\App\Http\Controllers\MessageController::class, 'destroy'])->name('messages.destroy');
    Route::delete('/messages/discussion/{user}', [\App\Http\Controllers\MessageController::class, 'destroyDiscussion'])->name('messages.destroyDiscussion');
    
    // Admin Management
    Route::get('/admin/objets', [\App\Http\Controllers\AdminController::class, 'index'])->name('admin.objets.index');
    Route::post('/admin/objets/{objet}/approuver', [\App\Http\Controllers\AdminController::class, 'approuver'])->name('admin.objets.approuver');
    Route::post('/admin/objets/{objet}/rejeter', [\App\Http\Controllers\AdminController::class, 'rejeter'])->name('admin.objets.rejeter');
    Route::get('/admin/users/{user}/posts', [\App\Http\Controllers\AdminController::class, 'userPosts'])->name('admin.users.posts');
    Route::delete('/admin/users/{user}', [\App\Http\Controllers\AdminController::class, 'deleteUser'])->name('admin.users.destroy');
    Route::post('/admin/users/{user}/warn', [\App\Http\Controllers\AdminController::class, 'warnUser'])->name('admin.users.warn');
    Route::delete('/admin/objets/{objet}', [\App\Http\Controllers\AdminController::class, 'destroyAd'])->name('admin.objets.destroy');

    Route::get('/notifications/mark-as-read', function() {
        auth()->user()->unreadNotifications->markAsRead();
        return redirect()->to(url()->previous() ?: '/');
    })->name('notifications.markAllRead');

    Route::get('/notifications/{id}/read', function($id) {
        $notification = auth()->user()->notifications()->findOrFail($id);
        $notification->markAsRead();
        
        // Redirect based on notification data or user role
        if (!empty($notification->data['redirect_url'])) {
            return redirect()->to($notification->data['redirect_url']);
        }
        
        if (auth()->user()->role === 'admin') {
            return redirect()->route('admin.objets.index');
        }
        
        return redirect()->route('dashboard');
    })->name('notifications.read');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('objets', ObjetLouableController::class)->except(['index', 'show']);
    Route::post('/objets/check-title', [ObjetLouableController::class, 'checkTitle'])->name('objets.check-title');
    Route::resource('photos', \App\Http\Controllers\PhotoController::class)->only(['destroy']);
    Route::resource('reservations', ReservationController::class);
    Route::resource('messages', MessageController::class);
    Route::post('/objets/{objet}/avis', [\App\Http\Controllers\AvisController::class, 'store'])->name('objets.avis.store');
    Route::resource('avis', AvisController::class)->except(['index', 'show', 'store']);
    // Ticket d'expédition
    Route::get('/reservations/{reservation}/ticket', [ReservationController::class, 'ticket'])->name('reservations.ticket');
    // Paiements Stripe
    Route::get('/paiements/checkout/{reservation}', [PaiementController::class, 'checkout'])->name('paiements.checkout');
    Route::get('/paiements/success', [PaiementController::class, 'success'])->name('paiements.success');
    Route::get('/paiements/cancel', [PaiementController::class, 'cancel'])->name('paiements.cancel');
    Route::resource('paiements', PaiementController::class)->except(['create', 'store']);

    // Cart Routes
    Route::get('/cart', [\App\Http\Controllers\CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{id}', [\App\Http\Controllers\CartController::class, 'add'])->name('cart.add');
    Route::delete('/cart/remove/{id}', [\App\Http\Controllers\CartController::class, 'remove'])->name('cart.remove');
    Route::post('/cart/clear', [\App\Http\Controllers\CartController::class, 'clear'])->name('cart.clear');
});

// Public read-only routes must come AFTER auth group to prevent {objet} matching "create"
Route::resource('objets', ObjetLouableController::class)->only(['index']);
Route::get('/objets/{objet}', [ObjetLouableController::class, 'show'])->name('objets.show')->withTrashed();

require __DIR__.'/auth.php';
