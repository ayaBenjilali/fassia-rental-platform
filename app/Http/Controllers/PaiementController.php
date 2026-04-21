<?php

namespace App\Http\Controllers;

use App\Models\Paiement;
use Illuminate\Http\Request;

class PaiementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $paiements = Paiement::with('reservation')->latest()->get();
        return view('paiements.index', compact('paiements'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'montant' => 'required|numeric|min:0',
            'reservation_id' => 'required|exists:reservations,id',
        ]);

        $validated['date_paie'] = now();
        $validated['statut'] = 'valide';

        Paiement::create($validated);

        return back()->with('success', 'Paiement effectué.');
    }

    public function show(Paiement $paiement)
    {
        return view('paiements.show', compact('paiement'));
    }

    public function edit(Paiement $paiement)
    {
        //
    }

    public function update(Request $request, Paiement $paiement)
    {
        $validated = $request->validate([
            'statut' => 'required|string|in:valide,annule',
        ]);
        $paiement->update($validated);
        return back();
    }

    public function destroy(Paiement $paiement)
    {
        // 
    }
}
