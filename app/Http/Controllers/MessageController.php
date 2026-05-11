<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userId = auth()->id();
        
        // Récupérer les derniers messages groupés par interlocuteur
        $conversations = Message::where(function($q) use ($userId) {
                $q->where('expediteur_id', $userId)->where('deleted_by_expediteur', false);
            })
            ->orWhere(function($q) use ($userId) {
                $q->where('destinataire_id', $userId)->where('deleted_by_destinataire', false);
            })
            ->latest()
            ->get()
            ->groupBy(function ($message) use ($userId) {
                return $message->expediteur_id === $userId ? $message->destinataire_id : $message->expediteur_id;
            });

        return view('messages.index', compact('conversations'));
    }

    public function conversation($interlocuteurId)
    {
        $userId = auth()->id();
        $interlocuteur = \App\Models\User::findOrFail($interlocuteurId);

        $messages = Message::where(function($q) use ($userId, $interlocuteurId) {
            $q->where('expediteur_id', $userId)
              ->where('destinataire_id', $interlocuteurId)
              ->where('deleted_by_expediteur', false);
        })->orWhere(function($q) use ($userId, $interlocuteurId) {
            $q->where('expediteur_id', $interlocuteurId)
              ->where('destinataire_id', $userId)
              ->where('deleted_by_destinataire', false);
        })->oldest()->get();

        // Marquer comme lus (Messages)
        Message::where('destinataire_id', $userId)
            ->where('expediteur_id', $interlocuteurId)
            ->whereNull('lu_a')
            ->update(['lu_a' => now()]);

        // Marquer comme lues (Notifications)
        auth()->user()->unreadNotifications
            ->where('data.type', 'message')
            ->where('data.sender_id', $interlocuteurId)
            ->markAsRead();

        return view('messages.show', compact('messages', 'interlocuteur'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'contenu' => 'required|string',
            'destinataire_id' => 'required|exists:users,id',
        ]);

        $validated['expediteur_id'] = auth()->id();

        $message = Message::create($validated);


        if ($request->ajax()) {
            return response()->json(['success' => true]);
        }

        return back()->with('success', 'Message envoyé.');
    }

    public function destroy(Message $message)
    {
        if ($message->expediteur_id !== auth()->id() && $message->destinataire_id !== auth()->id()) {
            abort(403);
        }
        
        if ($message->expediteur_id === auth()->id()) {
            $message->update(['deleted_by_expediteur' => true]);
        }
        if ($message->destinataire_id === auth()->id()) {
            $message->update(['deleted_by_destinataire' => true]);
        }
        
        return back()->with('success', 'Message supprimé.');
    }

    public function destroyDiscussion($interlocuteurId)
    {
        // Masquer les messages envoyés par l'utilisateur à cet interlocuteur
        \App\Models\Message::where('expediteur_id', auth()->id())
              ->where('destinataire_id', $interlocuteurId)
              ->update(['deleted_by_expediteur' => true]);

        // Masquer les messages reçus par l'utilisateur de cet interlocuteur
        \App\Models\Message::where('expediteur_id', $interlocuteurId)
              ->where('destinataire_id', auth()->id())
              ->update(['deleted_by_destinataire' => true]);

        return redirect()->route('messages.index')->with('success', 'Discussion supprimée.');
    }
}
