<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StayFlow — Notifications</title>
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
            position: relative;
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
        .badge-count {
            background: #e53935; color: white;
            border-radius: 50%; width: 20px; height: 20px;
            display: flex; align-items: center; justify-content: center;
            font-size: 11px; font-weight: 700;
            margin-left: auto;
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
        .btn-primary   { background: #1E88E5; color: white; }
        .btn-secondary { background: #f5f5f5; color: #555; }
        .btn-success   { background: #43a047; color: white; }
        .btn-sm { padding: 6px 12px; font-size: 12px; }
        .alert-success {
            background: #e8f5e9; color: #2e7d32;
            padding: 12px 16px; border-radius: 8px;
            margin-bottom: 16px; border-left: 4px solid #43a047;
        }
        .alert-info {
            background: #e3f2fd; color: #1565c0;
            padding: 12px 16px; border-radius: 8px;
            margin-bottom: 16px; border-left: 4px solid #1E88E5;
        }
        .notif-card {
            background: white; border-radius: 12px;
            padding: 20px; margin-bottom: 16px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
            border-left: 5px solid #1E88E5;
            transition: all 0.2s;
        }
        .notif-card.non-lue {
            border-left-color: #e53935;
            background: #fff8f8;
        }
        .notif-card.lue {
            border-left-color: #ccc;
            opacity: 0.8;
        }
        .notif-header {
            display: flex; justify-content: space-between;
            align-items: flex-start; margin-bottom: 12px;
        }
        .notif-titre {
            font-size: 16px; font-weight: 700; color: #0F4C75;
            display: flex; align-items: center; gap: 8px;
        }
        .notif-titre .dot {
            width: 10px; height: 10px; border-radius: 50%;
            background: #e53935; display: inline-block;
        }
        .notif-titre .dot.lue { background: #ccc; }
        .notif-date { font-size: 12px; color: #888; }
        .notif-message {
            font-size: 14px; color: #555; line-height: 1.6;
            margin-bottom: 16px;
        }
        .notif-actions { display: flex; gap: 8px; flex-wrap: wrap; }
        .btn-valider {
            background: #43a047; color: white;
            padding: 8px 16px; border-radius: 8px;
            font-size: 13px; font-weight: 600;
            text-decoration: none; border: none;
            cursor: pointer; display: inline-flex;
            align-items: center; gap: 6px;
        }
        .btn-valider:hover { background: #2e7d32; }
        .btn-lu {
            background: #f5f5f5; color: #555;
            padding: 8px 16px; border-radius: 8px;
            font-size: 13px; font-weight: 600;
            border: none; cursor: pointer;
            display: inline-flex; align-items: center; gap: 6px;
        }
        .btn-voir-reservation {
            background: #e3f2fd; color: #1E88E5;
            padding: 8px 16px; border-radius: 8px;
            font-size: 13px; font-weight: 600;
            text-decoration: none; display: inline-flex;
            align-items: center; gap: 6px;
        }
        .empty-state {
            text-align: center; padding: 64px;
            color: #888; background: white;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        }
        .empty-state i {
            font-size: 64px; display: block;
            margin-bottom: 16px; color: #ccc;
        }
        .stats-bar {
            display: flex; gap: 16px; margin-bottom: 24px;
        }
        .stat-pill {
            padding: 8px 16px; border-radius: 20px;
            font-size: 13px; font-weight: 600;
        }
        .stat-pill.non-lue { background: #ffebee; color: #e53935; }
        .stat-pill.total   { background: #e3f2fd; color: #1E88E5; }
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
    <a href="{{ route('reception.factures.index') }}" class="nav-item">
        <i class="fas fa-file-invoice"></i> Factures
    </a>
    <span class="nav-section">Alertes</span>
    <a href="{{ route('reception.notifications.index') }}" class="nav-item active">
        <i class="fas fa-bell"></i> Notifications
        @if($non_lues > 0)
        <span class="badge-count">{{ $non_lues }}</span>
        @endif
    </a>
</div>

<div class="main">
    <div class="topbar">
        <h1>
            <i class="fas fa-bell" style="color:#1E88E5"></i>
            Notifications
            @if($non_lues > 0)
            <span style="background:#e53935;color:white;padding:2px 10px;
                         border-radius:20px;font-size:14px;margin-left:8px">
                {{ $non_lues }} nouvelle(s)
            </span>
            @endif
        </h1>
        <div style="display:flex;align-items:center;gap:16px">
            @if($non_lues > 0)
            <form method="POST" action="{{ route('reception.notifications.tout_lu') }}">
                @csrf @method('PATCH')
                <button type="submit" class="btn btn-secondary">
                    <i class="fas fa-check-double"></i> Tout marquer comme lu
                </button>
            </form>
            @endif
            <div class="user-info">
                <div class="user-avatar">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
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

    @if(session('success'))
        <div class="alert-success">{{ session('success') }}</div>
    @endif
    @if(session('info'))
        <div class="alert-info">{{ session('info') }}</div>
    @endif

    <div class="stats-bar">
        <span class="stat-pill total">
            <i class="fas fa-bell"></i>
            {{ $notifications->count() }} notification(s) au total
        </span>
        @if($non_lues > 0)
        <span class="stat-pill non-lue">
            <i class="fas fa-exclamation-circle"></i>
            {{ $non_lues }} non lue(s)
        </span>
        @endif
    </div>

    @forelse($notifications as $notif)
    <div class="notif-card {{ $notif->lu ? 'lue' : 'non-lue' }}">
        <div class="notif-header">
            <div class="notif-titre">
                <span class="dot {{ $notif->lu ? 'lue' : '' }}"></span>
                @if($notif->type == 'paiement')
                    <i class="fas fa-mobile-alt" style="color:#43a047"></i>
                @else
                    <i class="fas fa-info-circle" style="color:#1E88E5"></i>
                @endif
                {{ $notif->titre }}
            </div>
            <div class="notif-date">
                <i class="fas fa-clock"></i>
                {{ $notif->created_at->diffForHumans() }}
            </div>
        </div>

        <div class="notif-message">
            {{ $notif->message }}
        </div>

        <div class="notif-actions">
            @if($notif->type == 'paiement' && $notif->id_reservation)
                @php
                    $reservation = \App\Models\Reservation::find($notif->id_reservation);
                @endphp
                @if($reservation && $reservation->statut == 'en_attente')
                <form method="POST"
                      action="{{ route('reception.notifications.valider', $notif->id) }}">
                    @csrf
                    <button type="submit" class="btn-valider"
                            onclick="return confirm('Confirmer cette reservation ?')">
                        <i class="fas fa-check-circle"></i>
                        Valider la réservation
                    </button>
                </form>
                @else
                <span style="color:#43a047;font-weight:600;font-size:13px">
                    <i class="fas fa-check-circle"></i>
                    Réservation déjà traitée
                </span>
                @endif

                @if($notif->id_reservation)
                <a href="{{ route('reception.reservations.show', $notif->id_reservation) }}"
                   class="btn-voir-reservation">
                    <i class="fas fa-eye"></i> Voir la réservation
                </a>
                @endif

                @if($notif->id_facture)
                <a href="{{ route('reception.factures.show', $notif->id_facture) }}"
                   class="btn-voir-reservation">
                    <i class="fas fa-file-invoice"></i> Voir la facture
                </a>
                @endif
            @endif

            @if(!$notif->lu)
            <form method="POST"
                  action="{{ route('reception.notifications.lu', $notif->id) }}">
                @csrf @method('PATCH')
                <button type="submit" class="btn-lu">
                    <i class="fas fa-check"></i> Marquer comme lu
                </button>
            </form>
            @endif
        </div>
    </div>
    @empty
    <div class="empty-state">
        <i class="fas fa-bell-slash"></i>
        <h3 style="margin-bottom:8px;color:#555">Aucune notification</h3>
        <p>Les notifications de paiement apparaitront ici</p>
    </div>
    @endforelse
</div>

<script>
// Rafraichir le compteur toutes les 30 secondes
setInterval(() => {
    fetch('{{ route("reception.notifications.count") }}')
        .then(r => r.json())
        .then(data => {
            const badges = document.querySelectorAll('.badge-count');
            if (data.count > 0) {
                badges.forEach(b => b.textContent = data.count);
            }
        });
}, 30000);
</script>
</body>
</html>