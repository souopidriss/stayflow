<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StayFlow — Détail Réservation</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', sans-serif; background: #f0f2f5; }
        .sidebar {
            position: fixed; top: 0; left: 0;
            width: 250px; height: 100vh;
            background: #0A1628; padding: 24px 0; z-index: 100;
        }
        .sidebar-logo {
            padding: 0 24px 24px;
            border-bottom: 1px solid #1a2f4e; margin-bottom: 16px;
        }
        .sidebar-logo h2 { color: white; font-size: 22px; }
        .sidebar-logo h2 span { color: #29B6F6; }
        .sidebar-logo p { color: #546E7A; font-size: 11px; letter-spacing: 2px; }
        .nav-item {
            display: flex; align-items: center; gap: 12px;
            padding: 12px 24px; color: #8899aa;
            text-decoration: none; font-size: 14px; transition: all 0.2s;
        }
        .nav-item:hover, .nav-item.active {
            background: #1a2f4e; color: #29B6F6;
            border-left: 3px solid #29B6F6;
        }
        .nav-item i { width: 20px; }
        .nav-section {
            padding: 16px 24px 8px; color: #546E7A;
            font-size: 11px; letter-spacing: 2px;
        }
        .main { margin-left: 250px; padding: 24px; }
        .topbar {
            display: flex; justify-content: space-between; align-items: center;
            background: white; padding: 16px 24px;
            border-radius: 12px; margin-bottom: 24px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        }
        .topbar h1 { font-size: 20px; color: #0A1628; }
        .btn {
            padding: 10px 20px; border-radius: 8px;
            font-size: 14px; font-weight: 600;
            cursor: pointer; text-decoration: none;
            display: inline-flex; align-items: center; gap: 8px;
            border: none;
        }
        .btn-primary   { background: #1E88E5; color: white; }
        .btn-secondary { background: #f5f5f5; color: #555; }
        .btn-warning   { background: #fff3e0; color: #fb8c00; }
        .btn-success   { background: #e8f5e9; color: #43a047; }
        .btn-danger    { background: #ffebee; color: #e53935; }
        .grid-2 {
            display: grid; grid-template-columns: 1fr 1fr;
            gap: 24px; margin-bottom: 24px;
        }
        .card {
            background: white; border-radius: 12px;
            padding: 24px; box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        }
        .card-title {
            font-size: 16px; font-weight: 600; color: #0A1628;
            margin-bottom: 16px; padding-bottom: 12px;
            border-bottom: 1px solid #f0f0f0;
        }
        .info-row {
            display: flex; justify-content: space-between;
            padding: 10px 0; border-bottom: 1px solid #f8f8f8;
            font-size: 14px;
        }
        .info-row:last-child { border-bottom: none; }
        .info-label { color: #888; }
        .info-value { font-weight: 600; color: #333; }
        .badge {
            padding: 4px 10px; border-radius: 20px;
            font-size: 11px; font-weight: 600;
        }
        .badge-success   { background: #e8f5e9; color: #43a047; }
        .badge-warning   { background: #fff3e0; color: #fb8c00; }
        .badge-danger    { background: #ffebee; color: #e53935; }
        .badge-info      { background: #e3f2fd; color: #1E88E5; }
        .badge-secondary { background: #f5f5f5; color: #888; }
        .statut-form { display: flex; gap: 8px; align-items: center; }
        .statut-form select {
            padding: 8px 12px; border: 2px solid #e8e8e8;
            border-radius: 8px; font-size: 13px; outline: none;
        }
        .total-banner {
            background: linear-gradient(135deg, #1E88E5, #29B6F6);
            border-radius: 12px; padding: 20px 24px;
            color: white; margin-bottom: 24px;
            display: flex; justify-content: space-between; align-items: center;
        }
        .total-banner h3 { font-size: 14px; opacity: 0.8; }
        .total-banner .amount { font-size: 32px; font-weight: 700; }
        .btn-logout {
            padding: 8px 16px; background: #fff5f5;
            color: #e53e3e; border: 1px solid #fed7d7;
            border-radius: 8px; font-size: 13px; cursor: pointer;
        }
        .user-info { display: flex; align-items: center; gap: 10px; }
        .user-avatar {
            width: 38px; height: 38px;
            background: linear-gradient(135deg, #1E88E5, #29B6F6);
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
        <p>SUPER ADMIN</p>
    </div>
    <span class="nav-section">Principal</span>
    <a href="{{ route('admin.dashboard') }}" class="nav-item">
        <i class="fas fa-tachometer-alt"></i> Dashboard
    </a>
    <span class="nav-section">Gestion</span>
    <a href="{{ route('admin.chambres.index') }}" class="nav-item">
        <i class="fas fa-bed"></i> Chambres
    </a>
    <a href="{{ route('admin.reservations.index') }}" class="nav-item active">
        <i class="fas fa-calendar-check"></i> Réservations
    </a>
    <a href="{{ route('admin.clients.index') }}" class="nav-item">
        <i class="fas fa-users"></i> Clients
    </a>
    <a href="{{ route('admin.employes.index') }}" class="nav-item">
        <i class="fas fa-user-tie"></i> Employés
    </a>
    <a href="{{ route('admin.factures.index') }}" class="nav-item">
        <i class="fas fa-file-invoice"></i> Factures
    </a>
    <a href="{{ route('admin.services.index') }}" class="nav-item">
        <i class="fas fa-concierge-bell"></i> Services
    </a>
    <span class="nav-section">Rapports</span>
    <a href="{{ route('admin.evaluations.index') }}" class="nav-item">
        <i class="fas fa-star"></i> Évaluations
    </a>
</div>

<div class="main">
    <div class="topbar">
        <h1><i class="fas fa-calendar-check" style="color:#1E88E5"></i>
            Réservation #{{ $reservation->id_reservation }}
        </h1>
        <div style="display:flex;align-items:center;gap:16px">
            <a href="{{ route('admin.reservations.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Retour
            </a>
            <div class="user-info">
                <div class="user-avatar">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
                <div>
                    <div class="user-name">{{ Auth::user()->name }}</div>
                    <div class="user-role">Super Admin</div>
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

    <div class="total-banner">
        <div>
            <h3>Montant total</h3>
            <div class="amount">
                {{ number_format($reservation->facture->montant_total ?? 0, 0, ',', ' ') }} FCFA
            </div>
            <div style="font-size:13px;opacity:0.8">
                {{ $reservation->nombre_nuits }} nuit(s) ×
                {{ number_format($reservation->chambre->prix_nuit, 0, ',', ' ') }} FCFA
            </div>
        </div>
        <div>
            @php
                $badges = [
                    'en_attente' => 'badge-warning',
                    'confirmee'  => 'badge-info',
                    'checkin'    => 'badge-success',
                    'checkout'   => 'badge-secondary',
                    'annulee'    => 'badge-danger',
                ];
            @endphp
            <span class="badge {{ $badges[$reservation->statut] ?? 'badge-secondary' }}"
                  style="font-size:14px;padding:8px 16px">
                {{ ucfirst($reservation->statut) }}
            </span>
        </div>
    </div>

    <div class="grid-2">
        <div class="card">
            <div class="card-title">Informations client</div>
            <div class="info-row">
                <span class="info-label">Nom complet</span>
                <span class="info-value">
                    {{ $reservation->client->prenom }} {{ $reservation->client->nom }}
                </span>
            </div>
            <div class="info-row">
                <span class="info-label">Téléphone</span>
                <span class="info-value">{{ $reservation->client->telephone ?? '—' }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Email</span>
                <span class="info-value">{{ $reservation->client->email ?? '—' }}</span>
            </div>
        </div>

        <div class="card">
            <div class="card-title">Informations chambre</div>
            <div class="info-row">
                <span class="info-label">Numéro</span>
                <span class="info-value">{{ $reservation->chambre->numero }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Type</span>
                <span class="info-value">{{ $reservation->chambre->typeChambre->libelle_type }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Prix/nuit</span>
                <span class="info-value">
                    {{ number_format($reservation->chambre->prix_nuit, 0, ',', ' ') }} FCFA
                </span>
            </div>
        </div>
    </div>

    <div class="grid-2">
        <div class="card">
            <div class="card-title">Dates du séjour</div>
            <div class="info-row">
                <span class="info-label">Date réservation</span>
                <span class="info-value">{{ $reservation->date_reservation->format('d/m/Y') }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Arrivée</span>
                <span class="info-value">{{ $reservation->date_arrivee->format('d/m/Y') }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Départ</span>
                <span class="info-value">{{ $reservation->date_depart->format('d/m/Y') }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Durée</span>
                <span class="info-value">{{ $reservation->nombre_nuits }} nuit(s)</span>
            </div>
        </div>

        <div class="card">
            <div class="card-title">Changer le statut</div>
            <form method="POST"
                  action="{{ route('admin.reservations.statut', $reservation->id_reservation) }}">
                @csrf @method('PATCH')
                <div class="statut-form">
                    <select name="statut">
                        <option value="en_attente"
                            {{ $reservation->statut == 'en_attente' ? 'selected' : '' }}>
                            En attente
                        </option>
                        <option value="confirmee"
                            {{ $reservation->statut == 'confirmee' ? 'selected' : '' }}>
                            Confirmée
                        </option>
                        <option value="checkin"
                            {{ $reservation->statut == 'checkin' ? 'selected' : '' }}>
                            Check-in
                        </option>
                        <option value="checkout"
                            {{ $reservation->statut == 'checkout' ? 'selected' : '' }}>
                            Check-out
                        </option>
                        <option value="annulee"
                            {{ $reservation->statut == 'annulee' ? 'selected' : '' }}>
                            Annulée
                        </option>
                    </select>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Mettre à jour
                    </button>
                </div>
            </form>

            @if($reservation->facture)
            <div style="margin-top:16px">
                <div class="info-row">
                    <span class="info-label">Facture</span>
                    <span class="info-value">
                        <span class="badge {{ $reservation->facture->statut == 'payee' ? 'badge-success' : 'badge-warning' }}">
                            {{ ucfirst($reservation->facture->statut) }}
                        </span>
                    </span>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
</body>
</html>