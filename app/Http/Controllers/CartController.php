<?php

namespace App\Http\Controllers;

use App\Models\ObjetLouable;
use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Display the cart contents.
     */
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('info', 'Veuillez vous connecter pour voir votre panier.');
        }

        $cartItems = CartItem::where('user_id', Auth::id())->with('objetLouable.photos')->get();
        $items = [];
        $total = 0;

        foreach ($cartItems as $cartItem) {
            if ($cartItem->objetLouable) {
                $items[] = [
                    'objet' => $cartItem->objetLouable,
                    'quantity' => $cartItem->quantity,
                    'subtotal' => $cartItem->objetLouable->prix * $cartItem->quantity,
                    'taille' => $cartItem->taille
                ];
                $total += $cartItem->objetLouable->prix * $cartItem->quantity;
            }
        }

        return view('cart.index', compact('items', 'total'));
    }

    /**
     * Add an item to the cart.
     */
    public function add(Request $request, $id)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('info', 'Veuillez vous connecter pour ajouter des articles au panier.');
        }

        $objet = ObjetLouable::findOrFail($id);
        
        $existingItem = CartItem::where('user_id', Auth::id())
                                ->where('objet_louable_id', $id)
                                ->first();

        if ($existingItem) {
            return redirect()->back()->with('info', 'Cet article est déjà dans votre panier.');
        }

        CartItem::create([
            'user_id' => Auth::id(),
            'objet_louable_id' => $id,
            'quantity' => 1,
            'taille' => $request->input('taille_selectionnee')
        ]);

        return redirect()->back()->with('success', 'Article ajouté au panier !');
    }

    /**
     * Remove an item from the cart.
     */
    public function remove($id)
    {
        if (Auth::check()) {
            CartItem::where('user_id', Auth::id())
                    ->where('objet_louable_id', $id)
                    ->delete();
        }

        return redirect()->back()->with('success', 'Article retiré du panier.');
    }

    /**
     * Clear the cart.
     */
    public function clear()
    {
        if (Auth::check()) {
            CartItem::where('user_id', Auth::id())->delete();
        }
        return redirect()->back()->with('success', 'Panier vidé.');
    }
}
