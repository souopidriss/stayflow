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
            background: #0F4C75; padding: 24px 0; z-index: 100;
        }
        .sidebar-logo {
            padding: 0 24px 24px;
            border-bottom: 1px solid #1B6CA8; margin-bottom: 16px;
        }
        .sidebar-logo h2 { color: white; font-size: 22px; }
        .sidebar-logo h2 span { color: #29B6F6; }
        .sidebar-logo p { color: #7fb3d3; font-size: 11px; letter-spacing: 2px; }
        .nav-item {
            display: flex; align-items: center; gap: 12px;
            padding: 12px 24px; color: #a8d4f0;
            text-decoration: none; font-size: 14px; transition: all 0.2s;
        }
        .nav-item:hover, .nav-item.active {
            background: #1B6CA8; color: white;
            border-left: 3px solid #29B6F6;
        }
        .nav-item i { width: 20px; }
        .nav-section {
            padding: 16px 24px 8px; color: #7fb3d3;
            font-size: 11px; letter-spacing: 2px;
        }
        .main { margin-left: 250px; padding: 24px; }
        .topbar {
            display: flex; justify-content: space-between; align-items: center;
            background: white; padding: 16px 24px;
            border-radius: 12px; margin-bottom: 24px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        }
        .topbar h1 { font-size: 20px; color: #0F4C75; }
        .btn {
            padding: 10px 20px; border-radius: 8px;
            font-size: 14px; font-weight: 600;
            cursor: pointer; text-decoration: none;
            display: inline-flex; align-items: center; gap: 8px;
            border: none;
        }
        .btn-secondary { background: #f5f5f5; color: #555; }
        .btn-success   { background: #e8f5e9; color: #43a047; }
        .btn-warning   { background: #fff3e0; color: #fb8c00; }
        .grid-2 {
            display: grid; grid-template-columns: 1fr 1fr;
            gap: 24px; margin-bottom: 24px;
        }
        .card {
            background: white; border-radius: 12px;
            padding: 24px; box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        }
        .card-title {
            font-size: 16px; font-weight: 600; color: #0F4C75;
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
        .badge-success { background: #e8f5e9; color: #43a047; }
        .badge-warning { background: #fff3e0; color: #fb8c00; }
        .badge-danger  { background: #ffebee; color: #e53935; }
        .facture-header {
            background: #0F4C75; color: white;
            border-radius: 12px; padding: 24px;
            margin-bottom: 24px;
            display: flex; justify-content: space-between; align-items: center;
        }
        .facture-header h2 { font-size: 24px; }
        .facture-header h2 span { color: #29B6F6; }
        .facture-header .montant { font-size: 36px; font-weight: 700; color: #29B6F6; }
        table { width: 100%; border-collapse: collapse; }
        th {
            background: #f8f9fa; padding: 10px 14px;
            text-align: left; font-size: 12px;
            color: #888; text-transform: uppercase;
        }
        td { padding: 10px 14px; font-size: 13px; border-bottom: 1px solid #f0f0f0; }
        tr:last-child td { border-bottom: none; }
        .btn-logout {
            padding: 8px 16px; background: #fff5f5;
            color: #e53e3e; border: 1px solid #fed7d7;
            border-radius: 8px; font-size: 13px; cursor: pointer;
        }
        .user-info { display: flex; align-items: center; gap: 10px; }
        .user-avatar {
            width: 38px; height: 38px;
            background: linear-gradient(135deg, #0F4C75, #29B6F6);
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
        <p>RÉCEPTION</p>
    </div>
    <span class="nav-section">Principal</span>
    <a href="{{ route('reception.dashboard') }}" class="nav-item">
        <i class="fas fa-tachometer-alt"></i> Dashboard
    </a>
    <span class="nav-section">Gestion</span>
    <a href="{{ route('reception.chambres.index') }}" class="nav-item">
        <i class="fas fa-bed"></i> Chambres
    </a>
    <a href="{{ route('reception.reservations.index') }}" class="nav-item">
        <i class="fas fa-calendar-check"></i> Réservations
    </a>
    <a href="{{ route('reception.clients.index') }}" class="nav-item">
        <i class="fas fa-users"></i> Clients
    </a>
    <a href="{{ route('reception.factures.index') }}" class="nav-item active">
        <i class="fas fa-file-invoice"></i> Factures
    </a>
</div>

<div class="main">
    <div class="topbar">
        <h1><i class="fas fa-file-invoice" style="color:#1E88E5"></i>
            Facture #{{ $facture->id_facture }}
        </h1>
        <div style="display:flex;align-items:center;gap:16px">
            <a href="{{ route('reception.factures.pdf', $facture->id_facture) }}"
               class="btn btn-success">
                <i class="fas fa-file-pdf"></i> PDF
            </a>
            @if($facture->statut != 'payee')
            <a href="{{ route('reception.factures.edit', $facture->id_facture) }}"
               class="btn btn-warning">
                <i class="fas fa-credit-card"></i> Encaisser
            </a>
            @endif
            <a href="{{ route('reception.factures.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Retour
            </a>
            <div class="user-info">
                <div class="user-avatar">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
                <div>
                    <div class="user-name">{{ Auth::user()->name }}</div>
                    <div class="user-role">Réceptionniste</div>
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
            <div style="color:#8899aa;font-size:13px">Hôtel Connecté · Campost</div>
            <div style="margin-top:12px;font-size:13px;color:#8899aa">
                Facture #{{ $facture->id_facture }} —
                {{ $facture->date_facture->format('d/m/Y') }}
            </div>
        </div>
        <div style="text-align:right">
            <div class="montant">
                {{ number_format($facture->montant_total, 0, ',', ' ') }} FCFA
            </div>
            <div style="font-size:13px;color:#8899aa;margin-top:4px">
                @if($facture->statut == 'payee') ✅ Payée
                @elseif($facture->statut == 'partielle') ⚠️ Partielle
                @else ❌ Non payée
                @endif
            </div>
        </div>
    </div>

    <div class="grid-2">
        <div class="card">
            <div class="card-title">Informations client</div>
            <div class="info-row">
                <span class="info-label">Nom</span>
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
        </div>

        <div class="card">
            <div class="card-title">Détail du séjour</div>
            <div class="info-row">
                <span class="info-label">Chambre</span>
                <span class="info-value">
                    N° {{ $facture->reservation->chambre->numero }}
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
        </div>
    </div>

    @if($facture->paiements->count() > 0)
    <div class="card">
        <div class="card-title">Historique des paiements</div>
        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Montant</th>
                    <th>Mode</th>
                    <th>Statut</th>
                </tr>
            </thead>
            <tbody>
                @foreach($facture->paiements as $paiement)
                <tr>
                    <td>{{ $paiement->date_paiement->format('d/m/Y H:i') }}</td>
                    <td>
                        <strong>
                            {{ number_format($paiement->montant, 0, ',', ' ') }} FCFA
                        </strong>
                    </td>
                    <td>{{ ucfirst($paiement->mode_paiement) }}</td>
                    <td><span class="badge badge-success">Validé</span></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
</div>
</body>
</html>