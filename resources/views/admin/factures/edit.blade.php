<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StayFlow — Modifier Facture</title>
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
        .section-title {
            font-size: 14px; font-weight: 600; color: #1E88E5;
            margin-bottom: 16px; padding-bottom: 8px;
            border-bottom: 2px solid #e3f2fd;
        }
        .info-box {
            background: #f8f9fa; border-radius: 10px;
            padding: 16px; margin-bottom: 20px;
            font-size: 14px; line-height: 1.8;
        }
        .info-box strong { color: #0A1628; }
        .montant-box {
            background: linear-gradient(135deg, #1E88E5, #29B6F6);
            border-radius: 10px; padding: 16px 20px;
            color: white; margin-bottom: 24px;
            display: flex; justify-content: space-between; align-items: center;
        }
        .montant-box .label { font-size: 13px; opacity: 0.8; }
        .montant-box .amount { font-size: 24px; font-weight: 700; }
        .paiement-section {
            background: #fff3e0; border-radius: 10px;
            padding: 16px; margin-top: 16px;
            border-left: 4px solid #fb8c00;
            display: none;
        }
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
    <a href="{{ route('admin.reservations.index') }}" class="nav-item">
        <i class="fas fa-calendar-check"></i> Réservations
    </a>
    <a href="{{ route('admin.clients.index') }}" class="nav-item">
        <i class="fas fa-users"></i> Clients
    </a>
    <a href="{{ route('admin.employes.index') }}" class="nav-item">
        <i class="fas fa-user-tie"></i> Employés
    </a>
    <a href="{{ route('admin.factures.index') }}" class="nav-item active">
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
        <h1><i class="fas fa-edit" style="color:#1E88E5"></i>
            Modifier Facture #{{ $facture->id_facture }}
        </h1>
        <div style="display:flex;align-items:center;gap:16px">
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

    <div class="card">
        <div class="info-box">
            <strong>Client :</strong>
            {{ $facture->reservation->client->prenom }}
            {{ $facture->reservation->client->nom }}<br>
            <strong>Chambre :</strong>
            N° {{ $facture->reservation->chambre->numero }}<br>
            <strong>Séjour :</strong>
            {{ $facture->reservation->date_arrivee->format('d/m/Y') }}
            → {{ $facture->reservation->date_depart->format('d/m/Y') }}
            ({{ $facture->reservation->nombre_nuits }} nuit(s))
        </div>

        <div class="montant-box">
            <div>
                <div class="label">Montant total</div>
                <div class="amount">
                    {{ number_format($facture->montant_total, 0, ',', ' ') }} FCFA
                </div>
            </div>
            <div>
                @if($facture->statut == 'payee')
                    <span style="background:rgba(255,255,255,0.2);padding:6px 14px;border-radius:20px;font-size:13px">
                        ✅ Payée
                    </span>
                @elseif($facture->statut == 'partielle')
                    <span style="background:rgba(255,255,255,0.2);padding:6px 14px;border-radius:20px;font-size:13px">
                        ⚠️ Partielle
                    </span>
                @else
                    <span style="background:rgba(255,255,255,0.2);padding:6px 14px;border-radius:20px;font-size:13px">
                        ❌ Non payée
                    </span>
                @endif
            </div>
        </div>

        <form method="POST"
              action="{{ route('admin.factures.update', $facture->id_facture) }}">
            @csrf
            @method('PUT')

            <div class="section-title">
                <i class="fas fa-credit-card"></i> Mettre à jour le paiement
            </div>

            <div class="form-group">
                <label>Statut de la facture</label>
                <select name="statut" id="statut-select"
                        onchange="togglePaiement(this.value)" required>
                    <option value="non_payee"
                        {{ $facture->statut == 'non_payee' ? 'selected' : '' }}>
                        Non payée
                    </option>
                    <option value="partielle"
                        {{ $facture->statut == 'partielle' ? 'selected' : '' }}>
                        Paiement partiel
                    </option>
                    <option value="payee"
                        {{ $facture->statut == 'payee' ? 'selected' : '' }}>
                        Payée
                    </option>
                </select>
                @error('statut')
                    <div class="error-msg">{{ $message }}</div>
                @enderror
            </div>

            <div class="paiement-section" id="paiement-section">
                <div class="form-group" style="margin-bottom:0">
                    <label>Mode de paiement</label>
                    <select name="mode_paiement">
                        <option value="especes">Espèces</option>
                        <option value="carte">Carte bancaire</option>
                        <option value="mobile_money">Mobile Money</option>
                        <option value="virement">Virement bancaire</option>
                        <option value="cheque">Chèque</option>
                    </select>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Enregistrer
                </button>
                <a href="{{ route('admin.factures.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Retour
                </a>
            </div>
        </form>
    </div>
</div>

<script>
function togglePaiement(val) {
    const section = document.getElementById('paiement-section');
    section.style.display = val === 'payee' ? 'block' : 'none';
}
togglePaiement(document.getElementById('statut-select').value);
</script>
</body>
</html>