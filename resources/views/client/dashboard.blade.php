<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StayFlow — Espace Client</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', sans-serif; background: #f0f2f5; }
        .sidebar {
            position: fixed; top: 0; left: 0;
            width: 250px; height: 100vh;
            background: #1a1a2e;
            padding: 24px 0; z-index: 100;
        }
        .sidebar-logo {
            padding: 0 24px 24px;
            border-bottom: 1px solid #2a2a4e;
            margin-bottom: 16px;
        }
        .sidebar-logo h2 { color: white; font-size: 22px; }
        .sidebar-logo h2 span { color: #29B6F6; }
        .sidebar-logo p { color: #8888aa; font-size: 11px; letter-spacing: 2px; }
        .nav-item {
            display: flex; align-items: center; gap: 12px;
            padding: 12px 24px; color: #8888aa;
            text-decoration: none; font-size: 14px;
            transition: all 0.2s;
        }
        .nav-item:hover, .nav-item.active {
            background: #2a2a4e; color: #29B6F6;
            border-left: 3px solid #29B6F6;
        }
        .nav-item i { width: 20px; }
        .nav-section {
            padding: 16px 24px 8px;
            color: #8888aa; font-size: 11px; letter-spacing: 2px;
        }
        .main { margin-left: 250px; padding: 24px; }
        .topbar {
            display: flex; justify-content: space-between; align-items: center;
            background: white; padding: 16px 24px;
            border-radius: 12px; margin-bottom: 24px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        }
        .topbar h1 { font-size: 20px; color: #1a1a2e; }
        .user-info { display: flex; align-items: center; gap: 10px; }
        .user-avatar {
            width: 38px; height: 38px;
            background: linear-gradient(135deg, #1a1a2e, #29B6F6);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            color: white; font-weight: 600;
        }
        .user-name { font-size: 14px; font-weight: 600; color: #333; }
        .user-role { font-size: 11px; color: #888; }
        .btn-logout {
            padding: 8px 16px; background: #fff5f5;
            color: #e53e3e; border: 1px solid #fed7d7;
            border-radius: 8px; font-size: 13px; cursor: pointer;
        }
        .welcome-card {
            background: linear-gradient(135deg, #1a1a2e, #0F4C75);
            border-radius: 16px; padding: 32px;
            color: white; margin-bottom: 24px;
            display: flex; justify-content: space-between; align-items: center;
        }
        .welcome-card h2 { font-size: 24px; margin-bottom: 8px; }
        .welcome-card p { color: #a8d4f0; font-size: 14px; }
        .btn-reserver {
            padding: 12px 24px;
            background: #29B6F6; color: white;
            border: none; border-radius: 10px;
            font-size: 14px; font-weight: 600;
            cursor: pointer; text-decoration: none;
            white-space: nowrap;
        }
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 16px; margin-bottom: 24px;
        }
        .stat-card {
            background: white; border-radius: 12px;
            padding: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.06);
            display: flex; align-items: center; gap: 16px;
        }
        .stat-icon {
            width: 50px; height: 50px; border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 20px;
        }
        .stat-icon.blue   { background: #e3f2fd; color: #1E88E5; }
        .stat-icon.green  { background: #e8f5e9; color: #43a047; }
        .stat-icon.orange { background: #fff3e0; color: #fb8c00; }
        .stat-info h3 { font-size: 24px; font-weight: 700; color: #1a1a2e; }
        .stat-info p  { font-size: 12px; color: #888; margin-top: 2px; }
        .grid-2 {
            display: grid; grid-template-columns: 1fr 1fr; gap: 24px;
        }
        .card {
            background: white; border-radius: 12px;
            padding: 24px; box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        }
        .card-title {
            font-size: 16px; font-weight: 600;
            color: #1a1a2e; margin-bottom: 16px;
        }
        table { width: 100%; border-collapse: collapse; }
        th {
            background: #f8f9fa; padding: 10px 14px;
            text-align: left; font-size: 12px;
            color: #888; text-transform: uppercase;
        }
        td { padding: 10px 14px; font-size: 13px; border-bottom: 1px solid #f0f0f0; }
        tr:last-child td { border-bottom: none; }
        .badge {
            padding: 4px 10px; border-radius: 20px;
            font-size: 11px; font-weight: 600;
        }
        .badge-success   { background: #e8f5e9; color: #43a047; }
        .badge-warning   { background: #fff3e0; color: #fb8c00; }
        .badge-danger    { background: #ffebee; color: #e53935; }
        .badge-info      { background: #e3f2fd; color: #1E88E5; }
        .badge-secondary { background: #f5f5f5; color: #888; }
        .chambre-card {
            border: 1px solid #f0f0f0; border-radius: 10px;
            padding: 16px; margin-bottom: 12px;
            display: flex; justify-content: space-between; align-items: center;
        }
        .chambre-num { font-weight: 600; color: #1a1a2e; }
        .chambre-type { color: #888; font-size: 12px; margin-top: 2px; }
        .chambre-prix { color: #43a047; font-weight: 600; font-size: 14px; }
    </style>
</head>
<body>

<div class="sidebar">
    <div class="sidebar-logo">
        <h2>Stay<span>Flow</span></h2>
        <p>ESPACE CLIENT</p>
    </div>
    <span class="nav-section">Mon espace</span>
    <a href="{{ route('client.dashboard') }}" class="nav-item active">
        <i class="fas fa-home"></i> Accueil
    </a>
<a href="{{ route('client.reservations.index') }}" class="nav-item">
    <i class="fas fa-calendar-check"></i> Mes réservations
</a>
<a href="{{ route('client.factures.index') }}" class="nav-item">
    <i class="fas fa-file-invoice"></i> Mes factures
</a>
<a href="#" class="nav-item">
    <i class="fas fa-star"></i> Mes évaluations
</a>
<span class="nav-section">Hôtel</span>
<a href="{{ route('client.chambres.index') }}" class="nav-item">
    <i class="fas fa-bed"></i> Nos chambres
</a>
<a href="#" class="nav-item">
    <i class="fas fa-concierge-bell"></i> Nos services
</a>
</div>

<div class="main">
    <div class="topbar">
        <h1>Bienvenue, {{ $client->prenom }} !</h1>
        <div style="display:flex; align-items:center; gap:16px">
            <div class="user-info">
                <div class="user-avatar">
                    {{ strtoupper(substr($client->prenom, 0, 1)) }}
                </div>
                <div>
                    <div class="user-name">{{ $client->prenom }} {{ $client->nom }}</div>
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

    <div class="welcome-card">
        <div>
            <h2>Bonjour, {{ $client->prenom }} {{ $client->nom }} !</h2>
            <p>Bienvenue dans votre espace personnel StayFlow — Hôtel Campost</p>
        </div>
       <a href="{{ route('client.reservations.create') }}" class="btn-reserver">
    <i class="fas fa-plus"></i> Nouvelle réservation
</a>
    </div>

    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon blue"><i class="fas fa-calendar"></i></div>
            <div class="stat-info">
                <h3>{{ $stats['total_reservations'] }}</h3>
                <p>Total réservations</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon green"><i class="fas fa-check-circle"></i></div>
            <div class="stat-info">
                <h3>{{ $stats['reservations_actives'] }}</h3>
                <p>Réservations actives</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon orange"><i class="fas fa-history"></i></div>
            <div class="stat-info">
                <h3>{{ $stats['reservations_terminees'] }}</h3>
                <p>Séjours terminés</p>
            </div>
        </div>
    </div>

    <div class="grid-2">
        <div class="card">
            <div class="card-title">Mes réservations</div>
            <table>
                <thead>
                    <tr>
                        <th>Chambre</th>
                        <th>Arrivée</th>
                        <th>Départ</th>
                        <th>Statut</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($reservations as $r)
                    <tr>
                        <td>N° {{ $r->chambre->numero }}</td>
                        <td>{{ $r->date_arrivee->format('d/m/Y') }}</td>
                        <td>{{ $r->date_depart->format('d/m/Y') }}</td>
                        <td>
                            @php
                                $badges = [
                                    'en_attente' => 'badge-warning',
                                    'confirmee'  => 'badge-info',
                                    'checkin'    => 'badge-success',
                                    'checkout'   => 'badge-secondary',
                                    'annulee'    => 'badge-danger',
                                ];
                            @endphp
                            <span class="badge {{ $badges[$r->statut] ?? 'badge-warning' }}">
                                {{ ucfirst($r->statut) }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" style="text-align:center;color:#888;padding:24px">
                            Aucune réservation pour le moment
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="card">
            <div class="card-title">Chambres disponibles</div>
            @forelse($chambres_disponibles as $chambre)
            <div class="chambre-card">
                <div>
                    <div class="chambre-num">Chambre {{ $chambre->numero }}</div>
                    <div class="chambre-type">{{ $chambre->typeChambre->libelle_type }}</div>
                </div>
                <div class="chambre-prix">
                    {{ number_format($chambre->prix_nuit, 0, ',', ' ') }} FCFA/nuit
                </div>
            </div>
            @empty
            <p style="text-align:center;color:#888;padding:24px">
                Aucune chambre disponible
            </p>
            @endforelse
        </div>
    </div>
</div>

</body>
</html>