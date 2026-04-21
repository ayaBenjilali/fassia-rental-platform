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
        $messages = Message::with('expediteur', 'destinataire')
            ->where('destinataire_id', $userId)
            ->orWhere('expediteur_id', $userId)
            ->latest()
            ->get();

        return view('messages.index', compact('messages'));
    }

    public function create()
    {
        return view('messages.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'contenu' => 'required|string',
            'destinataire_id' => 'required|exists:users,id',
        ]);

        $validated['expediteur_id'] = auth()->id();

        Message::create($validated);

        return back()->with('success', 'Message envoyé.');
    }

    public function show(Message $message)
    {

        if (!$message->lu_a && $message->destinataire_id == auth()->id()) {
            $message->update(['lu_a' => now()]);
        }
        return view('messages.show', compact('message'));
    }

    public function edit(Message $message)
    {

    }

    public function update(Request $request, Message $message)
    {
    }

    public function destroy(Message $message)
    {
        $message->delete();
        return to_route('messages.index')->with('success', 'Message supprimé.');
    }
}
