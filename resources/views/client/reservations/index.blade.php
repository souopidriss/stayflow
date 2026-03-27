<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StayFlow — Mes Réservations</title>
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
        .btn-primary { background: #29B6F6; color: white; }
        .card {
            background: white; border-radius: 12px;
            padding: 24px; box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        }
        .alert-success {
            background: #e8f5e9; color: #2e7d32;
            padding: 12px 16px; border-radius: 8px;
            margin-bottom: 16px; border-left: 4px solid #43a047;
        }
        table { width: 100%; border-collapse: collapse; }
        th {
            background: #f8f9fa; padding: 12px 16px;
            text-align: left; font-size: 12px;
            color: #888; text-transform: uppercase; letter-spacing: 1px;
        }
        td { padding: 12px 16px; font-size: 14px; border-bottom: 1px solid #f0f0f0; }
        tr:last-child td { border-bottom: none; }
        tr:hover td { background: #fafafa; }
        .badge {
            padding: 4px 10px; border-radius: 20px;
            font-size: 11px; font-weight: 600;
        }
        .badge-success   { background: #e8f5e9; color: #43a047; }
        .badge-warning   { background: #fff3e0; color: #fb8c00; }
        .badge-danger    { background: #ffebee; color: #e53935; }
        .badge-info      { background: #e3f2fd; color: #1E88E5; }
        .badge-secondary { background: #f5f5f5; color: #888; }
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
    <a href="{{ route('client.reservations.index') }}" class="nav-item active">
        <i class="fas fa-calendar-check"></i> Mes réservations
    </a>
    <a href="{{ route('client.factures.index') }}" class="nav-item">
        <i class="fas fa-file-invoice"></i> Mes factures
    </a>
    <span class="nav-section">Hôtel</span>
    <a href="{{ route('client.chambres.index') }}" class="nav-item">
        <i class="fas fa-bed"></i> Nos chambres
    </a>
</div>

<div class="main">
    <div class="topbar">
        <h1><i class="fas fa-calendar-check" style="color:#29B6F6"></i> Mes Réservations</h1>
        <div style="display:flex;align-items:center;gap:16px">
            <a href="{{ route('client.reservations.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Nouvelle Réservation
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

    @if(session('success'))
        <div class="alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Chambre</th>
                    <th>Arrivée</th>
                    <th>Départ</th>
                    <th>Nuits</th>
                    <th>Montant</th>
                    <th>Statut</th>
                </tr>
            </thead>
            <tbody>
                @forelse($reservations as $r)
                <tr>
                    <td>{{ $r->id_reservation }}</td>
                    <td>
                        <strong>N° {{ $r->chambre->numero }}</strong><br>
                        <small style="color:#888">
                            {{ $r->chambre->typeChambre->libelle_type }}
                        </small>
                    </td>
                    <td>{{ $r->date_arrivee->format('d/m/Y') }}</td>
                    <td>{{ $r->date_depart->format('d/m/Y') }}</td>
                    <td>{{ $r->nombre_nuits }} nuit(s)</td>
                    <td>
                        <strong>
                            {{ number_format($r->facture->montant_total ?? 0, 0, ',', ' ') }} FCFA
                        </strong>
                    </td>
                    <td>
                        @php
                            $badges = [
                                'en_attente' => 'badge-warning',
                                'confirmee'  => 'badge-info',
                                'checkin'    => 'badge-success',
                                'checkout'   => 'badge-secondary',
                                'annulee'    => 'badge-danger',
                            ];
                            $labels = [
                                'en_attente' => 'En attente',
                                'confirmee'  => 'Confirmée',
                                'checkin'    => 'Check-in',
                                'checkout'   => 'Terminé',
                                'annulee'    => 'Annulée',
                            ];
                        @endphp
                        <span class="badge {{ $badges[$r->statut] ?? 'badge-secondary' }}">
                            {{ $labels[$r->statut] ?? $r->statut }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="text-align:center;color:#888;padding:48px">
                        <i class="fas fa-calendar" style="font-size:32px;display:block;margin-bottom:12px"></i>
                        Vous n'avez pas encore de réservation
                        <br><br>
                        <a href="{{ route('client.reservations.create') }}"
                           style="color:#29B6F6;text-decoration:none;font-weight:600">
                            Faire une réservation →
                        </a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
</body>
</html>