<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Facture #{{ $facture->id_facture }} — StayFlow</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: DejaVu Sans, sans-serif; font-size: 13px; color: #333; }
        .header {
            background: #0A1628; color: white;
            padding: 24px; margin-bottom: 24px;
            display: flex; justify-content: space-between;
        }
        .header h1 { font-size: 24px; }
        .header h1 span { color: #29B6F6; }
        .header p { color: #8899aa; font-size: 12px; margin-top: 4px; }
        .facture-info {
            display: flex; justify-content: space-between;
            margin-bottom: 24px; padding: 0 24px;
        }
        .facture-num { font-size: 18px; font-weight: bold; color: #0A1628; }
        .facture-date { color: #888; font-size: 12px; margin-top: 4px; }
        .statut-badge {
            padding: 6px 14px; border-radius: 20px;
            font-size: 12px; font-weight: bold;
        }
        .statut-payee    { background: #e8f5e9; color: #43a047; }
        .statut-non_payee{ background: #ffebee; color: #e53935; }
        .statut-partielle{ background: #fff3e0; color: #fb8c00; }
        .section {
            margin: 0 24px 20px;
            border: 1px solid #e8e8e8; border-radius: 8px; overflow: hidden;
        }
        .section-title {
            background: #f8f9fa; padding: 10px 16px;
            font-weight: bold; font-size: 12px;
            color: #555; text-transform: uppercase; letter-spacing: 1px;
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
        .total-section {
            margin: 0 24px 24px;
            background: #0A1628; color: white;
            border-radius: 8px; padding: 20px;
            display: flex; justify-content: space-between; align-items: center;
        }
        .total-label { font-size: 14px; opacity: 0.8; }
        .total-amount { font-size: 28px; font-weight: bold; color: #29B6F6; }
        .footer {
            text-align: center; padding: 16px 24px;
            color: #888; font-size: 11px;
            border-top: 1px solid #e8e8e8; margin-top: 24px;
        }
        table { width: 100%; border-collapse: collapse; }
        th {
            background: #f8f9fa; padding: 8px 12px;
            text-align: left; font-size: 11px;
            color: #888; text-transform: uppercase;
        }
        td { padding: 8px 12px; font-size: 12px; border-bottom: 1px solid #f5f5f5; }
        tr:last-child td { border-bottom: none; }
    </style>
</head>
<body>

    <div class="header">
        <div>
            <h1>Stay<span>Flow</span></h1>
            <p>Hôtel Connecté · Campost</p>
            <p style="margin-top:8px">Yaoundé, Cameroun · contact@stayflow.cm</p>
        </div>
        <div style="text-align:right">
            <div style="font-size:12px;color:#8899aa">FACTURE</div>
            <div style="font-size:22px;font-weight:bold;color:#29B6F6">
                #{{ $facture->id_facture }}
            </div>
            <div style="font-size:12px;color:#8899aa;margin-top:4px">
                Date : {{ $facture->date_facture->format('d/m/Y') }}
            </div>
        </div>
    </div>

    <div class="facture-info">
        <div>
            <div class="facture-num">Facture N° {{ $facture->id_facture }}</div>
            <div class="facture-date">
                Émise le {{ $facture->date_facture->format('d/m/Y') }}
            </div>
        </div>
        <div>
            <span class="statut-badge statut-{{ $facture->statut }}">
                @if($facture->statut == 'payee') ✓ Payée
                @elseif($facture->statut == 'partielle') ⚠ Partielle
                @else ✗ Non payée
                @endif
            </span>
        </div>
    </div>

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

    <div class="total-section">
        <div>
            <div class="total-label">Montant total à payer</div>
            @if($facture->paiements->count() > 0)
            <div style="font-size:12px;opacity:0.6;margin-top:4px">Paiement reçu</div>
            @endif
        </div>
        <div class="total-amount">
            {{ number_format($facture->montant_total, 0, ',', ' ') }} FCFA
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
                        <th>Montant</th>
                        <th>Mode</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($facture->paiements as $p)
                    <tr>
                        <td>{{ $p->date_paiement->format('d/m/Y H:i') }}</td>
                        <td>{{ number_format($p->montant, 0, ',', ' ') }} FCFA</td>
                        <td>{{ ucfirst($p->mode_paiement) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif

    <div class="footer">
        <p>StayFlow — Hôtel Connecté · Campost · Yaoundé, Cameroun</p>
        <p style="margin-top:4px">
            Merci de votre confiance. Ce document est une facture officielle.
        </p>
    </div>

</body>
</html>