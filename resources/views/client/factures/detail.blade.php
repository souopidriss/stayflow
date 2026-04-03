<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StayFlow — Détail Facture</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', sans-serif; background: #f0f2f5; }
        .sidebar {
            position: fixed; top: 0; left: 0;
            width: 250px; height: 100vh;
            background: #1a1a2e; padding: 24px 0; z-index: 100;
        }
        .sidebar-logo {
            padding: 0 24px 24px;
            border-bottom: 1px solid #2a2a4e; margin-bottom: 16px;
        }
        .sidebar-logo h2 { color: white; font-size: 22px; }
        .sidebar-logo h2 span { color: #29B6F6; }
        .sidebar-logo p { color: #8888aa; font-size: 11px; letter-spacing: 2px; }
        .nav-item {
            display: flex; align-items: center; gap: 12px;
            padding: 12px 24px; color: #8888aa;
            text-decoration: none; font-size: 14px; transition: all 0.2s;
        }
        .nav-item:hover, .nav-item.active {
            background: #2a2a4e; color: #29B6F6;
            border-left: 3px solid #29B6F6;
        }
        .nav-item i { width: 20px; }
        .nav-section {
            padding: 16px 24px 8px; color: #8888aa;
            font-size: 11px; letter-spacing: 2px;
        }
        .main { margin-left: 250px; padding: 24px; }
        .topbar {
            display: flex; justify-content: space-between; align-items: center;
            background: white; padding: 16px 24px;
            border-radius: 12px; margin-bottom: 24px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        }
        .topbar h1 { font-size: 20px; color: #1a1a2e; }
        .btn {
            padding: 10px 20px; border-radius: 8px;
            font-size: 14px; font-weight: 600;
            cursor: pointer; text-decoration: none;
            display: inline-flex; align-items: center; gap: 8px;
            border: none;
        }
        .btn-secondary { background: #f5f5f5; color: #555; }
        .btn-success   { background: #e8f5e9; color: #43a047; }
        .btn-primary   { background: #29B6F6; color: white; }
        .facture-header {
            background: linear-gradient(135deg, #1a1a2e, #0F4C75);
            border-radius: 16px; padding: 32px;
            color: white; margin-bottom: 24px;
            display: flex; justify-content: space-between; align-items: center;
        }
        .facture-header h2 { font-size: 28px; font-weight: 700; }
        .facture-header h2 span { color: #29B6F6; }
        .facture-header .montant { font-size: 42px; font-weight: 700; color: #29B6F6; }
        .facture-header .statut { font-size: 13px; margin-top: 8px; }
        .grid-2 {
            display: grid; grid-template-columns: 1fr 1fr;
            gap: 24px; margin-bottom: 24px;
        }
        .card {
            background: white; border-radius: 12px;
            padding: 24px; box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        }
        .card-title {
            font-size: 16px; font-weight: 600; color: #1a1a2e;
            margin-bottom: 16px; padding-bottom: 12px;
            border-bottom: 1px solid #f0f0f0;
            display: flex; align-items: center; gap: 8px;
        }
        .card-title i { color: #29B6F6; }
        .info-row {
            display: flex; justify-content: space-between;
            padding: 10px 0; border-bottom: 1px solid #f8f8f8;
            font-size: 14px;
        }
        .info-row:last-child { border-bottom: none; }
        .info-label { color: #888; }
        .info-value { font-weight: 600; color: #1a1a2e; }
        .badge-payee {
            background: #e8f5e9; color: #43a047;
            padding: 6px 14px; border-radius: 20px;
            font-size: 13px; font-weight: 600;
        }
        .badge-non-payee {
            background: #ffebee; color: #e53935;
            padding: 6px 14px; border-radius: 20px;
            font-size: 13px; font-weight: 600;
        }
        .historique-card {
            background: white; border-radius: 12px;
            padding: 24px; box-shadow: 0 2px 8px rgba(0,0,0,0.06);
            margin-bottom: 24px;
        }
        .paiement-item {
            display: flex; justify-content: space-between;
            align-items: center; padding: 16px;
            background: #f8f9fa; border-radius: 10px;
            margin-bottom: 12px;
        }
        .paiement-item:last-child { margin-bottom: 0; }
        .paiement-left { display: flex; align-items: center; gap: 12px; }
        .paiement-icon {
            width: 44px; height: 44px; border-radius: 50%;
            background: linear-gradient(135deg, #1a1a2e, #29B6F6);
            display: flex; align-items: center; justify-content: center;
            color: white; font-size: 18px;
        }
        .paiement-mode { font-weight: 600; color: #1a1a2e; font-size: 14px; }
        .paiement-date { color: #888; font-size: 12px; margin-top: 2px; }
        .paiement-montant { font-size: 18px; font-weight: 700; color: #43a047; }
        .empty-historique {
            text-align: center; padding: 32px; color: #888;
        }
        .empty-historique i { font-size: 40px; display: block; margin-bottom: 12px; }
        .actions-footer {
            display: flex; gap: 12px; margin-top: 24px;
        }
        .btn-logout {
            padding: 8px 16px; background: #fff5f5;
            color: #e53e3e; border: 1px solid #fed7d7;
            border-radius: 8px; font-size: 13px; cursor: pointer;
        }
        .user-info { display: flex; align-items: center; gap: 10px; }
        .user-avatar {
            width: 38px; height: 38px;
            background: linear-gradient(135deg, #1a1a2e, #29B6F6);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            color: white; font-weight: 600; font-size: 14px;
        }
        .user-name { font-size: 14px; font-weight: 600; color: #333; }
        .user-role { font-size: 11px; color: #888; }
    </style>
</head>
<body>
<div class="sidebar">
    <div class="sidebar-logo">
        <h2>Stay<span>Flow</span></h2>
        <p>ESPACE CLIENT</p>
    </div>
    <span class="nav-section">Mon espace</span>
    <a href="{{ route('client.dashboard') }}" class="nav-item">
        <i class="fas fa-home"></i> Accueil
    </a>
    <a href="{{ route('client.reservations.index') }}" class="nav-item">
        <i class="fas fa-calendar-check"></i> Mes réservations
    </a>
    <a href="{{ route('client.factures.index') }}" class="nav-item active">
        <i class="fas fa-file-invoice"></i> Mes factures
    </a>
    <span class="nav-section">Hôtel</span>
    <a href="{{ route('client.chambres.index') }}" class="nav-item">
        <i class="fas fa-bed"></i> Nos chambres
    </a>
</div>

<div class="main">
    <div class="topbar">
        <h1><i class="fas fa-file-invoice" style="color:#29B6F6"></i>
            Facture #{{ $facture->id_facture }}
        </h1>
        <div style="display:flex;align-items:center;gap:12px">
            @if($facture->statut == 'payee')
            <a href="{{ route('client.factures.pdf', $facture->id_facture) }}"
               class="btn btn-success">
                <i class="fas fa-file-pdf"></i> Télécharger PDF
            </a>
            @else
            <a href="{{ route('client.paiements.index', $facture->id_facture) }}"
               class="btn btn-primary">
                <i class="fas fa-mobile-alt"></i> Payer maintenant
            </a>
            @endif
            <a href="{{ route('client.factures.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Retour
            </a>
            <div class="user-info">
                <div class="user-avatar">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
                <div>
                    <div class="user-name">{{ Auth::user()->name }}</div>
                    <div class="user-role">Client</div>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn-logout">
                    <i class="fas fa-sign-out-alt"></i> Déconnexion
                </button>
            </form>
        </div>
    </div>

    <div class="facture-header">
        <div>
            <h2>Stay<span>Flow</span></h2>
            <div style="opacity:0.7;font-size:13px;margin-top:4px">
                Hôtel Connecté · Campost · Yaoundé
            </div>
            <div style="margin-top:16px">
                <div style="font-size:13px;opacity:0.7">Référence</div>
                <div style="font-size:18px;font-weight:700">
                    FAC-{{ str_pad($facture->id_facture, 6, '0', STR_PAD_LEFT) }}
                </div>
            </div>
        </div>
        <div style="text-align:right">
            <div class="montant">
                {{ number_format($facture->montant_total, 0, ',', ' ') }} FCFA
            </div>
            <div class="statut">
                @if($facture->statut == 'payee')
                    <span class="badge-payee">✓ Payée</span>
                @else
                    <span class="badge-non-payee">✗ Non payée</span>
                @endif
            </div>
            <div style="font-size:13px;opacity:0.7;margin-top:8px">
                Émise le {{ $facture->date_facture->format('d/m/Y') }}
            </div>
        </div>
    </div>

    <div class="grid-2">
        <div class="card">
            <div class="card-title">
                <i class="fas fa-user"></i> Informations client
            </div>
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

        <div class="card">
            <div class="card-title">
                <i class="fas fa-bed"></i> Détail du séjour
            </div>
            <div class="info-row">
                <span class="info-label">Chambre</span>
                <span class="info-value">
                    N° {{ $facture->reservation->chambre->numero }}
                    — {{ $facture->reservation->chambre->typeChambre->libelle_type }}
                </span>
            </div>
            <div class="info-row">
                <span class="info-label">Arrivée</span>
                <span class="info-value">
                    {{ $facture->reservation->date_arrivee->format('d/m/Y') }}
                </span>
            </div>
            <div class="info-row">
                <span class="info-label">Départ</span>
                <span class="info-value">
                    {{ $facture->reservation->date_depart->format('d/m/Y') }}
                </span>
            </div>
            <div class="info-row">
                <span class="info-label">Durée</span>
                <span class="info-value">
                    {{ $facture->reservation->nombre_nuits }} nuit(s)
                </span>
            </div>
            <div class="info-row">
                <span class="info-label">Prix/nuit</span>
                <span class="info-value">
                    {{ number_format($facture->reservation->chambre->prix_nuit, 0, ',', ' ') }} FCFA
                </span>
            </div>
        </div>
    </div>

    <div class="historique-card">
        <div class="card-title">
            <i class="fas fa-history"></i> Historique des paiements
        </div>

        @forelse($facture->paiements as $paiement)
        <div class="paiement-item">
            <div class="paiement-left">
                <div class="paiement-icon">
                    <i class="fas fa-mobile-alt"></i>
                </div>
                <div>
                    <div class="paiement-mode">
                        {{ ucfirst(str_replace('_', ' ', $paiement->mode_paiement)) }}
                    </div>
                    <div class="paiement-date">
                        {{ $paiement->date_paiement->format('d/m/Y à H:i') }}
                    </div>
                </div>
            </div>
            <div class="paiement-montant">
                +{{ number_format($paiement->montant, 0, ',', ' ') }} FCFA
            </div>
        </div>
        @empty
        <div class="empty-historique">
            <i class="fas fa-clock"></i>
            Aucun paiement effectué pour cette facture
            @if($facture->statut != 'payee')
            <br><br>
            <a href="{{ route('client.paiements.index', $facture->id_facture) }}"
               style="color:#29B6F6;font-weight:600;text-decoration:none">
                Payer maintenant →
            </a>
            @endif
        </div>
        @endforelse
    </div>
</div>
</body>
</html>