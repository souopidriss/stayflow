<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Facture StayFlow #{{ $facture->id_facture }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: DejaVu Sans, sans-serif; font-size: 13px; color: #333; }
        .header {
            background: #1a1a2e; color: white;
            padding: 24px; margin-bottom: 24px;
        }
        .header-content {
            display: flex; justify-content: space-between; align-items: center;
        }
        .logo h1 { font-size: 28px; font-weight: 700; }
        .logo h1 span { color: #29B6F6; }
        .logo p { color: #8888aa; font-size: 12px; margin-top: 4px; }
        .facture-num { text-align: right; }
        .facture-num .label { font-size: 12px; color: #8888aa; }
        .facture-num .num { font-size: 24px; font-weight: 700; color: #29B6F6; }
        .facture-num .date { font-size: 12px; color: #8888aa; margin-top: 4px; }
        .statut-band {
            padding: 10px 24px;
            text-align: center; font-weight: 700; font-size: 13px;
        }
        .statut-payee    { background: #e8f5e9; color: #43a047; }
        .statut-non_payee{ background: #ffebee; color: #e53935; }
        .content { padding: 0 24px; }
        .section {
            margin-bottom: 20px;
            border: 1px solid #e8e8e8; border-radius: 8px; overflow: hidden;
        }
        .section-title {
            background: #f8f9fa; padding: 10px 16px;
            font-weight: 700; font-size: 12px;
            color: #555; text-transform: uppercase; letter-spacing: 1px;
            border-bottom: 1px solid #e8e8e8;
        }
        .section-body { padding: 16px; }
        .info-row {
            display: flex; justify-content: space-between;
            padding: 6px 0; border-bottom: 1px solid #f5f5f5;
            font-size: 13px;
        }
        .info-row:last-child { border-bottom: none; }
        .info-label { color: #888; }
        .info-value { font-weight: 600; }
        .total-box {
            background: #1a1a2e; color: white;
            padding: 20px 24px; margin: 0 24px 24px;
            border-radius: 8px;
            display: flex; justify-content: space-between; align-items: center;
        }
        .total-label { font-size: 14px; opacity: 0.8; }
        .total-amount { font-size: 32px; font-weight: 700; color: #29B6F6; }
        table { width: 100%; border-collapse: collapse; }
        th {
            background: #f8f9fa; padding: 8px 12px;
            text-align: left; font-size: 11px;
            color: #888; text-transform: uppercase;
            border-bottom: 1px solid #e8e8e8;
        }
        td { padding: 8px 12px; font-size: 12px; border-bottom: 1px solid #f5f5f5; }
        tr:last-child td { border-bottom: none; }
        .footer {
            text-align: center; padding: 16px 24px;
            color: #888; font-size: 11px;
            border-top: 1px solid #e8e8e8; margin-top: 24px;
        }
        .badge-payee {
            background: #e8f5e9; color: #43a047;
            padding: 4px 12px; border-radius: 20px;
            font-size: 12px; font-weight: 600;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="header-content">
            <div class="logo">
                <h1>Stay<span>Flow</span></h1>
                <p>Hôtel Connecté · Campost · Yaoundé, Cameroun</p>
                <p style="margin-top:4px">contact@stayflow.cm · +237 677720883/
                    +237692273676
                </p>
            </div>
            <div class="facture-num">
                <div class="label">FACTURE</div>
                <div class="num">#{{ str_pad($facture->id_facture, 6, '0', STR_PAD_LEFT) }}</div>
                <div class="date">
                    Émise le {{ $facture->date_facture->format('d/m/Y') }}
                </div>
            </div>
        </div>
    </div>

    <div class="statut-band statut-{{ $facture->statut }}">
        @if($facture->statut == 'payee')
            ✓ FACTURE PAYÉE
        @else
            ✗ FACTURE NON PAYÉE
        @endif
    </div>

    <div class="content">
        <div class="section">
            <div class="section-title">Informations client</div>
            <div class="section-body">
                <div class="info-row">
                    <span class="info-label">Nom complet</span>
                    <span class="info-value">
                        {{ $facture->reservation->client->prenom }}
                        {{ $facture->reservation->client->nom }}
                    </span>
                </div>
                <div class="info-row">
                    <span class="info-label">Téléphone</span>
                    <span class="info-value">
                        {{ $facture->reservation->client->telephone ?? '—' }}
                    </span>
                </div>
                <div class="info-row">
                    <span class="info-label">Email</span>
                    <span class="info-value">
                        {{ $facture->reservation->client->email ?? '—' }}
                    </span>
                </div>
            </div>
        </div>

        <div class="section">
            <div class="section-title">Détail du séjour</div>
            <div class="section-body">
                <table>
                    <thead>
                        <tr>
                            <th>Description</th>
                            <th>Arrivée</th>
                            <th>Départ</th>
                            <th>Nuits</th>
                            <th>Prix/nuit</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                Chambre {{ $facture->reservation->chambre->numero }}
                                — {{ $facture->reservation->chambre->typeChambre->libelle_type }}
                            </td>
                            <td>{{ $facture->reservation->date_arrivee->format('d/m/Y') }}</td>
                            <td>{{ $facture->reservation->date_depart->format('d/m/Y') }}</td>
                            <td>{{ $facture->reservation->nombre_nuits }}</td>
                            <td>
                                {{ number_format($facture->reservation->chambre->prix_nuit, 0, ',', ' ') }}
                                FCFA
                            </td>
                            <td>
                                <strong>
                                    {{ number_format($facture->montant_total, 0, ',', ' ') }} FCFA
                                </strong>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        @if($facture->paiements->count() > 0)
        <div class="section">
            <div class="section-title">Historique des paiements</div>
            <div class="section-body">
                <table>
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Mode</th>
                            <th>Montant</th>
                            <th>Statut</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($facture->paiements as $p)
                        <tr>
                            <td>{{ $p->date_paiement->format('d/m/Y à H:i') }}</td>
                            <td>{{ ucfirst(str_replace('_', ' ', $p->mode_paiement)) }}</td>
                            <td>{{ number_format($p->montant, 0, ',', ' ') }} FCFA</td>
                            <td><span class="badge-payee">✓ Validé</span></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif
    </div>

    <div class="total-box">
        <div>
            <div class="total-label">Montant total</div>
            @if($facture->statut == 'payee')
            <div style="font-size:12px;opacity:0.6;margin-top:4px">✓ Paiement reçu</div>
            @endif
        </div>
        <div class="total-amount">
            {{ number_format($facture->montant_total, 0, ',', ' ') }} FCFA
        </div>
    </div>

    <div class="footer">
        <p><strong>StayFlow</strong> — Hôtel Connecté · Campost · Yaoundé, Cameroun</p>
        <p style="margin-top:4px">
            Merci de votre confiance !
            Ce document est une facture officielle de l'Hôtel Campost StayFlow.
        </p>
        <p style="margin-top:4px">
            Référence : FAC-{{ str_pad($facture->id_facture, 6, '0', STR_PAD_LEFT) }}
            — Généré le {{ now()->format('d/m/Y à H:i') }}
        </p>
    </div>
</body>
</html>