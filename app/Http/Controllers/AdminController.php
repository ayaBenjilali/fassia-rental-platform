<?php

namespace App\Http\Controllers;

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
            ->with(['user', 'photos'])
            ->latest()
            ->get();

        return view('admin.objets.index', compact('objets'));
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
}
