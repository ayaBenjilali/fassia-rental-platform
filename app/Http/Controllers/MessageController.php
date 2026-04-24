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
        $conversations = Message::where('expediteur_id', $userId)
            ->orWhere('destinataire_id', $userId)
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
            $q->where('expediteur_id', $userId)->where('destinataire_id', $interlocuteurId);
        })->orWhere(function($q) use ($userId, $interlocuteurId) {
            $q->where('expediteur_id', $interlocuteurId)->where('destinataire_id', $userId);
        })->oldest()->get();

        // Marquer comme lus
        Message::where('destinataire_id', $userId)
            ->where('expediteur_id', $interlocuteurId)
            ->whereNull('lu_a')
            ->update(['lu_a' => now()]);

        return view('messages.show', compact('messages', 'interlocuteur'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'contenu' => 'required|string',
            'destinataire_id' => 'required|exists:users,id',
        ]);

        $validated['expediteur_id'] = auth()->id();

        Message::create($validated);

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
        
        $message->delete();
        return back()->with('success', 'Message supprimé.');
    }

    public function destroyDiscussion($interlocuteurId)
    {
        \App\Models\Message::where(function($query) use ($interlocuteurId) {
            $query->where('expediteur_id', auth()->id())
                  ->where('destinataire_id', $interlocuteurId);
        })->orWhere(function($query) use ($interlocuteurId) {
            $query->where('expediteur_id', $interlocuteurId)
                  ->where('destinataire_id', auth()->id());
        })->delete();

        return redirect()->route('messages.index')->with('success', 'Discussion supprimée.');
    }
}
