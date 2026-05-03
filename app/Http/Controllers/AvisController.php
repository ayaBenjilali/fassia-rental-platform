<?php

namespace App\Http\Controllers;

use App\Models\Avis;
use App\Models\ObjetLouable;
use Illuminate\Http\Request;

class AvisController extends Controller
{
    public function store(Request $request, ObjetLouable $objet)
    {
        $request->validate([
            'note' => 'required|integer|min:1|max:5',
            'commentaire' => 'required|string|max:500',
        ]);

        Avis::create([
            'user_id' => auth()->id(),
            'objet_louable_id' => $objet->id,
            'note' => $request->note,
            'commentaire' => $request->commentaire,
        ]);

        return back()->with('success', 'Votre avis a été publié avec succès !');
    }

    public function destroy(Avis $avi)
    {
        // Only admin can delete reviews
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Action non autorisée.');
        }

        $avi->delete();

        return back()->with('success', 'L\'avis a été supprimé avec succès.');
    }
}
