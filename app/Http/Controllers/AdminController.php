<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\ObjetLouable;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Accès non autorisé.');
        }

        $objets = ObjetLouable::where('statut', ObjetLouable::STATUT_EN_ATTENTE)
            ->whereHas('user', function ($query) {
                $query->where('role', '!=', 'admin');
            })
            ->with(['user', 'photos'])
            ->latest()
            ->paginate(10, ['*'], 'pending_page');

        $historique = ObjetLouable::whereIn('statut', [ObjetLouable::STATUT_APPROUVE, ObjetLouable::STATUT_REJETE])
            ->whereHas('user', function ($query) {
                $query->where('role', '!=', 'admin');
            })
            ->with(['user', 'photos'])
            ->latest()
            ->paginate(10, ['*'], 'history_page');

        $adminId = auth()->id();

        // Messages reçus par l'admin (réclamations), groupés par expéditeur
        $reclamations = Message::where('destinataire_id', $adminId)
            ->with('expediteur')
            ->latest()
            ->get()
            ->groupBy('expediteur_id')
            ->filter(fn($conv) => $conv->first()->expediteur?->role !== 'admin');

        return view('admin.objets.index', compact('objets', 'historique', 'reclamations'));
    }

    public function approuver(ObjetLouable $objet)
    {
        if (auth()->user()->role !== 'admin') { abort(403); }
        $objet->update(['statut' => ObjetLouable::STATUT_APPROUVE]);

        // Mark related admin notifications as read
        auth()->user()->unreadNotifications
            ->filter(fn($n) => isset($n->data['ad_id']) && $n->data['ad_id'] == $objet->id)
            ->each->markAsRead();

        // Notify User
        $objet->user->notify(new \App\Notifications\AdStatusChanged(
            "Félicitations ! Votre annonce '{$objet->titre}' a été approuvée.",
            $objet->id,
            'success'
        ));

        return back()->with('success', 'L\'annonce a été approuvée avec succès.');
    }

    public function rejeter(ObjetLouable $objet)
    {
        if (auth()->user()->role !== 'admin') { abort(403); }
        $objet->update(['statut' => ObjetLouable::STATUT_REJETE]);

        // Mark related admin notifications as read
        auth()->user()->unreadNotifications
            ->filter(fn($n) => isset($n->data['ad_id']) && $n->data['ad_id'] == $objet->id)
            ->each->markAsRead();

        // Notify User
        $objet->user->notify(new \App\Notifications\AdStatusChanged(
            "Votre annonce '{$objet->titre}' n'a pas été approuvée.",
            $objet->id,
            'error'
        ));

        return back()->with('success', 'L\'annonce a été rejetée.');
    }
    public function deleteUser(\App\Models\User $user)
    {
        if (auth()->user()->role !== 'admin') { abort(403); }
        
        $name = $user->nom ?? $user->name;
        $user->delete();

        return back()->with('success', "Le compte de {$name} a été supprimé.");
    }

    public function warnUser(\App\Models\User $user, Request $request)
    {
        if (auth()->user()->role !== 'admin') { abort(403); }
        
        $request->validate([
            'message' => 'required|string|max:500',
        ]);

        // Envoyer une notification d'avertissement
        $user->notify(new \App\Notifications\AdStatusChanged(
            "AVERTISSEMENT : " . $request->message,
            null,
            'error'
        ));

        // Optionnel : Envoyer aussi un message privé de la part de l'admin
        Message::create([
            'expediteur_id' => auth()->id(),
            'destinataire_id' => $user->id,
            'contenu' => "⚠️ AVERTISSEMENT ADMINISTRATIF : " . $request->message,
        ]);

        return back()->with('success', "Un avertissement a été envoyé à l'utilisateur.");
    }

    public function userPosts(\App\Models\User $user)
    {
        if (auth()->user()->role !== 'admin') { abort(403); }
        
        $objets = $user->objetsLouables()->latest()->paginate(15);
        
        return view('admin.users.posts', compact('user', 'objets'));
    }

    public function destroyAd(ObjetLouable $objet)
    {
        if (auth()->user()->role !== 'admin') { abort(403); }
        
        $titre = $objet->titre;
        $objet->delete();

        return back()->with('success', "L'annonce '{$titre}' a été supprimée définitivement.");
    }
}
