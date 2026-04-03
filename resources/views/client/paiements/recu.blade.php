<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StayFlow — Reçu de Paiement</title>
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
        .btn-primary   { background: #29B6F6; color: white; }
        .btn-secondary { background: #f5f5f5; color: #555; }
        .recu-card {
            background: white; border-radius: 16px;
            max-width: 500px; overflow: hidden;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        }
        .recu-header {
            background: linear-gradient(135deg, #1a1a2e, #0F4C75);
            padding: 32px; text-align: center; color: white;
        }
        .success-icon {
            width: 80px; height: 80px; border-radius: 50%;
            background: #43a047; margin: 0 auto 16px;
            display: flex; align-items: center; justify-content: center;
            font-size: 36px; color: white;
            animation: scaleIn 0.5s ease;
        }
        @keyframes scaleIn {
            from { transform: scale(0); opacity: 0; }
            to   { transform: scale(1); opacity: 1; }
        }
        .recu-header h2 { font-size: 22px; margin-bottom: 8px; }
        .recu-header .amount { font-size: 40px; font-weight: 700; color: #29B6F6; }
        .recu-header .date { font-size: 13px; opacity: 0.7; margin-top: 8px; }
        .recu-body { padding: 24px; }
        .recu-row {
            display: flex; justify-content: space-between;
            padding: 12px 0; border-bottom: 1px solid #f0f0f0;
            font-size: 14px;
        }
        .recu-row:last-child { border-bottom: none; }
        .recu-label { color: #888; }
        .recu-value { font-weight: 600; color: #1a1a2e; }
        .recu-footer {
            background: #f8f9fa; padding: 20px 24px;
            display: flex; gap: 12px;
        }
        .divider {
            border: none; border-top: 2px dashed #e8e8e8;
            margin: 8px 0;
        }
        .badge-payee {
            background: #e8f5e9; color: #43a047;
            padding: 4px 12px; border-radius: 20px;
            font-size: 12px; font-weight: 600;
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
        <h1><i class="fas fa-check-circle" style="color:#43a047"></i> Paiement Réussi !</h1>
        <div style="display:flex;align-items:center;gap:16px">
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

    <div class="recu-card">
        <div class="recu-header">
            <div class="success-icon">
                <i class="fas fa-check"></i>
            </div>
            <h2>Paiement confirmé !</h2>
            <div class="amount">
                {{ number_format($facture->montant_total, 0, ',', ' ') }} FCFA
            </div>
            <div class="date">
                {{ now()->format('d/m/Y à H:i') }}
            </div>
        </div>

        <div class="recu-body">
            <div class="recu-row">
                <span class="recu-label">Référence</span>
                <span class="recu-value">FAC-{{ str_pad($facture->id_facture, 6, '0', STR_PAD_LEFT) }}</span>
            </div>
            <div class="recu-row">
                <span class="recu-label">Client</span>
                <span class="recu-value">
                    {{ $facture->reservation->client->prenom }}
                    {{ $facture->reservation->client->nom }}
                </span>
            </div>
            <div class="recu-row">
                <span class="recu-label">Chambre</span>
                <span class="recu-value">
                    N° {{ $facture->reservation->chambre->numero }} —
                    {{ $facture->reservation->chambre->typeChambre->libelle_type }}
                </span>
            </div>
            <div class="recu-row">
                <span class="recu-label">Arrivée</span>
                <span class="recu-value">
                    {{ $facture->reservation->date_arrivee->format('d/m/Y') }}
                </span>
            </div>
            <div class="recu-row">
                <span class="recu-label">Départ</span>
                <span class="recu-value">
                    {{ $facture->reservation->date_depart->format('d/m/Y') }}
                </span>
            </div>
            <div class="recu-row">
                <span class="recu-label">Durée</span>
                <span class="recu-value">
                    {{ $facture->reservation->nombre_nuits }} nuit(s)
                </span>
            </div>
            <hr class="divider">
            <div class="recu-row">
                <span class="recu-label">Mode de paiement</span>
                <span class="recu-value">Mobile Money</span>
            </div>
            <div class="recu-row">
                <span class="recu-label">Statut</span>
                <span class="recu-value">
                    <span class="badge-payee">✓ Payée</span>
                </span>
            </div>
            <div class="recu-row">
                <span class="recu-label">Montant payé</span>
                <span class="recu-value" style="color:#29B6F6;font-size:18px">
                    {{ number_format($facture->montant_total, 0, ',', ' ') }} FCFA
                </span>
            </div>
        </div>

        <div class="recu-footer">
            <a href="{{ route('client.dashboard') }}" class="btn btn-primary" style="flex:1;justify-content:center">
                <i class="fas fa-home"></i> Accueil
            </a>
            <a href="{{ route('client.reservations.index') }}" class="btn btn-secondary" style="flex:1;justify-content:center">
                <i class="fas fa-calendar"></i> Mes réservations
            </a>
        </div>
    </div>
</div>
</body>
</html>