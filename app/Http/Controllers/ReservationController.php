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
        $objet = null;
        $reservedDates = [];

        if ($request->has('objet')) {
            $objet = \App\Models\ObjetLouable::with('photos')->find($request->query('objet'));
            
            if ($objet) {
                // Get all confirmed or paid reservations for this object
                $reservations = Reservation::where('objet_louable_id', $objet->id)
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
            }
        }
        
        return view('reservations.create', compact('objet', 'reservedDates'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'date_debut' => 'required|date|after_or_equal:today',
            'date_fin' => 'required|date|after_or_equal:date_debut',
            'objet_louable_id' => 'required|exists:objet_louables,id',
            'montant_total' => 'required|numeric|min:0',
            'nom' => 'required|string|max:255',
            'ville' => 'required|string|max:255',
            'telephone' => 'required|string|size:10|regex:/^[0-9]{10}$/',
            'adresse' => 'required|string',
            'cin' => 'required|string|max:50',
        ]);

        // Logic for logistics buffer: new_start must be > old_end + 2 days
        // and new_end must be < old_start - 1 day
        // Check for availability with buffer (1 day before, 2 days after)
        $reservations = Reservation::where('objet_louable_id', $validated['objet_louable_id'])
            ->whereIn('statut', ['confirmee', 'payee'])
            ->get();

        foreach ($reservations as $res) {
            $blocked_start = (new \DateTime($res->date_debut))->modify('-1 day')->format('Y-m-d');
            $blocked_end = (new \DateTime($res->date_fin))->modify('+2 days')->format('Y-m-d');

            if ($validated['date_debut'] <= $blocked_end && $blocked_start <= $validated['date_fin']) {
                return back()->withInput()->withErrors(['dates' => 'Cet article est indisponible aux dates sélectionnées (incluant les délais de livraison et de maintenance).']);
            }
        }

        $validated['user_id'] = auth()->id();
        $validated['statut'] = 'en_attente_paiement';

        $reservation = Reservation::create($validated);

        return redirect()->route('paiements.checkout', $reservation);
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
