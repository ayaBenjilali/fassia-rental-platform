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
            'date_fin' => 'required|date|after:date_debut',
            'objet_louable_id' => 'required|exists:objet_louables,id',
            'montant_total' => 'required|numeric|min:0',
        ]);

        $validated['user_id'] = auth()->id();
        $validated['statut'] = 'en_attente';

        Reservation::create($validated);



        return to_route('reservations.index')->with('success', 'Réservation effectuée avec succès.');
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

        $reservation->update(['statut' => 'confirmee']);

        return back()->with('success', 'La réservation a été acceptée.');
    }

    public function reject(Reservation $reservation)
    {
        // Vérifier que l'utilisateur connecté est le propriétaire de l'objet
        if ($reservation->objetLouable->user_id !== auth()->id()) {
            abort(403);
        }

        $reservation->update(['statut' => 'annulee']);

        return back()->with('success', 'La réservation a été refusée.');
    }

    public function destroy(Reservation $reservation)
    {
        $reservation->delete();
        return to_route('reservations.index')->with('success', 'Réservation annulée.');
    }
}
