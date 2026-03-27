<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StayFlow — Dashboard Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', sans-serif; background: #f0f2f5; }

        /* Sidebar */
        .sidebar {
            position: fixed; top: 0; left: 0;
            width: 250px; height: 100vh;
            background: #0A1628;
            padding: 24px 0;
            z-index: 100;
        }
        .sidebar-logo {
            padding: 0 24px 24px;
            border-bottom: 1px solid #1a2f4e;
            margin-bottom: 16px;
        }
        .sidebar-logo h2 { color: white; font-size: 22px; }
        .sidebar-logo h2 span { color: #29B6F6; }
        .sidebar-logo p { color: #546E7A; font-size: 11px; letter-spacing: 2px; }
        .nav-item {
            display: flex; align-items: center; gap: 12px;
            padding: 12px 24px;
            color: #8899aa;
            text-decoration: none;
            font-size: 14px;
            transition: all 0.2s;
        }
        .nav-item:hover, .nav-item.active {
            background: #1a2f4e;
            color: #29B6F6;
            border-left: 3px solid #29B6F6;
        }
        .nav-item i { width: 20px; }
        .nav-section {
            padding: 16px 24px 8px;
            color: #546E7A;
            font-size: 11px;
            letter-spacing: 2px;
            text-transform: uppercase;
        }

        /* Main content */
        .main { margin-left: 250px; padding: 24px; }

        /* Topbar */
        .topbar {
            display: flex; justify-content: space-between; align-items: center;
            background: white;
            padding: 16px 24px;
            border-radius: 12px;
            margin-bottom: 24px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        }
        .topbar h1 { font-size: 20px; color: #0A1628; }
        .topbar-right { display: flex; align-items: center; gap: 16px; }
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
        .btn-logout {
            padding: 8px 16px;
            background: #fff5f5;
            color: #e53e3e;
            border: 1px solid #fed7d7;
            border-radius: 8px;
            font-size: 13px;
            cursor: pointer;
            text-decoration: none;
        }

        /* Stats cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 16px;
            margin-bottom: 24px;
        }
        .stat-card {
            background: white;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
            display: flex; align-items: center; gap: 16px;
        }
        .stat-icon {
            width: 50px; height: 50px;
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 20px;
        }
        .stat-icon.blue   { background: #e3f2fd; color: #1E88E5; }
        .stat-icon.green  { background: #e8f5e9; color: #43a047; }
        .stat-icon.orange { background: #fff3e0; color: #fb8c00; }
        .stat-icon.red    { background: #ffebee; color: #e53935; }
        .stat-icon.purple { background: #f3e5f5; color: #8e24aa; }
        .stat-info h3 { font-size: 24px; font-weight: 700; color: #0A1628; }
        .stat-info p  { font-size: 12px; color: #888; margin-top: 2px; }

        /* Table */
        .card {
            background: white;
            border-radius: 12px;
            padding: 24px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
            margin-bottom: 24px;
        }
        .card-title {
            font-size: 16px; font-weight: 600;
            color: #0A1628; margin-bottom: 16px;
            display: flex; justify-content: space-between; align-items: center;
        }
        table { width: 100%; border-collapse: collapse; }
        th {
            background: #f8f9fa;
            padding: 12px 16px;
            text-align: left;
            font-size: 12px;
            color: #888;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        td { padding: 12px 16px; font-size: 14px; border-bottom: 1px solid #f0f0f0; }
        tr:last-child td { border-bottom: none; }
        .badge {
            padding: 4px 10px; border-radius: 20px;
            font-size: 11px; font-weight: 600;
        }
        .badge-success  { background: #e8f5e9; color: #43a047; }
        .badge-warning  { background: #fff3e0; color: #fb8c00; }
        .badge-danger   { background: #ffebee; color: #e53935; }
        .badge-info     { background: #e3f2fd; color: #1E88E5; }
        .badge-secondary{ background: #f5f5f5; color: #888; }
    </style>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar">
    <div class="sidebar-logo">
        <h2>Stay<span>Flow</span></h2>
        <p>SUPER ADMIN</p>
    </div>
    <span class="nav-section">Principal</span>
    <a href="{{ route('admin.dashboard') }}" class="nav-item active">
        <i class="fas fa-tachometer-alt"></i> Dashboard
    </a>
    <span class="nav-section">Gestion</span>
  <a href="{{ route('admin.chambres.index') }}" class="nav-item">
    <i class="fas fa-bed"></i> Chambres
</a>
<a href="{{ route('admin.reservations.index') }}" class="nav-item">
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
    <i class="fas fa-star"></i> Évaluations</a>
</div>

<!-- Main -->
<div class="main">
    <!-- Topbar -->
    <div class="topbar">
        <h1>Tableau de bord</h1>
        <div class="topbar-right">
            <div class="user-info">
                <div class="user-avatar">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                <div>
                    <div class="user-name">{{ Auth::user()->name }}</div>
                    <div class="user-role">Super Administrateur</div>
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

    <!-- Stats -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon blue"><i class="fas fa-bed"></i></div>
            <div class="stat-info">
                <h3>{{ $stats['total_chambres'] }}</h3>
                <p>Total chambres</p>
            </div>
        </div>
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
            <div class="stat-icon purple"><i class="fas fa-users"></i></div>
            <div class="stat-info">
                <h3>{{ $stats['total_clients'] }}</h3>
                <p>Total clients</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon blue"><i class="fas fa-calendar-check"></i></div>
            <div class="stat-info">
                <h3>{{ $stats['total_reservations'] }}</h3>
                <p>Réservations</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon red"><i class="fas fa-file-invoice"></i></div>
            <div class="stat-info">
                <h3>{{ $stats['factures_non_payees'] }}</h3>
                <p>Factures impayées</p>
            </div>
        </div>
    </div>

    <!-- Réservations récentes -->
    <div class="card">
        <div class="card-title">
            <span>Réservations récentes</span>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Client</th>
                    <th>Chambre</th>
                    <th>Arrivée</th>
                    <th>Départ</th>
                    <th>Statut</th>
                </tr>
            </thead>
            <tbody>
                @forelse($reservations_recentes as $reservation)
                <tr>
                    <td>{{ $reservation->client->prenom }} {{ $reservation->client->nom }}</td>
                    <td>Chambre {{ $reservation->chambre->numero }}</td>
                    <td>{{ $reservation->date_arrivee->format('d/m/Y') }}</td>
                    <td>{{ $reservation->date_depart->format('d/m/Y') }}</td>
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
                        <span class="badge {{ $badges[$reservation->statut] ?? 'badge-secondary' }}">
                            {{ ucfirst($reservation->statut) }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="text-align:center; color:#888; padding:32px">
                        Aucune réservation pour le moment
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

</body>
</html>