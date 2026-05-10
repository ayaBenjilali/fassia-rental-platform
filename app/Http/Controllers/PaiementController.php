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
