# Instructions de Mise  Jour (Panier BDD & Rservations multiples)


## Etape 1 : Créer les nouveaux fichiers (Panier en BDD)

Avant de copier le code, lancez cette commande dans votre terminal pour générer les fichiers automatiquement :
```bash
php artisan make:model CartItem -m
```
Cela va créer le Modèle et la Migration. Ensuite, ouvrez ces deux fichiers et remplacez tout leur contenu par ce qui suit :

### Fichier Migration : database/migrations/..._create_cart_items_table.php
*(Le nom du fichier commence par la date d'aujourd'hui)*

``php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cart_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('objet_louable_id')->constrained()->cascadeOnDelete();
            $table->integer('quantity')->default(1);
            $table->string('taille')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cart_items');
    }
};
``

### Creez le fichier : app/Models/CartItem.php

``php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'objet_louable_id', 'quantity', 'taille'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function objetLouable()
    {
        return $this->belongsTo(ObjetLouable::class);
    }
}
``

## �tape 2 : Les fichiers existants � REMPLACER INT�GRALEMENT

### Remplacez tout le contenu de : app/Http/Controllers/CartController.php

``php
<?php

namespace App\Http\Controllers;

use App\Models\ObjetLouable;
use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Display the cart contents.
     */
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('info', 'Veuillez vous connecter pour voir votre panier.');
        }

        $cartItems = CartItem::where('user_id', Auth::id())->with('objetLouable.photos')->get();
        $items = [];
        $total = 0;

        foreach ($cartItems as $cartItem) {
            if ($cartItem->objetLouable) {
                $items[] = [
                    'objet' => $cartItem->objetLouable,
                    'quantity' => $cartItem->quantity,
                    'subtotal' => $cartItem->objetLouable->prix * $cartItem->quantity,
                    'taille' => $cartItem->taille
                ];
                $total += $cartItem->objetLouable->prix * $cartItem->quantity;
            }
        }

        return view('cart.index', compact('items', 'total'));
    }

    /**
     * Add an item to the cart.
     */
    public function add(Request $request, $id)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('info', 'Veuillez vous connecter pour ajouter des articles au panier.');
        }

        $objet = ObjetLouable::findOrFail($id);
        
        $existingItem = CartItem::where('user_id', Auth::id())
                                ->where('objet_louable_id', $id)
                                ->first();

        if ($existingItem) {
            return redirect()->back()->with('info', 'Cet article est déjà dans votre panier.');
        }

        CartItem::create([
            'user_id' => Auth::id(),
            'objet_louable_id' => $id,
            'quantity' => 1,
            'taille' => $request->input('taille_selectionnee')
        ]);

        return redirect()->back()->with('success', 'Article ajouté au panier !');
    }

    /**
     * Remove an item from the cart.
     */
    public function remove($id)
    {
        if (Auth::check()) {
            CartItem::where('user_id', Auth::id())
                    ->where('objet_louable_id', $id)
                    ->delete();
        }

        return redirect()->back()->with('success', 'Article retiré du panier.');
    }

    /**
     * Clear the cart.
     */
    public function clear()
    {
        if (Auth::check()) {
            CartItem::where('user_id', Auth::id())->delete();
        }
        return redirect()->back()->with('success', 'Panier vidé.');
    }
}
``

### Remplacez tout le contenu de : app/Http/Controllers/ReservationController.php

``php
<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reservations = Reservation::with('objetLouable')->where('user_id', auth()->id() ?? 1)->latest()->get();
        return view('reservations.index', compact('reservations'));
    }

    public function create(\Illuminate\Http\Request $request)
    {
        $objets = collect();
        $reservedDates = [];

        if ($request->has('objet')) {
            $objet = \App\Models\ObjetLouable::with('photos')->find($request->query('objet'));
            if ($objet) $objets->push($objet);
        } elseif ($request->has('items')) {
            $ids = explode(',', $request->query('items'));
            $objets = \App\Models\ObjetLouable::with('photos')->whereIn('id', $ids)->get();
        }

        if ($objets->isNotEmpty()) {
            // Get all confirmed or paid reservations for these objects
            $reservations = Reservation::whereIn('objet_louable_id', $objets->pluck('id'))
                ->whereIn('statut', ['confirmee', 'payee'])
                ->where('date_fin', '>=', now()->subDays(3)->toDateString())
                ->get();

            foreach ($reservations as $res) {
                // Logistique: 1 jour avant (livraison), 2 jours après (retour + maintenance)
                $start = (new \DateTime($res->date_debut))->modify('-1 day');
                $end = (new \DateTime($res->date_fin))->modify('+2 days');

                $period = new \DatePeriod(
                    $start,
                    new \DateInterval('P1D'),
                    $end->modify('+1 day')
                );
                foreach ($period as $date) {
                    $reservedDates[] = $date->format('Y-m-d');
                }
            }
            // Retirer les doublons de dates
            $reservedDates = array_values(array_unique($reservedDates));
        }
        
        $objet = $objets->first(); // Compatibilité avec l'ancienne vue pour le moment
        return view('reservations.create', compact('objets', 'objet', 'reservedDates'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'date_debut' => 'required|date|after_or_equal:today',
            'date_fin' => 'required|date|after_or_equal:date_debut',
            'objet_louable_ids' => 'required|string',
            'montant_total' => 'required|numeric|min:0',
            'nom' => 'required|string|max:255',
            'ville' => 'required|string|max:255',
            'telephone' => 'required|string|size:10|regex:/^[0-9]{10}$/',
            'adresse' => 'required|string',
            'cin' => 'required|string|max:50',
        ]);

        $ids = explode(',', $validated['objet_louable_ids']);
        $objets = \App\Models\ObjetLouable::whereIn('id', $ids)->get();
        $reservationsIds = [];

        foreach ($objets as $objet) {
            // Check for availability with buffer (1 day before, 2 days after)
            $existingReservations = Reservation::where('objet_louable_id', $objet->id)
                ->whereIn('statut', ['confirmee', 'payee'])
                ->get();

            foreach ($existingReservations as $res) {
                $blocked_start = (new \DateTime($res->date_debut))->modify('-1 day')->format('Y-m-d');
                $blocked_end = (new \DateTime($res->date_fin))->modify('+2 days')->format('Y-m-d');

                if ($validated['date_debut'] <= $blocked_end && $blocked_start <= $validated['date_fin']) {
                    return back()->withInput()->withErrors(['dates' => "L'article '{$objet->titre}' est indisponible aux dates sélectionnées."]);
                }
            }

            // Calcul du montant pour CET objet spécifique
            $start = new \DateTime($validated['date_debut']);
            $end = new \DateTime($validated['date_fin']);
            $diffDays = max(1, $end->diff($start)->days);
            if ($start > $end) $diffDays = 0;
            
            $montantObjet = $diffDays * $objet->prix;

            $reservation = Reservation::create([
                'user_id' => auth()->id(),
                'objet_louable_id' => $objet->id,
                'date_debut' => $validated['date_debut'],
                'date_fin' => $validated['date_fin'],
                'statut' => 'en_attente_paiement',
                'montant_total' => $montantObjet,
                'nom' => $validated['nom'],
                'ville' => $validated['ville'],
                'telephone' => $validated['telephone'],
                'adresse' => $validated['adresse'],
                'cin' => $validated['cin'],
            ]);

            $reservationsIds[] = $reservation->id;
        }

        return redirect()->route('paiements.checkout', ['ids' => implode(',', $reservationsIds)]);
    }

    public function show(Reservation $reservation)
    {
        return view('reservations.show', compact('reservation'));
    }

    public function edit(Reservation $reservation)
    {
        return view('reservations.edit', compact('reservation'));
    }

    public function update(Request $request, Reservation $reservation)
    {
        $validated = $request->validate([
            'statut' => 'required|string|in:en_attente,confirmee,annulee',
        ]);

        $reservation->update($validated);

        return to_route('reservations.show', $reservation->id)->with('success', 'Statut mis à jour.');
    }

    public function accept(Reservation $reservation)
    {
        // Vérifier que l'utilisateur connecté est le propriétaire de l'objet
        if ($reservation->objetLouable->user_id !== auth()->id()) {
            abort(403);
        }

        // Double check availability before confirming with buffer
        $reservations = Reservation::where('objet_louable_id', $reservation->objet_louable_id)
            ->where('statut', 'confirmee')
            ->where('id', '!=', $reservation->id)
            ->get();

        foreach ($reservations as $res) {
            $blocked_start = (new \DateTime($res->date_debut))->modify('-1 day')->format('Y-m-d');
            $blocked_end = (new \DateTime($res->date_fin))->modify('+2 days')->format('Y-m-d');

            if ($reservation->date_debut <= $blocked_end && $blocked_start <= $reservation->date_fin) {
                return back()->with('error', 'Impossible d\'accepter cette réservation : l\'article est indisponible à cause d\'une autre réservation et des délais logistiques.');
            }
        }

        $reservation->update(['statut' => 'confirmee']);

        // Notify Renter
        $reservation->user->notify(new \App\Notifications\AdStatusChanged(
            "Bonne nouvelle ! Votre réservation pour '{$reservation->objetLouable->titre}' a été acceptée.",
            $reservation->objet_louable_id,
            'success'
        ));

        return back()->with('success', 'La réservation a été acceptée.');
    }

    public function reject(Reservation $reservation)
    {
        // Vérifier que l'utilisateur connecté est le propriétaire de l'objet
        if ($reservation->objetLouable->user_id !== auth()->id()) {
            abort(403);
        }

        $reservation->update(['statut' => 'annulee']);

        // Notify Renter
        $reservation->user->notify(new \App\Notifications\AdStatusChanged(
            "Votre demande de réservation pour '{$reservation->objetLouable->titre}' a été refusée.",
            $reservation->objet_louable_id,
            'error'
        ));

        return back()->with('success', 'La réservation a été refusée.');
    }

    public function ticket(Reservation $reservation)
    {
        // Seul le propriétaire de l'objet peut voir le ticket
        if ($reservation->objetLouable->user_id !== auth()->id()) {
            abort(403);
        }

        $reservation->load(['objetLouable.photos', 'user', 'paiement']);
        return view('reservations.ticket', compact('reservation'));
    }

    public function destroy(Reservation $reservation)
    {
        $reservation->delete();
        return to_route('reservations.index')->with('success', 'Réservation annulée.');
    }
}
``

### Remplacez tout le contenu de : app/Http/Controllers/PaiementController.php

``php
<?php

namespace App\Http\Controllers;

use App\Models\Paiement;
use App\Models\Reservation;
use Illuminate\Http\Request;

class PaiementController extends Controller
{
    public function checkout(Request $request)
    {
        $ids = explode(',', $request->query('ids'));
        $reservations = Reservation::whereIn('id', $ids)->get();

        if ($reservations->isEmpty()) {
            return back()->with('error', 'Aucune réservation trouvée.');
        }

        // Vérifier l'appartenance et le statut
        foreach ($reservations as $reservation) {
            if ($reservation->user_id !== auth()->id() || !in_array($reservation->statut, ['en_attente_paiement', 'confirmee'])) {
                return back()->with('error', 'Une ou plusieurs réservations ne peuvent pas être payées.');
            }
            if ($reservation->paiement || $reservation->statut === 'payee') {
                return back()->with('error', 'Une réservation a déjà été payée.');
            }
        }

        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

        $lineItems = [];
        foreach ($reservations as $reservation) {
            $lineItems[] = [
                'price_data' => [
                    'currency' => 'mad',
                    'product_data' => [
                        'name' => 'Location : ' . $reservation->objetLouable->titre,
                        'description' => 'Du ' . \Carbon\Carbon::parse($reservation->date_debut)->format('d/m/Y') . ' au ' . \Carbon\Carbon::parse($reservation->date_fin)->format('d/m/Y'),
                    ],
                    'unit_amount' => $reservation->montant_total * 100,
                ],
                'quantity' => 1,
            ];
        }

        // Création de la session Stripe
        $session = \Stripe\Checkout\Session::create([
            'payment_method_types' => ['card'],
            'line_items' => $lineItems,
            'mode' => 'payment',
            'success_url' => route('paiements.success') . '?session_id={CHECKOUT_SESSION_ID}&reservation_ids=' . implode(',', $ids),
            'cancel_url' => route('paiements.cancel'),
        ]);

        return redirect()->away($session->url);
    }

    public function success(Request $request)
    {
        $sessionId = $request->get('session_id');
        $reservationIds = array_filter(explode(',', $request->get('reservation_ids')));

        if (!$sessionId || empty($reservationIds)) {
            return redirect()->route('dashboard')->with('error', 'Paiement invalide.');
        }

        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

        try {
            $session = \Stripe\Checkout\Session::retrieve($sessionId);

            if ($session->payment_status == 'paid') {
                $reservations = \App\Models\Reservation::whereIn('id', $reservationIds)->get();
                
                foreach ($reservations as $reservation) {
                    // 1. Enregistrer le paiement en base (proportionnel)
                    Paiement::firstOrCreate(
                        ['reservation_id' => $reservation->id],
                        [
                            'montant' => $reservation->montant_total,
                            'date_paie' => now(),
                            'statut' => 'valide',
                        ]
                    );

                    // 2. Mettre à jour le statut de la réservation
                    $reservation->update(['statut' => 'payee']);

                    // 3. Envoyer une notification au propriétaire
                    $objet = $reservation->objetLouable;
                    $objet->user->notify(new \App\Notifications\AdStatusChanged(
                        "Nouvelle demande de location PAYÉE pour votre article '{$objet->titre}'. Le paiement a été validé automatiquement.",
                        $objet->id,
                        'success',
                        route('dashboard') . '#demandes-recues'
                    ));
                }
                
                // Vider le panier après paiement réussi
                \App\Models\CartItem::where('user_id', auth()->id())->delete();
                
                $msg = "Paiement réussi ! Le livreur vous contactera pour la livraison.\n\n🔒 Pour garantir la sécurité, une vérification d'identité (CIN) sera effectuée lors de la remise.\n\nMerci pour votre confiance.";

                return redirect()->route('dashboard')->with('success', $msg);
            }
        } catch (\Exception $e) {
            return redirect()->route('dashboard')->with('error', 'Erreur lors de la vérification du paiement : ' . $e->getMessage());
        }

        return redirect()->route('dashboard')->with('error', 'Le paiement n\'a pas pu être validé.');
    }

    public function cancel()
    {
        return redirect()->route('dashboard')->with('error', 'Vous avez annulé le paiement. Vous pourrez réessayer plus tard.');
    }
}
``

### Remplacez tout le contenu de : routes/web.php

``php
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
    Route::get('/paiements/checkout', [PaiementController::class, 'checkout'])->name('paiements.checkout');
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
``

### Remplacez tout le contenu de : resources/views/layouts/navigation.blade.php

``php
<nav x-data="{ open: false }" class="bg-white/90 backdrop-blur-md border-b border-gray-100 shadow-sm sticky top-0 z-50">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ url('/') }}" class="flex items-center">
                        <img src="{{ asset('images/logo_text.png') }}" alt="Fassia" class="h-14 w-auto object-contain hover:opacity-80 transition">
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-6 sm:-my-px sm:ms-6 sm:flex">
                    <x-nav-link :href="route('objets.index')" :active="request()->routeIs('objets.index')" class="text-sm font-medium text-royal-dark hover:text-royal-gold transition">
                        {{ __('Catalogue') }}
                    </x-nav-link>
                    @auth
                        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-sm font-medium text-royal-dark hover:text-royal-gold transition">
                            {{ __('Tableau de bord') }}
                        </x-nav-link>
                        <x-nav-link :href="route('reservations.index')" :active="request()->routeIs('reservations.index')" class="text-sm font-medium text-royal-dark hover:text-royal-gold transition">
                            {{ __('Mes Réservations') }}
                        </x-nav-link>
                        @if(auth()->check() && auth()->user()->role === 'admin')
                            <x-nav-link :href="route('admin.objets.index')" :active="request()->routeIs('admin.objets.index')" class="text-sm font-medium text-royal-dark hover:text-royal-gold transition">
                                {{ __('Modération') }}
                            </x-nav-link>
                        @endif
                    @endauth
                </div>
            </div>

            <!-- Settings Dropdown / Login -->
            <div class="hidden sm:flex sm:items-center sm:ms-2">
                <!-- Messages Icon -->
                @auth
                    <a href="{{ route('messages.index') }}" class="mr-4 relative group text-royal-gold hover:text-royal-dark transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
                        </svg>
                        @php 
                            $unreadMessages = \App\Models\Message::where('destinataire_id', auth()->id())->whereNull('lu_a')->count();
                        @endphp
                            @if($unreadMessages > 0)
                                <span class="absolute -top-1 -right-1 flex h-3 w-3">
                                    <span class="relative inline-flex rounded-full h-3 w-3 bg-red-600 border border-white"></span>
                                </span>
                            @endif
                    </a>

                    <!-- Notifications Bell -->
                    <div class="relative flex items-center mr-4" x-data="{ openNotifications: false }">
                        <button @click="openNotifications = !openNotifications" class="relative group text-royal-gold hover:text-royal-dark transition focus:outline-none">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                            </svg>
                            @php
                                $unreadNotifications = auth()->user()->unreadNotifications->count();
                            @endphp
                            @if($unreadNotifications > 0)
                                <span class="absolute -top-1 -right-1 flex h-4 w-4 z-20">
                                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                                    <span class="relative inline-flex rounded-full h-4 w-4 bg-red-600 text-white text-[8px] font-bold items-center justify-center shadow-sm border border-white">
                                        {{ $unreadNotifications }}
                                    </span>
                                </span>
                            @endif
                        </button>

                        <!-- Notifications Dropdown -->
                        <div x-show="openNotifications" 
                             @click.away="openNotifications = false" 
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 translate-y-[-10px]"
                             x-transition:enter-end="opacity-100 translate-y-0"
                             style="position: fixed; top: 80px; right: 16px; width: 420px; z-index: 9999;"
                             class="bg-white rounded-[2rem] shadow-[0_20px_60px_rgba(0,0,0,0.15)] border border-gray-100 py-4 overflow-hidden" 
                             x-cloak>
                            <div class="px-8 py-3 border-b border-gray-50 flex justify-between items-center bg-gray-50/30">
                                <span class="text-[10px] font-black text-royal-dark uppercase tracking-[0.2em]">Notifications</span>
                                @if($unreadNotifications > 0)
                                    <a href="{{ route('notifications.markAllRead') }}" class="text-[9px] font-bold text-royal-gold hover:underline uppercase">Tout marquer comme lu</a>
                                @endif
                            </div>
                            <div class="max-h-96 overflow-y-auto">
                                @forelse(auth()->user()->unreadNotifications->take(5) as $notification)
                                    <a href="{{ route('notifications.read', $notification->id) }}" class="block px-8 py-5 hover:bg-gray-50 transition border-b border-gray-50 last:border-0 {{ $notification->unread() ? 'bg-amber-50/20' : '' }}">
                                        <div class="flex gap-4">
                                            <div class="shrink-0 w-10 h-10 rounded-2xl flex items-center justify-center {{ $notification->data['type'] === 'success' ? 'bg-green-100 text-green-600' : ($notification->data['type'] === 'error' ? 'bg-red-100 text-red-600' : 'bg-amber-100 text-amber-600') }}">
                                                @if($notification->data['type'] === 'success')
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                                @elseif($notification->data['type'] === 'error')
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                                                @else
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                                @endif
                                            </div>
                                            <div class="flex-1">
                                                <p class="text-sm text-gray-600 leading-relaxed font-medium">{{ $notification->data['message'] }}</p>
                                                <p class="text-[10px] text-gray-400 mt-1 font-bold uppercase tracking-tight">{{ $notification->created_at->diffForHumans() }}</p>
                                            </div>
                                        </div>
                                    </a>
                                @empty
                                    <div class="px-8 py-12 text-center">
                                        <p class="text-sm text-gray-400 italic">Aucune notification pour le moment.</p>
                                    </div>
                                @endforelse
                            </div>
                            @if(auth()->user()->role === 'admin')
                                <a href="{{ route('admin.objets.index') }}" class="block text-center py-5 text-xs font-black text-royal-gold hover:bg-gray-50 transition border-t border-gray-50 uppercase tracking-[0.2em]">Voir toutes les annonces</a>
                            @endif
                        </div>
                    </div>
                @endauth

                <!-- Cart Icon -->
                <a href="{{ route('cart.index') }}" class="mr-4 relative group text-royal-gold hover:text-royal-dark transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                    @if(Auth::check())
                        @php
                            $cartCount = \App\Models\CartItem::where('user_id', Auth::id())->count();
                        @endphp
                        @if($cartCount > 0)
                            <span class="absolute -top-2 -right-2 bg-royal-emerald text-white text-[10px] font-bold rounded-full h-5 w-5 flex items-center justify-center shadow-sm">
                                {{ $cartCount }}
                            </span>
                        @endif
                    @endif
                </a>

                @auth
                    <!-- Publish Button -->
                    <a href="{{ route('objets.create') }}" class="mr-4 inline-flex items-center px-4 py-2 bg-royal-gold border border-transparent rounded-full font-semibold text-xs text-white uppercase tracking-widest hover:opacity-90 transition whitespace-nowrap">
                        {{ __('Publier un article') }}
                    </a>
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-royal-dark bg-transparent hover:text-royal-gold focus:outline-none transition ease-in-out duration-150">
                                <div class="flex items-center gap-2">
                                    <div class="w-8 h-8 rounded-full bg-royal-gold/10 flex items-center justify-center overflow-hidden border border-royal-gold/20">
                                        @if(Auth::user()->photo)
                                            <img src="{{ asset('storage/' . Auth::user()->photo) }}" class="w-full h-full object-cover">
                                        @else
                                            <span class="text-xs font-bold text-royal-gold">{{ strtoupper(substr(Auth::user()->nom ?? Auth::user()->name, 0, 1)) }}</span>
                                        @endif
                                    </div>
                                    <div>{{ Auth::user()->nom ?? Auth::user()->name ?? 'Mon Compte' }}</div>
                                </div>

                                <div class="ms-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')">
                                {{ __('Profil') }}
                            </x-dropdown-link>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault();
                                                    this.closest('form').submit();">
                                    {{ __('Déconnexion') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @else
                    <a href="{{ route('login') }}" class="text-sm text-royal-dark hover:text-royal-gold font-medium mr-4 transition">Connexion</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="inline-flex items-center px-4 py-2 bg-royal-emerald border border-transparent rounded-full font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-800 transition ease-in-out duration-150">Inscription</a>
                    @endif
                @endauth
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-royal-gold hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('objets.index')" :active="request()->routeIs('objets.index')">
                {{ __('Catalogue') }}
            </x-responsive-nav-link>
            @auth
                <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                    {{ __('Tableau de bord') }}
                </x-responsive-nav-link>
            @endauth
        </div>

        @auth
            <!-- Responsive Settings Options -->
            <div class="pt-4 pb-1 border-t border-gray-200">
                <div class="px-4 flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-royal-gold/10 flex items-center justify-center overflow-hidden border border-royal-gold/20">
                        @if(Auth::user()->photo)
                            <img src="{{ asset('storage/' . Auth::user()->photo) }}" class="w-full h-full object-cover">
                        @else
                            <span class="text-sm font-bold text-royal-gold">{{ strtoupper(substr(Auth::user()->nom ?? Auth::user()->name, 0, 1)) }}</span>
                        @endif
                    </div>
                    <div>
                        <div class="font-medium text-base text-royal-emerald">{{ Auth::user()->nom ?? Auth::user()->name }}</div>
                        <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                    </div>
                </div>

                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('profile.edit')">
                        {{ __('Profil') }}
                    </x-responsive-nav-link>

                    <!-- Authentication -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <x-responsive-nav-link :href="route('logout')"
                                onclick="event.preventDefault();
                                            this.closest('form').submit();">
                            {{ __('Déconnexion') }}
                        </x-responsive-nav-link>
                    </form>
                </div>
            </div>
        @else
            <div class="pt-4 pb-1 border-t border-gray-200">
                <x-responsive-nav-link :href="route('login')">
                    {{ __('Connexion') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('register')">
                    {{ __('Inscription') }}
                </x-responsive-nav-link>
            </div>
        @endauth
    </div>
</nav>
``

### Remplacez tout le contenu de : resources/views/cart/index.blade.php

``php
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-royal-emerald leading-tight font-heading">
            {{ __('Mon Panier') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-royal-sand min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">


            <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-100">
                <div class="p-8 lg:p-12 mb-4" x-data="cartManager()">
                    @if(count($items) > 0)
                        <div class="flex flex-col lg:flex-row gap-8">
                            <!-- Items List -->
                            <div class="flex-1">
                                <div class="space-y-8">
                                    @foreach($items as $item)
                                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 p-5 rounded-2xl bg-white border transition duration-300 group"
                                             :class="selectedItems.includes('{{ $item['objet']->id }}') ? 'border-royal-emerald shadow-md ring-1 ring-royal-emerald/20' : 'border-gray-100 hover:shadow-lg'">
                                            
                                            <!-- Image & Infos -->
                                            <div class="flex items-center gap-4 flex-1 min-w-0">
                                                <!-- Custom Checkbox -->
                                                <div class="flex-shrink-0 mr-1">
                                                    <input type="checkbox" value="{{ $item['objet']->id }}" x-model="selectedItems" class="w-5 h-5 text-royal-emerald border-gray-300 rounded focus:ring-royal-emerald cursor-pointer shadow-sm">
                                                </div>

                                                <div class="w-24 h-24 sm:w-28 sm:h-28 flex-shrink-0 bg-gray-50 rounded-xl overflow-hidden border border-gray-100 shadow-sm relative cursor-pointer"
                                                     @click="toggleItem('{{ $item['objet']->id }}')">
                                                    @if($item['objet']->photos->first())
                                                        <img src="{{ asset('storage/' . $item['objet']->photos->first()->url_photo) }}" class="w-full h-full object-cover">
                                                    @else
                                                        <div class="w-full h-full flex items-center justify-center text-gray-400">
                                                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                                        </div>
                                                    @endif
                                                </div>
                                                
                                                <div class="flex-1 min-w-0 pr-4">
                                                    <!-- Utilisation de 'truncate' assure qu'un très long texte restera sur une ligne avec des "..." -->
                                                    <h3 class="text-xl font-bold text-gray-900 font-heading truncate mb-2">{{ $item['objet']->titre }}</h3>
                                                    
                                                    <!-- Attributs bien alignés -->
                                                    <div class="flex flex-wrap items-center gap-3 text-sm text-gray-500">
                                                        <span class="inline-flex items-center gap-1.5">
                                                            <div class="w-1.5 h-1.5 rounded-full bg-gray-400"></div>{{ $item['objet']->type }}
                                                        </span>
                                                        @if($item['objet']->couleur)
                                                            <span class="inline-flex items-center gap-1.5">
                                                                <div class="w-3 h-3 rounded-full border border-gray-200" style="background-color: {{ strtolower($item['objet']->couleur) }}"></div>{{ $item['objet']->couleur }}
                                                            </span>
                                                        @endif
                                                        @if(isset($item['taille']) && !empty($item['taille']))
                                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 bg-gray-100 rounded-md text-gray-700 font-medium whitespace-nowrap">
                                                                Pointure: <strong class="ml-1 text-royal-emerald">{{ $item['taille'] }}</strong>
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <!-- Prix & Suppression -->
                                            <div class="flex sm:flex-col items-center sm:items-end justify-between gap-3 border-t sm:border-t-0 sm:border-l border-gray-100 pt-4 sm:pt-0 sm:pl-6 w-full sm:w-auto">
                                                <div class="text-right flex sm:block items-baseline gap-2">
                                                    <div class="text-xl font-bold text-gray-900 tracking-tight whitespace-nowrap">
                                                        {{ number_format($item['objet']->prix, 2) }} DH
                                                    </div>
                                                    <span class="text-xs font-medium text-gray-400 block sm:mt-1 whitespace-nowrap">/ jour</span>
                                                </div>
                                                
                                                <form action="{{ route('cart.remove', $item['objet']->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" title="Supprimer cet article" class="text-red-500 hover:text-red-700 hover:bg-red-50 p-2.5 rounded-full transition flex items-center justify-center group/btn">
                                                        <svg class="w-5 h-5 group-hover/btn:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                    </button>
                                                </form>
                                            </div>
                                            
                                        </div>
                                    @endforeach
                                </div>

                                <div class="mt-12 pt-8 border-t border-gray-100 flex justify-between items-center">
                                    <a href="{{ route('objets.index') }}" class="text-royal-gold font-bold flex items-center gap-2 hover:translate-x-[-4px] transition duration-300">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7 7-7"></path></svg>
                                        Continuer mes choix
                                    </a>
                                    <form action="{{ route('cart.clear') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="text-gray-400 hover:text-royal-dark transition text-sm">Vider le panier</button>
                                    </form>
                                </div>
                            </div>

                            <!-- Summary Sidebar -->
                            <div class="w-full lg:w-80 xl:w-96">
                                <div class="bg-gray-50 rounded-3xl p-8 sticky top-24">
                                    <h3 class="text-2xl font-bold text-royal-emerald font-heading mb-6 border-b border-gray-200 pb-4">Résumé</h3>
                                    <div class="space-y-4 mb-8">
                                        <div class="flex justify-between text-gray-600">
                                            <span>Articles (<span x-text="selectedCount"></span>)</span>
                                            <span><span x-text="total"></span> DH</span>
                                        </div>
                                        <div class="flex justify-between text-gray-600">
                                            <span>Frais de service</span>
                                            <span class="text-green-600 font-medium">Offert</span>
                                        </div>
                                        <div class="pt-4 border-t border-gray-200 mt-4 flex justify-between items-end">
                                            <span class="text-royal-dark font-bold text-lg">Total</span>
                                            <div class="text-right flex items-baseline gap-1" :class="selectedCount === 0 ? 'opacity-50' : ''">
                                                <span class="text-3xl font-black text-royal-dark" x-text="total"></span>
                                                <span class="text-royal-dark font-bold">DH</span>
                                            </div>
                                        </div>
                                    </div>

                                    <a :href="`{{ route('reservations.create') }}${selectedCount > 0 ? '?items=' + selectedItems.join(',') : ''}`" 
                                       class="block w-full text-white text-center py-3.5 px-4 rounded-2xl font-bold text-lg shadow-lg hover:shadow-xl hover:-translate-y-0.5 transition-all duration-300"
                                       :class="selectedCount > 0 ? 'bg-royal-dark hover:bg-gray-800' : 'bg-gray-400 pointer-events-none'">
                                        Réserver <span x-text="selectedCount"></span> article(s)
                                    </a>
                                    <p class="text-[10px] text-center text-gray-400 mt-4">En cliquant sur réserver, vous confirmez les disponibilités avec les loueurs.</p>
                                </div>
                            </div>
                        </div>

                        <script>
                            function cartManager() {
                                return {
                                    itemsPrices: {
                                        @foreach($items as $item)
                                        '{{ $item['objet']->id }}': {{ $item['objet']->prix * $item['quantity'] }},
                                        @endforeach
                                    },
                                    selectedItems: [
                                        @foreach($items as $item)
                                        '{{ $item['objet']->id }}',
                                        @endforeach
                                    ],
                                    toggleItem(id) {
                                        const i = this.selectedItems.indexOf(id);
                                        if (i > -1) this.selectedItems.splice(i, 1);
                                        else this.selectedItems.push(id);
                                    },
                                    get total() {
                                        let sum = 0;
                                        this.selectedItems.forEach(id => {
                                            if (this.itemsPrices[id]) sum += parseFloat(this.itemsPrices[id]);
                                        });
                                        return new Intl.NumberFormat('fr-FR', { minimumFractionDigits: 2, maximumFractionDigits: 2 }).format(sum).replace(',', '.');
                                    },
                                    get selectedCount() {
                                        return this.selectedItems.length;
                                    }
                                }
                            }
                        </script>
                    @else
                        <div class="text-center py-20">
                            <div class="w-32 h-32 bg-royal-sand rounded-full flex items-center justify-center mx-auto mb-8">
                                <svg class="w-16 h-16 text-royal-gold opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                </svg>
                            </div>
                            <h3 class="text-3xl font-bold text-royal-dark font-heading mb-4">Votre panier est vide</h3>
                            <p class="text-gray-500 mb-10 max-w-sm mx-auto text-lg leading-relaxed">Parcourez notre collection et trouvez la tenue parfaite pour votre prochain événement.</p>
                            <a href="{{ route('objets.index') }}" class="inline-flex items-center px-10 py-4 bg-royal-gold text-white rounded-full font-bold text-lg shadow-lg hover:shadow-2xl hover:scale-105 transition transform duration-300">
                                Découvrir le catalogue
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
``

### Remplacez tout le contenu de : resources/views/reservations/create.blade.php

``php
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-royal-emerald leading-tight font-heading">
            {{ __('Finaliser la réservation') }}
        </h2>
    </x-slot>

    <!-- Flatpickr Assets -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/themes/material_green.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/fr.js"></script>

    <style>
        .flatpickr-day.is-reserved {
            background: #fee2e2 !important; /* light red */
            color: #ef4444 !important; /* red */
            text-decoration: line-through;
            cursor: not-allowed;
            border-color: #fecaca !important;
        }
    </style>

    <div class="py-12 bg-royal-sand min-h-screen" x-data="reservationForm()">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-3xl border border-gray-100 flex flex-col md:flex-row">
                
                @if($objets->isNotEmpty())
                <!-- Resume Section -->
                <div class="w-full md:w-1/3 bg-gray-50 p-8 sm:p-10 border-r border-gray-100 flex flex-col">
                    <h3 class="text-sm font-bold tracking-widest text-royal-gold uppercase mb-6">Résumé de la commande ({{ $objets->count() }} articles)</h3>
                    
                    <div class="space-y-6 flex-1 overflow-y-auto max-h-[500px] pr-2">
                    @foreach($objets as $obj)
                        <div class="flex items-center gap-4 bg-white p-3 rounded-xl shadow-sm border border-gray-100">
                            @if($obj->photos && $obj->photos->count() > 0)
                                <img src="{{ asset('storage/' . $obj->photos->first()->url_photo) }}" class="w-16 h-16 object-cover rounded-lg">
                            @else
                                <div class="w-16 h-16 bg-gray-200 rounded-lg flex items-center justify-center text-[10px] text-gray-400">Sans image</div>
                            @endif
                            <div class="flex-1 min-w-0">
                                <p class="font-heading font-bold text-sm text-royal-dark truncate">{{ $obj->titre }}</p>
                                <p class="text-xs text-gray-500 font-medium">{{ number_format($obj->prix, 2) }} DH/j</p>
                            </div>
                        </div>
                    @endforeach
                    </div>
                    
                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600 font-medium">Tarif journalier total</span>
                            <span class="font-bold text-xl text-royal-dark">{{ number_format($objets->sum('prix'), 2) }} DH</span>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Form Section -->
                <div class="w-full md:w-2/3 p-8 sm:p-12">
                    <form method="POST" action="{{ route('reservations.store') }}">
                        @csrf
                        @if($objets->isNotEmpty())
                            <input type="hidden" name="objet_louable_ids" value="{{ $objets->pluck('id')->join(',') }}">
                        @endif

                        <h3 class="text-2xl font-heading text-royal-dark font-bold mb-8">Détails de location</h3>

                        @if($errors->has('dates'))
                            <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 text-sm font-medium rounded-r-xl shadow-sm">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    {{ $errors->first('dates') }}
                                </div>
                            </div>
                        @endif

                        @if(!$objet)
                        <div class="mb-6">
                            <x-input-label for="objet_louable_id" :value="__('ID de l\'article')" />
                            <x-text-input id="objet_louable_id" class="block mt-1 w-full" type="number" name="objet_louable_id" :value="old('objet_louable_id')" required />
                            <x-input-error :messages="$errors->get('objet_louable_id')" class="mt-2" />
                        </div>
                        @endif

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-6" x-init="initDatepickers()">
                            <div>
                                <x-input-label for="date_debut" :value="__('Date de retrait')" class="text-gray-700" />
                                <x-text-input id="date_debut" class="block mt-1 w-full border-gray-300 rounded-lg focus:ring-royal-emerald bg-white" type="text" name="date_debut" x-model="dateDebut" placeholder="Sélectionner une date" required />
                                <x-input-error :messages="$errors->get('date_debut')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="date_fin" :value="__('Date de retour')" class="text-gray-700" />
                                <x-text-input id="date_fin" class="block mt-1 w-full border-gray-300 rounded-lg focus:ring-royal-emerald bg-white" type="text" name="date_fin" x-model="dateFin" placeholder="Sélectionner une date" required />
                                <x-input-error :messages="$errors->get('date_fin')" class="mt-2" />
                            </div>
                        </div>

                        <h3 class="text-xl font-heading text-royal-dark font-bold mb-6 mt-8">Vos informations de livraison</h3>
                        
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-6">
                            <div>
                                <x-input-label for="nom" :value="__('Nom complet')" class="text-gray-700" />
                                <x-text-input id="nom" class="block mt-1 w-full border-gray-300 rounded-lg focus:ring-royal-emerald" type="text" name="nom" :value="old('nom', auth()->user()->nom . ' ' . auth()->user()->prenom)" required />
                                <x-input-error :messages="$errors->get('nom')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="cin" :value="__('Numéro de CIN')" class="text-gray-700" />
                                <x-text-input id="cin" class="block mt-1 w-full border-gray-300 rounded-lg focus:ring-royal-emerald" type="text" name="cin" :value="old('cin')" placeholder="ex: AB123456" required />
                                <x-input-error :messages="$errors->get('cin')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="telephone" :value="__('Téléphone')" class="text-gray-700" />
                                <x-text-input id="telephone" class="block mt-1 w-full border-gray-300 rounded-lg focus:ring-royal-emerald" type="tel" name="telephone" :value="old('telephone', auth()->user()->tel)" maxlength="10" pattern="[0-9]{10}" placeholder="0612345678" required />
                                <x-input-error :messages="$errors->get('telephone')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="ville" :value="__('Ville')" class="text-gray-700" />
                                <x-text-input id="ville" class="block mt-1 w-full border-gray-300 rounded-lg focus:ring-royal-emerald" type="text" name="ville" :value="old('ville')" required />
                                <x-input-error :messages="$errors->get('ville')" class="mt-2" />
                            </div>
                            <div class="sm:col-span-2">
                                <x-input-label for="adresse" :value="__('Adresse complète')" class="text-gray-700" />
                                <x-text-input id="adresse" class="block mt-1 w-full border-gray-300 rounded-lg focus:ring-royal-emerald" type="text" name="adresse" :value="old('adresse', auth()->user()->adr)" required />
                                <x-input-error :messages="$errors->get('adresse')" class="mt-2" />
                            </div>
                            <div class="sm:col-span-2">
                                <x-input-label for="pays" :value="__('Pays')" class="text-gray-700" />
                                <x-text-input id="pays" class="block mt-1 w-full border-gray-300 bg-gray-100 rounded-lg text-gray-500 cursor-not-allowed" type="text" name="pays" value="Maroc uniquement" readonly />
                            </div>
                        </div>

                        <div class="bg-gray-50 p-6 rounded-2xl border border-gray-100 mb-10 mt-8">
                            <div class="flex justify-between items-center mb-4">
                                <span class="text-gray-600 font-medium">Durée de la location</span>
                                <span class="font-bold text-royal-dark bg-white px-3 py-1 rounded-md border border-gray-200" x-text="days + ' jour(s)'"></span>
                            </div>
                            <div class="flex justify-between items-center border-t border-gray-200 pt-4 mt-2">
                                <span class="text-lg font-heading font-bold text-royal-emerald">Montant Total</span>
                                <span class="text-3xl font-extrabold text-royal-dark font-heading">
                                    <span x-text="montantTotal">0</span> <span class="text-lg text-gray-500 font-sans font-medium">DH</span>
                                </span>
                            </div>
                            <input type="hidden" name="montant_total" x-bind:value="montantTotal">
                            <x-input-error :messages="$errors->get('montant_total')" class="mt-2" />
                        </div>

                        <div class="flex flex-col-reverse sm:flex-row items-center justify-end gap-4 mt-8 pt-8 border-t border-gray-100">
                            <a href="{{ url()->previous() }}" class="w-full sm:w-auto text-center text-gray-500 hover:text-gray-800 font-medium sm:mr-4 transition">Annuler</a>
                            <button type="submit" class="w-full sm:w-auto inline-flex justify-center items-center px-8 py-4 bg-royal-emerald border border-transparent rounded-full font-bold text-white uppercase tracking-widest hover:bg-green-700 transition shadow-lg hover:shadow-xl transform hover:-translate-y-1 disabled:opacity-50 disabled:cursor-not-allowed" x-bind:disabled="days <= 0">
                                Réserver et Payer
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- AlpineJS logic for dynamic calculation -->
    <script>
        function reservationForm() {
            return {
                dateDebut: '{{ old('date_debut') }}',
                dateFin: '{{ old('date_fin') }}',
                prixJour: {{ $objets->sum('prix') }},
                days: 0,
                montantTotal: '{{ old('montant_total', 0) }}',
                reservedDates: @json($reservedDates),
                fpStart: null,
                fpEnd: null,

                initDatepickers() {
                    const self = this;
                    const config = {
                        locale: "fr",
                        dateFormat: "Y-m-d",
                        minDate: "today",
                        disable: this.reservedDates,
                        onDayCreate: function(dObj, dStr, fp, dayElem) {
                            const dateStr = fp.formatDate(dayElem.dateObj, "Y-m-d");
                            if (self.reservedDates.includes(dateStr)) {
                                dayElem.classList.add("is-reserved");
                                dayElem.setAttribute("title", "Date déjà réservée");
                            }
                        }
                    };

                    this.fpStart = flatpickr("#date_debut", {
                        ...config,
                        onChange: function(selectedDates, dateStr) {
                            if (selectedDates.length > 0) {
                                self.fpEnd.set('minDate', selectedDates[0]);
                            }
                            self.dateDebut = dateStr;
                            self.calculateTotal();
                        }
                    });

                    this.fpEnd = flatpickr("#date_fin", {
                        ...config,
                        onChange: function(selectedDates, dateStr) {
                            if (selectedDates.length > 0) {
                                self.fpStart.set('maxDate', selectedDates[0]);
                            }
                            self.dateFin = dateStr;
                            self.calculateTotal();
                        }
                    });
                },
                
                calculateTotal() {
                    if (this.dateDebut && this.dateFin) {
                        const start = new Date(this.dateDebut);
                        const end = new Date(this.dateFin);
                        const diffTime = Math.abs(end - start);
                        // Same day = 1 day minimum, otherwise the number of days between dates
                        const diffDays = Math.max(1, Math.ceil(diffTime / (1000 * 60 * 60 * 24)));
                        
                        if (start <= end) {
                            this.days = diffDays;
                            this.montantTotal = (diffDays * this.prixJour).toFixed(2);
                        } else {
                            this.days = 0;
                            this.montantTotal = 0;
                        }
                    }
                }
            }
        }
    </script>
</x-app-layout>
``

## �tape 3 : Lancer la base de donn�es

Une fois tous les fichiers copi�s, ouvrez votre terminal dans le projet et lancez cette commande pour cr�er la table du panier :

``bash
php artisan migrate
``

C'est fini !
