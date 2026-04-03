<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StayFlow — Réception</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', sans-serif; background: #f0f2f5; }
        .sidebar {
            position: fixed; top: 0; left: 0;
            width: 250px; height: 100vh;
            background: #0F4C75;
            padding: 24px 0; z-index: 100;
        }
        .sidebar-logo {
            padding: 0 24px 24px;
            border-bottom: 1px solid #1B6CA8;
            margin-bottom: 16px;
        }
        .sidebar-logo h2 { color: white; font-size: 22px; }
        .sidebar-logo h2 span { color: #29B6F6; }
        .sidebar-logo p { color: #7fb3d3; font-size: 11px; letter-spacing: 2px; }
        .nav-item {
            display: flex; align-items: center; gap: 12px;
            padding: 12px 24px;
            color: #a8d4f0;
            text-decoration: none;
            font-size: 14px;
            transition: all 0.2s;
        }
        .nav-item:hover, .nav-item.active {
            background: #1B6CA8;
            color: white;
            border-left: 3px solid #29B6F6;
        }
        .nav-item i { width: 20px; }
        .nav-section {
            padding: 16px 24px 8px;
            color: #7fb3d3;
            font-size: 11px;
            letter-spacing: 2px;
        }
        .main { margin-left: 250px; padding: 24px; }
        .topbar {
            display: flex; justify-content: space-between; align-items: center;
            background: white; padding: 16px 24px;
            border-radius: 12px; margin-bottom: 24px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        }
        .topbar h1 { font-size: 20px; color: #0F4C75; }
        .user-info { display: flex; align-items: center; gap: 10px; }
        .user-avatar {
            width: 38px; height: 38px;
            background: linear-gradient(135deg, #0F4C75, #29B6F6);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            color: white; font-weight: 600;
        }
        .user-name { font-size: 14px; font-weight: 600; color: #333; }
        .user-role { font-size: 11px; color: #888; }
        .btn-logout {
            padding: 8px 16px;
            background: #fff5f5; color: #e53e3e;
            border: 1px solid #fed7d7;
            border-radius: 8px; font-size: 13px;
            cursor: pointer; text-decoration: none;
        }
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
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
        .stat-icon.red    { background: #ffebee; color: #e53935; }
        .stat-info h3 { font-size: 24px; font-weight: 700; color: #0F4C75; }
        .stat-info p  { font-size: 12px; color: #888; margin-top: 2px; }
        .grid-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 24px;
        }
        .card {
            background: white; border-radius: 12px;
            padding: 24px; box-shadow: 0 2px 8px rgba(0,0,0,0.06);
            margin-bottom: 24px;
        }
        .card-title {
            font-size: 16px; font-weight: 600;
            color: #0F4C75; margin-bottom: 16px;
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
        .badge-success  { background: #e8f5e9; color: #43a047; }
        .badge-warning  { background: #fff3e0; color: #fb8c00; }
        .badge-danger   { background: #ffebee; color: #e53935; }
        .badge-info     { background: #e3f2fd; color: #1E88E5; }
        .chambre-item {
            display: flex; justify-content: space-between;
            align-items: center; padding: 10px 0;
            border-bottom: 1px solid #f0f0f0;
            font-size: 14px;
        }
        .chambre-item:last-child { border-bottom: none; }
        .chambre-num { font-weight: 600; color: #0F4C75; }
        .chambre-type { color: #888; font-size: 12px; }
        .chambre-prix { color: #43a047; font-weight: 600; }
    </style>
</head>
<body>

<div class="sidebar">
    <div class="sidebar-logo">
        <h2>Stay<span>Flow</span></h2>
        <p>RÉCEPTION</p>
    </div>
    <span class="nav-section">Principal</span>
    <a href="{{ route('reception.dashboard') }}" class="nav-item active">
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
<a href="{{ route('reception.factures.index') }}" class="nav-item">
    <i class="fas fa-file-invoice"></i> Factures
</a>
<span class="nav-section">Session</span>
 <form method="POST" action="{{ route('logout') }}" >
                @csrf
                <button type="submit" class="nav-item" style="color:rgb(255, 0, 0);">
                    <i class="fas fa-file-invoice"></i> Déconnexion
                </button>
            </form>
</div>

<div class="main">
    <div class="topbar">
        <h1>Tableau de bord — Réception</h1>
        <div style="display:flex; align-items:center; gap:16px">
            <div class="user-info">
                <div class="user-avatar">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                <div>
                    <div class="user-name">{{ Auth::user()->name }}</div>
                    <div class="user-role">Réceptionniste</div>
                </div>
            </div>
           
        </div>
    </div>

    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon green"><i class="fas fa-check-circle"></i></div>
            <div class="stat-info">
                <h3>{{ $stats['chambres_libres'] }}</h3>
                <p>Chambres libres</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon orange"><i class="fas fa-door-open"></i></div>
            <div class="stat-info">
                <h3>{{ $stats['chambres_occupees'] }}</h3>
                <p>Chambres occupées</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon blue"><i class="fas fa-sign-in-alt"></i></div>
            <div class="stat-info">
                <h3>{{ $stats['checkins_today'] }}</h3>
                <p>Check-ins aujourd'hui</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon red"><i class="fas fa-sign-out-alt"></i></div>
            <div class="stat-info">
                <h3>{{ $stats['checkouts_today'] }}</h3>
                <p>Check-outs aujourd'hui</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon orange"><i class="fas fa-file-invoice"></i></div>
            <div class="stat-info">
                <h3>{{ $stats['factures_en_attente'] }}</h3>
                <p>Factures en attente</p>
            </div>
        </div>
    </div>

    <div class="grid-2">
        <div class="card">
            <div class="card-title">Réservations du jour</div>
            <table>
                <thead>
                    <tr>
                        <th>Client</th>
                        <th>Chambre</th>
                        <th>Statut</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($reservations_today as $r)
                    <tr>
                        <td>{{ $r->client->prenom }} {{ $r->client->nom }}</td>
                        <td>N° {{ $r->chambre->numero }}</td>
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
                        <td colspan="3" style="text-align:center;color:#888;padding:24px">
                            Aucune réservation aujourd'hui
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="card">
            <div class="card-title">Chambres disponibles</div>
            @forelse($chambres_libres as $chambre)
            <div class="chambre-item">
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