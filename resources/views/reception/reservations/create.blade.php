<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StayFlow — Nouvelle Réservation</title>
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
        .card {
            background: white; border-radius: 12px;
            padding: 32px; box-shadow: 0 2px 8px rgba(0,0,0,0.06);
            max-width: 700px;
        }
        .form-group { margin-bottom: 20px; }
        .form-group label {
            display: block; font-size: 13px;
            font-weight: 600; color: #555; margin-bottom: 8px;
        }
        .form-group input,
        .form-group select {
            width: 100%; padding: 12px 16px;
            border: 2px solid #e8e8e8; border-radius: 10px;
            font-size: 15px; outline: none; transition: border-color 0.3s;
        }
        .form-group input:focus,
        .form-group select:focus { border-color: #29B6F6; }
        .error-msg { color: #e53e3e; font-size: 12px; margin-top: 4px; }
        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
        .form-actions { display: flex; gap: 12px; margin-top: 24px; }
        .section-title {
            font-size: 14px; font-weight: 600; color: #0F4C75;
            margin-bottom: 16px; padding-bottom: 8px;
            border-bottom: 2px solid #e3f2fd;
        }
        .total-card {
            background: linear-gradient(135deg, #0F4C75, #1E88E5);
            border-radius: 12px; padding: 20px;
            color: white; margin-top: 16px; display: none;
        }
        .total-card h3 { font-size: 14px; opacity: 0.8; }
        .total-card .amount { font-size: 28px; font-weight: 700; }
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
    <a href="{{ route('reception.reservations.index') }}" class="nav-item active">
        <i class="fas fa-calendar-check"></i> Réservations
    </a>
    <a href="{{ route('reception.clients.index') }}" class="nav-item">
        <i class="fas fa-users"></i> Clients
    </a>
    <a href="{{ route('reception.factures.index') }}" class="nav-item">
        <i class="fas fa-file-invoice"></i> Factures
    </a>
</div>

<div class="main">
    <div class="topbar">
        <h1><i class="fas fa-plus" style="color:#1E88E5"></i> Nouvelle Réservation</h1>
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
        <form method="POST" action="{{ route('reception.reservations.store') }}">
            @csrf

            <div class="section-title">
                <i class="fas fa-user"></i> Sélection du client
            </div>

            <div class="form-group">
                <label>Client</label>
                <select name="id_client" required>
                    <option value="">-- Sélectionner un client --</option>
                    @foreach($clients as $client)
                        <option value="{{ $client->id_client }}"
                            {{ old('id_client') == $client->id_client ? 'selected' : '' }}>
                            {{ $client->prenom }} {{ $client->nom }}
                            — {{ $client->telephone ?? $client->email }}
                        </option>
                    @endforeach
                </select>
                @error('id_client')
                    <div class="error-msg">{{ $message }}</div>
                @enderror
            </div>

            <div class="section-title">
                <i class="fas fa-bed"></i> Sélection de la chambre
            </div>

            <div class="form-group">
                <label>Chambre disponible</label>
                <select name="id_chambre" id="chambre-select"
                        onchange="updateChambreInfo(this)" required>
                    <option value="">-- Sélectionner une chambre --</option>
                    @foreach($chambres as $chambre)
                        <option value="{{ $chambre->id_chambre }}"
                                data-prix="{{ $chambre->prix_nuit }}"
                            {{ old('id_chambre') == $chambre->id_chambre ? 'selected' : '' }}>
                            Chambre {{ $chambre->numero }}
                            — {{ $chambre->typeChambre->libelle_type }}
                            — {{ number_format($chambre->prix_nuit, 0, ',', ' ') }} FCFA/nuit
                        </option>
                    @endforeach
                </select>
                @error('id_chambre')
                    <div class="error-msg">{{ $message }}</div>
                @enderror
            </div>

            <div class="section-title">
                <i class="fas fa-calendar"></i> Dates du séjour
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Date d'arrivée</label>
                    <input type="date" name="date_arrivee"
                           value="{{ old('date_arrivee') }}"
                           min="{{ date('Y-m-d') }}"
                           onchange="calculateTotal()" required/>
                    @error('date_arrivee')
                        <div class="error-msg">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Date de départ</label>
                    <input type="date" name="date_depart"
                           value="{{ old('date_depart') }}"
                           onchange="calculateTotal()" required/>
                    @error('date_depart')
                        <div class="error-msg">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="total-card" id="total-card">
                <h3>Montant total estimé</h3>
                <div class="amount" id="total-amount">0 FCFA</div>
                <div id="total-details" style="font-size:13px;opacity:0.8;margin-top:4px"></div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Créer la réservation
                </button>
                <a href="{{ route('reception.reservations.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Retour
                </a>
            </div>
        </form>
    </div>
</div>

<script>
let prixNuit = 0;
function updateChambreInfo(select) {
    const option = select.options[select.selectedIndex];
    prixNuit = parseFloat(option.dataset.prix) || 0;
    calculateTotal();
}
function calculateTotal() {
    const arrivee = document.querySelector('[name="date_arrivee"]').value;
    const depart  = document.querySelector('[name="date_depart"]').value;
    const card    = document.getElementById('total-card');
    if (arrivee && depart && prixNuit > 0) {
        const diff = (new Date(depart) - new Date(arrivee)) / (1000 * 60 * 60 * 24);
        if (diff > 0) {
            const total = diff * prixNuit;
            document.getElementById('total-amount').textContent =
                total.toLocaleString('fr-FR') + ' FCFA';
            document.getElementById('total-details').textContent =
                diff + ' nuit(s) × ' + prixNuit.toLocaleString('fr-FR') + ' FCFA';
            card.style.display = 'block';
        }
    } else {
        card.style.display = 'none';
    }
}
</script>
</body>
</html>