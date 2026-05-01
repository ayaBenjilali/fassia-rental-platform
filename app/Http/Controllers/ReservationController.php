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
        if ($request->has('objet')) {
            $objet = \App\Models\ObjetLouable::with('photos')->find($request->query('objet'));
        }
        return view('reservations.create', compact('objet'));
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
            'telephone' => 'required|string|max:20',
            'adresse' => 'required|string',
            'cin' => 'required|string|max:50',
        ]);

        // Check for availability
        $overlap = Reservation::where('objet_louable_id', $validated['objet_louable_id'])
            ->whereIn('statut', ['confirmee', 'payee'])
            ->where(function ($query) use ($validated) {
                $query->whereBetween('date_debut', [$validated['date_debut'], $validated['date_fin']])
                    ->orWhereBetween('date_fin', [$validated['date_debut'], $validated['date_fin']])
                    ->orWhere(function ($q) use ($validated) {
                        $q->where('date_debut', '<=', $validated['date_debut'])
                          ->where('date_fin', '>=', $validated['date_fin']);
                    });
            })
            ->exists();

        if ($overlap) {
            return back()->withInput()->withErrors(['dates' => 'Cet article est déjà réservé pour les dates sélectionnées.']);
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

        // Double check availability before confirming
        $overlap = Reservation::where('objet_louable_id', $reservation->objet_louable_id)
            ->where('statut', 'confirmee')
            ->where('id', '!=', $reservation->id)
            ->where(function ($query) use ($reservation) {
                $query->whereBetween('date_debut', [$reservation->date_debut, $reservation->date_fin])
                    ->orWhereBetween('date_fin', [$reservation->date_debut, $reservation->date_fin])
                    ->orWhere(function ($q) use ($reservation) {
                        $q->where('date_debut', '<=', $reservation->date_debut)
                          ->where('date_fin', '>=', $reservation->date_fin);
                    });
            })
            ->exists();

        if ($overlap) {
            return back()->with('error', 'Impossible d\'accepter cette réservation : l\'article est déjà loué aux dates demandées par une autre réservation confirmée.');
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

    public function destroy(Reservation $reservation)
    {
        $reservation->delete();
        return to_route('reservations.index')->with('success', 'Réservation annulée.');
    }
}
