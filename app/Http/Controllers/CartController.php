<?php

namespace App\Http\Controllers;

use App\Models\ObjetLouable;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Display the cart contents.
     */
    public function index()
    {
        $cart = session()->get('cart', []);
        $items = [];
        $total = 0;

        if (!empty($cart)) {
            $objets = ObjetLouable::with('photos')->whereIn('id', array_keys($cart))->get();
            foreach ($objets as $objet) {
                $items[] = [
                    'objet' => $objet,
                    'quantity' => $cart[$objet->id]['quantity'],
                    'subtotal' => $objet->prix * $cart[$objet->id]['quantity'],
                    'taille' => $cart[$objet->id]['taille'] ?? null
                ];
                $total += $objet->prix * $cart[$objet->id]['quantity'];
            }
        }

        return view('cart.index', compact('items', 'total'));
    }

    /**
     * Add an item to the cart.
     */
    public function add(Request $request, $id)
    {
        $objet = ObjetLouable::findOrFail($id);
        $cart = session()->get('cart', []);

        // Vérifier si l'article est déjà dans le panier
        if (isset($cart[$id])) {
            return redirect()->back()->with('info', 'Cet article est déjà dans votre panier.');
        }

        $taille = $request->input('taille_selectionnee');

        $cart[$id] = [
            "name" => $objet->titre,
            "quantity" => 1,
            "price" => $objet->prix,
            "photo" => $objet->photos->first() ? $objet->photos->first()->url_photo : null,
            "taille" => $taille
        ];

        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Article ajouté au panier !');
    }

    /**
     * Remove an item from the cart.
     */
    public function remove($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return redirect()->back()->with('success', 'Article retiré du panier.');
    }

    /**
     * Clear the cart.
     */
    public function clear()
    {
        session()->forget('cart');
        return redirect()->back()->with('success', 'Panier vidé.');
    }
}
