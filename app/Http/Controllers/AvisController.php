<?php

namespace App\Http\Controllers;

use App\Models\Avis;
use Illuminate\Http\Request;

class AvisController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $avis = Avis::with('user', 'objetLouable')->latest()->get();
        return view('avis.index', compact('avis'));
    }

    public function create()
    {

    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'note' => 'required|numeric|min:1|max:5',
            'commentaire' => 'nullable|string',
            'objet_louable_id' => 'required|exists:objet_louables,id',
        ]);

        $validated['user_id'] = auth()->id();

        Avis::create($validated);

        return back()->with('success', 'Votre avis a été ajouté avec succès.');
    }

    public function show(Avis $avi)
    {
    }

    public function edit(Avis $avi)
    {
    }

    public function update(Request $request, Avis $avi)
    {
    }

    public function destroy(Avis $avi)
    {
        $avi->delete();
        return back()->with('success', 'Avis supprimé.');
    }
}
