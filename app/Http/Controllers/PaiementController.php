<?php

namespace App\Http\Controllers;

use App\Models\Paiement;
use App\Models\Reservation;
use Illuminate\Http\Request;

class PaiementController extends Controller
{
    public function checkout(Reservation $reservation)
    {
        // On s'assure que la réservation est confirmée et appartient à l'utilisateur
        if ($reservation->statut !== 'confirmee' || $reservation->user_id !== auth()->id()) {
            return back()->with('error', 'Cette réservation ne peut pas être payée pour le moment.');
        }

        // Vérifier s'il y a déjà un paiement
        if ($reservation->paiement) {
            return back()->with('error', 'Cette réservation a déjà été payée.');
        }

        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

        // Création de la session Stripe
        $session = \Stripe\Checkout\Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'mad', // Dirham Marocain
                    'product_data' => [
                        'name' => 'Location : ' . $reservation->objetLouable->titre,
                        'description' => 'Du ' . \Carbon\Carbon::parse($reservation->date_debut)->format('d/m/Y') . ' au ' . \Carbon\Carbon::parse($reservation->date_fin)->format('d/m/Y'),
                    ],
                    'unit_amount' => $reservation->montant_total * 100, // Stripe demande des centimes
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => route('paiements.success') . '?session_id={CHECKOUT_SESSION_ID}&reservation_id=' . $reservation->id,
            'cancel_url' => route('paiements.cancel'),
        ]);

        return redirect()->away($session->url);
    }

    public function success(Request $request)
    {
        $sessionId = $request->get('session_id');
        $reservationId = $request->get('reservation_id');

        if (!$sessionId || !$reservationId) {
            return redirect()->route('dashboard')->with('error', 'Paiement invalide.');
        }

        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

        try {
            $session = \Stripe\Checkout\Session::retrieve($sessionId);

            if ($session->payment_status == 'paid') {
                $reservation = \App\Models\Reservation::findOrFail($reservationId);
                
                // 1. Enregistrer le paiement en base
                Paiement::create([
                    'montant' => $session->amount_total / 100,
                    'date_paie' => now(),
                    'statut' => 'valide',
                    'reservation_id' => $reservation->id,
                ]);

                // 2. Mettre à jour le statut de la réservation
                $reservation->update(['statut' => 'payee']);

                // 3. Optionnel : Envoyer une notification au propriétaire ici
                
                return redirect()->route('dashboard')->with('success', 'Paiement réussi ! Votre réservation est validée.');
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
