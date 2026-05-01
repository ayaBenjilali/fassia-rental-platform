<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket d'expédition - {{ $reservation->objetLouable->titre }}</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap');

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Inter', sans-serif;
            background: #f3f4f6;
            padding: 40px;
            color: #1a1a1a;
        }

        .ticket {
            max-width: 700px;
            margin: 0 auto;
            background: white;
            border: 2px solid #1a1a1a;
            border-radius: 16px;
            overflow: hidden;
        }

        /* Header */
        .ticket-header {
            background: #1a1a1a;
            color: white;
            padding: 24px 32px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .ticket-header h1 {
            font-size: 20px;
            font-weight: 800;
            letter-spacing: 2px;
            text-transform: uppercase;
        }

        .ticket-header .logo {
            font-size: 24px;
            font-weight: 800;
            color: #D4AF37;
        }

        .ticket-ref {
            background: #f9fafb;
            padding: 16px 32px;
            border-bottom: 1px dashed #d1d5db;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 13px;
        }

        .ticket-ref strong {
            font-size: 15px;
            color: #1a1a1a;
        }

        /* Sections */
        .ticket-body {
            padding: 24px 32px;
        }

        .section {
            margin-bottom: 24px;
        }

        .section-title {
            font-size: 10px;
            font-weight: 800;
            letter-spacing: 3px;
            text-transform: uppercase;
            color: #9ca3af;
            margin-bottom: 12px;
            padding-bottom: 6px;
            border-bottom: 1px solid #f3f4f6;
        }

        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px 24px;
        }

        .info-item {
            display: flex;
            flex-direction: column;
        }

        .info-label {
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #9ca3af;
            margin-bottom: 2px;
        }

        .info-value {
            font-size: 14px;
            font-weight: 600;
            color: #1a1a1a;
        }

        .info-value.highlight {
            font-size: 18px;
            font-weight: 800;
            color: #059669;
        }

        .full-width {
            grid-column: 1 / -1;
        }

        /* Dashed separator */
        .separator {
            border: none;
            border-top: 2px dashed #d1d5db;
            margin: 20px 0;
        }

        /* Footer */
        .ticket-footer {
            background: #f9fafb;
            padding: 16px 32px;
            text-align: center;
            font-size: 11px;
            color: #6b7280;
            border-top: 1px dashed #d1d5db;
        }

        .ticket-footer strong {
            color: #1a1a1a;
        }

        /* Security notice */
        .security-notice {
            background: #fef3c7;
            border: 1px solid #f59e0b;
            border-radius: 8px;
            padding: 12px 16px;
            font-size: 12px;
            font-weight: 600;
            color: #92400e;
            text-align: center;
            margin-top: 16px;
        }

        /* Print button */
        .no-print {
            text-align: center;
            margin: 24px auto;
            max-width: 700px;
            display: flex;
            gap: 12px;
            justify-content: center;
        }

        .btn {
            padding: 12px 32px;
            border: none;
            border-radius: 12px;
            font-weight: 700;
            font-size: 14px;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.2s;
        }

        .btn-print {
            background: #1a1a1a;
            color: white;
        }

        .btn-print:hover {
            background: #374151;
        }

        .btn-back {
            background: white;
            color: #6b7280;
            border: 1px solid #d1d5db;
        }

        .btn-back:hover {
            background: #f9fafb;
        }

        /* Print styles */
        @media print {
            body {
                background: white;
                padding: 0;
            }

            .no-print {
                display: none !important;
            }

            .ticket {
                border: 2px solid #000;
                border-radius: 0;
                max-width: 100%;
            }
        }
    </style>
</head>
<body>

    <div class="ticket">
        <div class="ticket-header">
            <h1>Ticket d'expédition</h1>
            <span class="logo">L'Fassia</span>
        </div>

        <div class="ticket-ref">
            <div>
                <span style="color: #6b7280;">Réf. Réservation :</span>
                <strong>#{{ str_pad($reservation->id, 6, '0', STR_PAD_LEFT) }}</strong>
            </div>
            <div>
                <span style="color: #6b7280;">Date :</span>
                <strong>{{ \Carbon\Carbon::parse($reservation->created_at)->format('d/m/Y à H:i') }}</strong>
            </div>
        </div>

        <div class="ticket-body">
            <!-- Article -->
            <div class="section">
                <div class="section-title">Article loué</div>
                <div class="info-grid">
                    <div class="info-item full-width">
                        <span class="info-label">Nom de l'article</span>
                        <span class="info-value" style="font-size: 18px; font-weight: 800;">{{ $reservation->objetLouable->titre }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Catégorie</span>
                        <span class="info-value">{{ ucfirst($reservation->objetLouable->type) }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Localisation</span>
                        <span class="info-value">{{ $reservation->objetLouable->localisation }}</span>
                    </div>
                </div>
            </div>

            <hr class="separator">

            <!-- Période & Montant -->
            <div class="section">
                <div class="section-title">Détails de la location</div>
                <div class="info-grid">
                    <div class="info-item">
                        <span class="info-label">Date de retrait</span>
                        <span class="info-value">{{ \Carbon\Carbon::parse($reservation->date_debut)->format('d/m/Y') }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Date de retour</span>
                        <span class="info-value">{{ \Carbon\Carbon::parse($reservation->date_fin)->format('d/m/Y') }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Montant total</span>
                        <span class="info-value highlight">{{ number_format($reservation->montant_total, 2) }} DH</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Statut paiement</span>
                        <span class="info-value" style="color: {{ $reservation->paiement && $reservation->paiement->statut === 'valide' ? '#059669' : '#dc2626' }};">
                            {{ $reservation->paiement && $reservation->paiement->statut === 'valide' ? '✅ PAYÉ' : '❌ Non payé' }}
                        </span>
                    </div>
                </div>
            </div>

            <hr class="separator">

            <!-- Destinataire -->
            <div class="section">
                <div class="section-title">Informations du destinataire (locataire)</div>
                <div class="info-grid">
                    <div class="info-item">
                        <span class="info-label">Nom complet</span>
                        <span class="info-value">{{ $reservation->nom }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">CIN</span>
                        <span class="info-value" style="font-weight: 800; letter-spacing: 1px;">{{ $reservation->cin }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Téléphone</span>
                        <span class="info-value">{{ $reservation->telephone }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Ville</span>
                        <span class="info-value">{{ $reservation->ville }}</span>
                    </div>
                    <div class="info-item full-width">
                        <span class="info-label">Adresse complète</span>
                        <span class="info-value">{{ $reservation->adresse }}</span>
                    </div>
                    <div class="info-item full-width">
                        <span class="info-label">Pays</span>
                        <span class="info-value">Maroc</span>
                    </div>
                </div>
            </div>

            <div class="security-notice">
                🔒 VÉRIFICATION D'IDENTITÉ OBLIGATOIRE — Le livreur doit vérifier la CIN du destinataire lors de la remise ET de la récupération de l'article.
            </div>
        </div>

        <div class="ticket-footer">
            <strong>L'Fassia</strong> — Plateforme de location d'articles traditionnels marocains<br>
            Ticket généré le {{ now()->format('d/m/Y à H:i') }}
        </div>
    </div>

    <div class="no-print">
        <button class="btn btn-print" onclick="window.print()">
            🖨️ Imprimer le ticket
        </button>
        <a href="{{ route('dashboard') }}#demandes-recues" class="btn btn-back">
            ← Retour au tableau de bord
        </a>
    </div>

</body>
</html>
