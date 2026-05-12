<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reservations = Reservation::with('objetLouable')->where('user_id', auth()->id() ?? 1)->latest()->paginate(10);
        return view('reservations.index', compact('reservations'));
    }

    public function create(\Illuminate\Http\Request $request)
    {
        $objets = collect();
        $reservedDates = [];

        if ($request->has('objet')) {
            $objet = \App\Models\ObjetLouable::with('photos')->find($request->query('objet'));
            if ($objet) $objets->push($objet);
        } elseif ($request->has('items')) {
            $ids = explode(',', $request->query('items'));
            $objets = \App\Models\ObjetLouable::with('photos')->whereIn('id', $ids)->get();
        }

        if ($objets->isNotEmpty()) {
            // Get all confirmed or paid reservations for these objects
            $reservations = Reservation::whereIn('objet_louable_id', $objets->pluck('id'))
                ->whereIn('statut', ['confirmee', 'payee'])
                ->where('date_fin', '>=', now()->subDays(3)->toDateString())
                ->get();

            foreach ($reservations as $res) {
                // Logistique: 1 jour avant (livraison), 2 jours après (retour + maintenance)
                $start = (new \DateTime($res->date_debut))->modify('-1 day');
                $end = (new \DateTime($res->date_fin))->modify('+2 days');

                $period = new \DatePeriod(
                    $start,
                    new \DateInterval('P1D'),
                    $end->modify('+1 day')
                );
                foreach ($period as $date) {
                    $reservedDates[] = $date->format('Y-m-d');
                }
            }
            // Retirer les doublons de dates
            $reservedDates = array_values(array_unique($reservedDates));
        }
        
        $objet = $objets->first(); // Compatibilité avec l'ancienne vue pour le moment
        return view('reservations.create', compact('objets', 'objet', 'reservedDates'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'date_debut' => 'required|date|after_or_equal:today',
            'date_fin' => 'required|date|after_or_equal:date_debut',
            'objet_louable_ids' => 'required|string',
            'montant_total' => 'required|numeric|min:0',
            'nom' => 'required|string|max:255',
            'ville' => 'required|string|max:255',
            'telephone' => 'required|string|size:10|regex:/^[0-9]{10}$/',
            'adresse' => 'required|string',
            'cin' => 'required|string|max:50',
        ]);

        $ids = explode(',', $validated['objet_louable_ids']);
        $objets = \App\Models\ObjetLouable::whereIn('id', $ids)->get();
        $reservationsIds = [];

        foreach ($objets as $objet) {
            // Check for availability with buffer (1 day before, 2 days after)
            $existingReservations = Reservation::where('objet_louable_id', $objet->id)
                ->whereIn('statut', ['confirmee', 'payee'])
                ->get();

            foreach ($existingReservations as $res) {
                $blocked_start = (new \DateTime($res->date_debut))->modify('-1 day')->format('Y-m-d');
                $blocked_end = (new \DateTime($res->date_fin))->modify('+2 days')->format('Y-m-d');

                if ($validated['date_debut'] <= $blocked_end && $blocked_start <= $validated['date_fin']) {
                    return back()->withInput()->withErrors(['dates' => "L'article '{$objet->titre}' est indisponible aux dates sélectionnées."]);
                }
            }

            // Vérifier si une réservation en attente de paiement existe déjà pour cet objet et ces dates
            $existingUnpaid = Reservation::where('user_id', auth()->id())
                ->where('objet_louable_id', $objet->id)
                ->where('date_debut', $validated['date_debut'])
                ->where('date_fin', $validated['date_fin'])
                ->where('statut', 'en_attente_paiement')
                ->first();

            if ($existingUnpaid) {
                // Mettre à jour les infos personnelles au cas où elles ont changé
                $existingUnpaid->update([
                    'nom' => $validated['nom'],
                    'ville' => $validated['ville'],
                    'telephone' => $validated['telephone'],
                    'adresse' => $validated['adresse'],
                    'cin' => $validated['cin'],
                ]);
                $reservationsIds[] = $existingUnpaid->id;
                continue;
            }

            // Calcul du montant pour CET objet spécifique
            $start = new \DateTime($validated['date_debut']);
            $end = new \DateTime($validated['date_fin']);
            $diffDays = max(1, $end->diff($start)->days);
            if ($start > $end) $diffDays = 0;
            
            $montantObjet = $diffDays * $objet->prix;

            $reservation = Reservation::create([
                'user_id' => auth()->id(),
                'objet_louable_id' => $objet->id,
                'date_debut' => $validated['date_debut'],
                'date_fin' => $validated['date_fin'],
                'statut' => 'en_attente_paiement',
                'montant_total' => $montantObjet,
                'nom' => $validated['nom'],
                'ville' => $validated['ville'],
                'telephone' => $validated['telephone'],
                'adresse' => $validated['adresse'],
                'cin' => $validated['cin'],
            ]);

            $reservationsIds[] = $reservation->id;
        }

        return redirect()->route('paiements.checkout', ['ids' => implode(',', $reservationsIds)]);
    }

    public function show(Reservation $reservation)
    {
        return view('reservations.show', compact('reservation'));
    }

    public function edit(Reservation $reservation)
    {
        return view('reservations.edit', compact('reservation'));
    }

    public function update(Request $request, Reservation $reservation)
    {
        $validated = $request->validate([
            'statut' => 'required|string|in:en_attente,confirmee,annulee',
        ]);

        $reservation->update($validated);

        return to_route('reservations.show', $reservation->id)->with('success', 'Statut mis à jour.');
    }

    public function accept(Reservation $reservation)
    {
        // Vérifier que l'utilisateur connecté est le propriétaire de l'objet
        if ($reservation->objetLouable->user_id !== auth()->id()) {
            abort(403);
        }

        // Double check availability before confirming with buffer
        $reservations = Reservation::where('objet_louable_id', $reservation->objet_louable_id)
            ->where('statut', 'confirmee')
            ->where('id', '!=', $reservation->id)
            ->get();

        foreach ($reservations as $res) {
            $blocked_start = (new \DateTime($res->date_debut))->modify('-1 day')->format('Y-m-d');
            $blocked_end = (new \DateTime($res->date_fin))->modify('+2 days')->format('Y-m-d');

            if ($reservation->date_debut <= $blocked_end && $blocked_start <= $reservation->date_fin) {
                return back()->with('error', 'Impossible d\'accepter cette réservation : l\'article est indisponible à cause d\'une autre réservation et des délais logistiques.');
            }
        }

        $reservation->update(['statut' => 'confirmee']);

        // Notify Renter
        $reservation->user->notify(new \App\Notifications\AdStatusChanged(
            "Bonne nouvelle ! Votre réservation pour '{$reservation->objetLouable->titre}' a été acceptée.",
            $reservation->objet_louable_id,
            'success'
        ));

        return back()->with('success', 'La réservation a été acceptée.');
    }

    public function reject(Reservation $reservation)
    {
        // Vérifier que l'utilisateur connecté est le propriétaire de l'objet
        if ($reservation->objetLouable->user_id !== auth()->id()) {
            abort(403);
        }

        $reservation->update(['statut' => 'annulee']);

        // Notify Renter
        $reservation->user->notify(new \App\Notifications\AdStatusChanged(
            "Votre demande de réservation pour '{$reservation->objetLouable->titre}' a été refusée.",
            $reservation->objet_louable_id,
            'error'
        ));

        return back()->with('success', 'La réservation a été refusée.');
    }

    public function ticket(Reservation $reservation)
    {
        // Le propriétaire de l'objet ET le locataire peuvent voir le ticket
        if ($reservation->objetLouable->user_id !== auth()->id() && $reservation->user_id !== auth()->id()) {
            abort(403, 'Vous n\'êtes pas autorisé à voir ce ticket.');
        }

        $reservation->load(['objetLouable.photos', 'user', 'paiement']);
        return view('reservations.ticket', compact('reservation'));
    }

    public function destroy(Reservation $reservation)
    {
        $reservation->delete();
        return to_route('reservations.index')->with('success', 'Réservation annulée.');
    }
}
