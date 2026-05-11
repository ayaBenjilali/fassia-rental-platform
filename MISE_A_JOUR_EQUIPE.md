# Guide de Mise à Jour Complet (PFA-Rentals)

Ce document contient toutes les modifications récentes pour stabiliser le panier, corriger les doublons de réservations et améliorer la messagerie.

---

## 🚀 ÉTAPE 1 : Les Commandes à lancer
Avant de copier les fichiers, lancez ces commandes dans votre terminal (à la racine du projet) :

```bash
# 1. Créer le modèle CartItem
php artisan make:model CartItem -m

# 2. Créer la migration pour la messagerie privée
php artisan make:migration add_deleted_by_to_messages_table --table=messages

# 3. Une fois les fichiers copiés (voir étapes suivantes), lancez :
php artisan migrate
```

---

## 📂 ÉTAPE 2 : Nouveaux fichiers à configurer

### 1. Migration CartItem (database/migrations/..._create_cart_items_table.php)
```php
<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('cart_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('objet_louable_id')->constrained()->cascadeOnDelete();
            $table->integer('quantity')->default(1);
            $table->string('taille')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('cart_items'); }
};
```

### 2. Modèle CartItem (app/Models/CartItem.php)
```php
<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model {
    use HasFactory;
    protected $fillable = ['user_id', 'objet_louable_id', 'quantity', 'taille'];
    public function user() { return $this->belongsTo(User::class); }
    public function objetLouable() { return $this->belongsTo(ObjetLouable::class); }
}
```

### 3. Migration Messagerie (database/migrations/..._add_deleted_by_to_messages_table.php)
```php
<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('messages', function (Blueprint $table) {
            $table->boolean('deleted_by_expediteur')->default(false);
            $table->boolean('deleted_by_destinataire')->default(false);
        });
    }
    public function down(): void {
        Schema::table('messages', function (Blueprint $table) {
            $table->dropColumn(['deleted_by_expediteur', 'deleted_by_destinataire']);
        });
    }
};
```

---

## 🛠️ ÉTAPE 3 : Remplacer le contenu des fichiers existants

### 1. app/Models/Message.php
```php
<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Message extends Model {
    protected $fillable = [
        'contenu', 'expediteur_id', 'destinataire_id', 'lu_a', 'deleted_by_expediteur', 'deleted_by_destinataire'
    ];
    public function expediteur(): BelongsTo { return $this->belongsTo(User::class, 'expediteur_id'); }
    public function destinataire(): BelongsTo { return $this->belongsTo(User::class, 'destinataire_id'); }
}
```

### 2. app/Http/Controllers/MessageController.php (Suppression privée)
```php
<?php
namespace App\Http\Controllers;
use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller {
    public function index() {
        $userId = auth()->id();
        $conversations = Message::where(function($q) use ($userId) {
                $q->where('expediteur_id', $userId)->where('deleted_by_expediteur', false);
            })
            ->orWhere(function($q) use ($userId) {
                $q->where('destinataire_id', $userId)->where('deleted_by_destinataire', false);
            })
            ->latest()->get()->groupBy(function ($message) use ($userId) {
                return $message->expediteur_id === $userId ? $message->destinataire_id : $message->expediteur_id;
            });
        return view('messages.index', compact('conversations'));
    }

    public function conversation($interlocuteurId) {
        $userId = auth()->id();
        $interlocuteur = \App\Models\User::findOrFail($interlocuteurId);
        $messages = Message::where(function($q) use ($userId, $interlocuteurId) {
            $q->where('expediteur_id', $userId)->where('destinataire_id', $interlocuteurId)->where('deleted_by_expediteur', false);
        })->orWhere(function($q) use ($userId, $interlocuteurId) {
            $q->where('expediteur_id', $interlocuteurId)->where('destinataire_id', $userId)->where('deleted_by_destinataire', false);
        })->oldest()->get();
        
        Message::where('destinataire_id', $userId)->where('expediteur_id', $interlocuteurId)->whereNull('lu_a')->update(['lu_a' => now()]);
        return view('messages.show', compact('messages', 'interlocuteur'));
    }

    public function store(Request $request) {
        $validated = $request->validate(['contenu' => 'required|string', 'destinataire_id' => 'required|exists:users,id']);
        $validated['expediteur_id'] = auth()->id();
        Message::create($validated);
        return back();
    }

    public function destroy(Message $message) {
        if ($message->expediteur_id === auth()->id()) $message->update(['deleted_by_expediteur' => true]);
        if ($message->destinataire_id === auth()->id()) $message->update(['deleted_by_destinataire' => true]);
        return back();
    }

    public function destroyDiscussion($interlocuteurId) {
        \App\Models\Message::where('expediteur_id', auth()->id())->where('destinataire_id', $interlocuteurId)->update(['deleted_by_expediteur' => true]);
        \App\Models\Message::where('expediteur_id', $interlocuteurId)->where('destinataire_id', auth()->id())->update(['deleted_by_destinataire' => true]);
        return redirect()->route('messages.index');
    }
}
```

### 3. app/Http/Controllers/ReservationController.php (Fix Doublons & Tickets)
```php
<?php
namespace App\Http\Controllers;
use App\Models\Reservation;
use Illuminate\Http\Request;

class ReservationController extends Controller {
    public function index() {
        $reservations = Reservation::with('objetLouable')->where('user_id', auth()->id())->latest()->get();
        return view('reservations.index', compact('reservations'));
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'date_debut' => 'required|date', 'date_fin' => 'required|date',
            'objet_louable_ids' => 'required|string', 'montant_total' => 'required|numeric',
            'nom' => 'required|string', 'ville' => 'required|string', 'telephone' => 'required|string',
            'adresse' => 'required|string', 'cin' => 'required|string',
        ]);

        $ids = explode(',', $validated['objet_louable_ids']);
        $objets = \App\Models\ObjetLouable::whereIn('id', $ids)->get();
        $reservationsIds = [];

        foreach ($objets as $objet) {
            // FIX DOUBLONS : On vérifie si une résa impayée existe déjà
            $existingUnpaid = Reservation::where('user_id', auth()->id())
                ->where('objet_louable_id', $objet->id)
                ->where('date_debut', $validated['date_debut'])
                ->where('date_fin', $validated['date_fin'])
                ->where('statut', 'en_attente_paiement')->first();

            if ($existingUnpaid) {
                $reservationsIds[] = $existingUnpaid->id;
                continue;
            }

            $reservation = Reservation::create([
                'user_id' => auth()->id(), 'objet_louable_id' => $objet->id,
                'date_debut' => $validated['date_debut'], 'date_fin' => $validated['date_fin'],
                'statut' => 'en_attente_paiement', 'montant_total' => $validated['montant_total'],
                'nom' => $validated['nom'], 'ville' => $validated['ville'], 'telephone' => $validated['telephone'],
                'adresse' => $validated['adresse'], 'cin' => $validated['cin'],
            ]);
            $reservationsIds[] = $reservation->id;
        }
        return redirect()->route('paiements.checkout', ['ids' => implode(',', $reservationsIds)]);
    }

    public function ticket(Reservation $reservation) {
        // FIX PERMISSION : Autorise le locataire ET le proprio
        if ($reservation->objetLouable->user_id !== auth()->id() && $reservation->user_id !== auth()->id()) {
            abort(403);
        }
        $reservation->load(['objetLouable.photos', 'user', 'paiement']);
        return view('reservations.ticket', compact('reservation'));
    }
}
```

### 4. resources/views/reservations/index.blade.php (Bouton Ticket & Fix Paiement)
```php
<!-- Dans la boucle des actions -->
@if($reservation->statut == 'en_attente_paiement')
    <a href="{{ route('paiements.checkout', ['ids' => $reservation->id]) }}" class="...">Payer</a>
@endif

@if(in_array(strtolower($reservation->statut), ['payee', 'payée']))
    <a href="{{ route('reservations.ticket', $reservation) }}" target="_blank" class="...">Ticket</a>
@endif
```

### 5. resources/views/objets/create.blade.php (Fix Upload Images)
```javascript
fileChosen(event) {
    this.touched.photos = true;
    const newFiles = Array.from(event.target.files);
    if (newFiles.length === 0) return;

    this.accumulatedFiles = this.accumulatedFiles.concat(newFiles);
    const dataTransfer = new DataTransfer();
    this.accumulatedFiles.forEach(file => { dataTransfer.items.add(file); });
    event.target.files = dataTransfer.files;

    this.imageUrls.forEach(url => URL.revokeObjectURL(url));
    this.imageUrls = []; 
    this.accumulatedFiles.forEach(file => { this.imageUrls.push(URL.createObjectURL(file)); });
}
```

---
💡 **CONSEIL :** Si vous avez des erreurs "Class not found", lancez `composer dump-autoload` dans votre terminal.
