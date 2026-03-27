<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StayFlow — Encaisser Facture</title>
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
        .btn-primary   { background: #1E88E5; color: white; }
        .btn-secondary { background: #f5f5f5; color: #555; }
        .btn-success   { background: #43a047; color: white; }
        .card {
            background: white; border-radius: 12px;
            padding: 32px; box-shadow: 0 2px 8px rgba(0,0,0,0.06);
            max-width: 600px;
        }
        .form-group { margin-bottom: 20px; }
        .form-group label {
            display: block; font-size: 13px;
            font-weight: 600; color: #555; margin-bottom: 8px;
        }
        .form-group select {
            width: 100%; padding: 12px 16px;
            border: 2px solid #e8e8e8; border-radius: 10px;
            font-size: 15px; outline: none; transition: border-color 0.3s;
        }
        .form-group select:focus { border-color: #29B6F6; }
        .error-msg { color: #e53e3e; font-size: 12px; margin-top: 4px; }
        .form-actions { display: flex; gap: 12px; margin-top: 24px; }
        .montant-box {
            background: linear-gradient(135deg, #0F4C75, #1E88E5);
            border-radius: 12px; padding: 24px;
            color: white; margin-bottom: 24px;
            text-align: center;
        }
        .montant-box .label { font-size: 14px; opacity: 0.8; }
        .montant-box .amount { font-size: 36px; font-weight: 700; margin-top: 8px; }
        .montant-box .client { font-size: 13px; opacity: 0.7; margin-top: 8px; }
        .mode-grid {
            display: grid; grid-template-columns: repeat(3, 1fr); gap: 12px;
            margin-top: 8px;
        }
        .mode-btn {
            padding: 14px; border: 2px solid #e8e8e8;
            border-radius: 10px; text-align: center;
            cursor: pointer; transition: all 0.2s;
            font-size: 13px; font-weight: 600; color: #555;
        }
        .mode-btn:hover { border-color: #29B6F6; color: #1E88E5; }
        .mode-btn input { display: none; }
        .mode-btn.selected { border-color: #1E88E5; background: #e3f2fd; color: #1E88E5; }
        .mode-btn i { display: block; font-size: 24px; margin-bottom: 8px; }
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
        <h1><i class="fas fa-credit-card" style="color:#43a047"></i>
            Encaisser Facture #{{ $facture->id_facture }}
        </h1>
        <div style="display:flex;align-items:center;gap:16px">
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

    <div class="card">
        <div class="montant-box">
            <div class="label">Montant à encaisser</div>
            <div class="amount">
                {{ number_format($facture->montant_total, 0, ',', ' ') }} FCFA
            </div>
            <div class="client">
                {{ $facture->reservation->client->prenom }}
                {{ $facture->reservation->client->nom }}
                — Chambre {{ $facture->reservation->chambre->numero }}
            </div>
        </div>

        <form method="POST"
              action="{{ route('reception.factures.payer', $facture->id_facture) }}">
            @csrf
            @method('PATCH')

            <div class="form-group">
                <label>Mode de paiement</label>
                <div class="mode-grid">
                    <label class="mode-btn" onclick="selectMode(this, 'especes')">
                        <input type="radio" name="mode_paiement" value="especes"/>
                        <i class="fas fa-money-bill-wave"></i>
                        Espèces
                    </label>
                    <label class="mode-btn" onclick="selectMode(this, 'carte')">
                        <input type="radio" name="mode_paiement" value="carte"/>
                        <i class="fas fa-credit-card"></i>
                        Carte
                    </label>
                    <label class="mode-btn" onclick="selectMode(this, 'mobile_money')">
                        <input type="radio" name="mode_paiement" value="mobile_money"/>
                        <i class="fas fa-mobile-alt"></i>
                        Mobile Money
                    </label>
                    <label class="mode-btn" onclick="selectMode(this, 'virement')">
                        <input type="radio" name="mode_paiement" value="virement"/>
                        <i class="fas fa-university"></i>
                        Virement
                    </label>
                    <label class="mode-btn" onclick="selectMode(this, 'cheque')">
                        <input type="radio" name="mode_paiement" value="cheque"/>
                        <i class="fas fa-money-check"></i>
                        Chèque
                    </label>
                </div>
                @error('mode_paiement')
                    <div class="error-msg">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-check"></i> Confirmer le paiement
                </button>
                <a href="{{ route('reception.factures.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Retour
                </a>
            </div>
        </form>
    </div>
</div>

<script>
function selectMode(label, value) {
    document.querySelectorAll('.mode-btn').forEach(b => b.classList.remove('selected'));
    label.classList.add('selected');
    label.querySelector('input').checked = true;
}
</script>
</body>
</html>