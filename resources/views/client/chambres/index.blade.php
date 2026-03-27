<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StayFlow — Nos Chambres</title>
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
        .btn-secondary { background: #f5f5f5; color: #555; }
        .chambres-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
        }
        .chambre-card {
            background: white; border-radius: 16px;
            overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.06);
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .chambre-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 24px rgba(0,0,0,0.12);
        }
        .chambre-header {
            background: linear-gradient(135deg, #1a1a2e, #0F4C75);
            padding: 24px; color: white; text-align: center;
        }
        .chambre-num { font-size: 32px; font-weight: 700; }
        .chambre-type { font-size: 14px; opacity: 0.8; margin-top: 4px; }
        .chambre-body { padding: 20px; }
        .chambre-prix {
            font-size: 22px; font-weight: 700;
            color: #29B6F6; margin-bottom: 12px;
        }
        .chambre-prix span { font-size: 13px; color: #888; font-weight: 400; }
        .chambre-detail {
            display: flex; align-items: center; gap: 8px;
            font-size: 13px; color: #666; margin-bottom: 8px;
        }
        .chambre-detail i { color: #29B6F6; width: 16px; }
        .badge-libre {
            display: inline-block;
            background: #e8f5e9; color: #43a047;
            padding: 4px 12px; border-radius: 20px;
            font-size: 11px; font-weight: 600; margin-bottom: 16px;
        }
        .btn-reserver {
            width: 100%; padding: 12px;
            background: linear-gradient(135deg, #1a1a2e, #29B6F6);
            color: white; border: none; border-radius: 10px;
            font-size: 14px; font-weight: 600;
            cursor: pointer; text-decoration: none;
            display: flex; align-items: center;
            justify-content: center; gap: 8px;
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
    <a href="{{ route('client.factures.index') }}" class="nav-item">
        <i class="fas fa-file-invoice"></i> Mes factures
    </a>
    <span class="nav-section">Hôtel</span>
    <a href="{{ route('client.chambres.index') }}" class="nav-item active">
        <i class="fas fa-bed"></i> Nos chambres
    </a>
</div>

<div class="main">
    <div class="topbar">
        <h1><i class="fas fa-bed" style="color:#29B6F6"></i> Nos Chambres Disponibles</h1>
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

    <div class="chambres-grid">
        @forelse($chambres as $chambre)
        <div class="chambre-card">
            <div class="chambre-header">
                <div class="chambre-num">{{ $chambre->numero }}</div>
                <div class="chambre-type">{{ $chambre->typeChambre->libelle_type }}</div>
            </div>
            <div class="chambre-body">
                <div class="chambre-prix">
                    {{ number_format($chambre->prix_nuit, 0, ',', ' ') }} FCFA
                    <span>/ nuit</span>
                </div>
                <div class="chambre-detail">
                    <i class="fas fa-users"></i>
                    {{ $chambre->typeChambre->capacite }} personne(s)
                </div>
                <div class="chambre-detail">
                    <i class="fas fa-door-open"></i>
                    Chambre N° {{ $chambre->numero }}
                </div>
                <span class="badge-libre">Disponible</span>
                <a href="{{ route('client.reservations.create') }}?chambre={{ $chambre->id_chambre }}"
                   class="btn-reserver">
                    <i class="fas fa-calendar-plus"></i> Réserver cette chambre
                </a>
            </div>
        </div>
        @empty
        <div style="grid-column:1/-1;text-align:center;padding:48px;color:#888">
            <i class="fas fa-bed" style="font-size:48px;margin-bottom:16px;display:block"></i>
            Aucune chambre disponible pour le moment
        </div>
        @endforelse
    </div>
</div>
</body>
</html>