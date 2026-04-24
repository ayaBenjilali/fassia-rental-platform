<?php

namespace App\Http\Controllers;

use App\Models\ObjetLouable;
use Illuminate\Http\Request;

class ObjetLouableController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Strict visibility: only approved ads are shown to everyone
        $query = ObjetLouable::approuve()->with('user', 'photos')->latest();

        // Filtre par catégorie (tableau)
        if ($request->has('category') && is_array($request->category)) {
            $query->whereIn('type', $request->category);
        }
        
        // ... (rest of the filters)
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('prix_max')) {
            $query->where('prix', '<=', $request->prix_max);
        }

        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('titre', 'like', '%' . $searchTerm . '%')
                  ->orWhere('description', 'like', '%' . $searchTerm . '%')
                  ->orWhere('couleur', 'like', '%' . $searchTerm . '%')
                  ->orWhere('type', 'like', '%' . $searchTerm . '%')
                  ->orWhere('tissu', 'like', '%' . $searchTerm . '%');
            });
        }

        $objets = $query->paginate(12)->withQueryString();

        if ($request->ajax()) {
            return view('objets._items', compact('objets'))->render();
        }

        return view('objets.index', compact('objets'));
    }

    public function create()
    {
        return view('objets.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'titre' => 'required|string|max:255|unique:objet_louables,titre',
            'description' => 'required|string',
            'prix' => 'required|numeric|min:0|max:5000',
            'localisation' => 'nullable|string',
            'type' => 'required|string|in:caftan,bijoux,sac,talon',
            'taille' => 'nullable|string',
            'couleur' => 'nullable|string',
            'tissu' => 'nullable|string',
            'marque' => 'nullable|string',
            'matiere' => 'nullable|string',
            'statut' => 'nullable|string|in:actif,inactif',
            'photos.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'photos' => 'required|array',
        ], [
            'titre.unique' => 'Ce nom de produit existe déjà. Veuillez choisir un titre unique.',
        ]);

        $validated['user_id'] = auth()->id();
        
        // Admin posts are approved automatically, users need moderation
        $validated['statut'] = auth()->user()->role === 'admin' 
            ? ObjetLouable::STATUT_APPROUVE 
            : ObjetLouable::STATUT_EN_ATTENTE;

        $objet = ObjetLouable::create($validated);

        // Notify Admins if a normal user posts
        if ($validated['statut'] === ObjetLouable::STATUT_EN_ATTENTE) {
            $admins = \App\Models\User::where('role', 'admin')->get();
            foreach ($admins as $admin) {
                $admin->notify(new \App\Notifications\AdStatusChanged(
                    "Une nouvelle annonce '{$objet->titre}' attend votre approbation.",
                    $objet->id,
                    'pending'
                ));
            }
        }

        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photoFile) {
                // Store in specific directory inside public disk
                $path = $photoFile->store('photos', 'public');
                
                \App\Models\Photo::create([
                    'url_photo' => $path,
                    'objet_louable_id' => $objet->id,
                ]);
            }
        }

        return to_route('dashboard')->with('success', 'Annonce créée ! Elle sera visible dès qu\'un administrateur l\'aura approuvée.');
    }

    public function show(ObjetLouable $objet)
    {
        $objet->load('photos', 'user');
        return view('objets.show', ['objetLouable' => $objet]);
    }

    public function edit(ObjetLouable $objet)
    {
        return view('objets.edit', ['objetLouable' => $objet]);
    }

    public function update(Request $request, ObjetLouable $objet)
    {
        $validated = $request->validate([
            'titre' => 'required|string|max:255|unique:objet_louables,titre,' . $objet->id,
            'description' => 'required|string',
            'prix' => 'required|numeric|min:0|max:5000',
            'localisation' => 'nullable|string',
            'type' => 'required|string|in:caftan,bijoux,sac,talon',
            'taille' => 'nullable|string',
            'couleur' => 'nullable|string',
            'tissu' => 'nullable|string',
            'marque' => 'nullable|string',
            'matiere' => 'nullable|string',
            'statut' => 'nullable|string|in:actif,inactif',
            'photos.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'photos' => 'nullable|array',
        ], [
            'titre.unique' => 'Ce nom de produit existe déjà. Veuillez choisir un titre unique.',
        ]);

        // Admin edits remain approved, user edits need re-approval
        $validated['statut'] = auth()->user()->role === 'admin' 
            ? ObjetLouable::STATUT_APPROUVE 
            : ObjetLouable::STATUT_EN_ATTENTE;

        $objet->update($validated);

        // Upload new photos if any
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photoFile) {
                $path = $photoFile->store('photos', 'public');
                
                \App\Models\Photo::create([
                    'url_photo' => $path,
                    'objet_louable_id' => $objet->id,
                ]);
            }
        }

        return to_route('dashboard')->with('success', 'Annonce mise à jour. Elle doit être de nouveau approuvée par un administrateur.');
    }

    public function destroy(ObjetLouable $objet)
    {
        $objet->delete();
        return back()->with('success', 'Objet supprimé avec succès.');
    }

    public function checkTitle(Request $request)
    {
        $exists = ObjetLouable::where('titre', $request->titre)->exists();
        return response()->json(['exists' => $exists]);
    }
}
