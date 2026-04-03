<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StayFlow — Paiement</title>
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
        .btn-secondary { background: #f5f5f5; color: #555; }
        .card {
            background: white; border-radius: 16px;
            padding: 32px; box-shadow: 0 2px 8px rgba(0,0,0,0.06);
            max-width: 600px;
        }
        .montant-banner {
            background: linear-gradient(135deg, #1a1a2e, #0F4C75);
            border-radius: 12px; padding: 24px;
            color: white; text-align: center; margin-bottom: 32px;
        }
        .montant-banner .label { font-size: 14px; opacity: 0.8; }
        .montant-banner .amount { font-size: 40px; font-weight: 700; color: #29B6F6; margin: 8px 0; }
        .montant-banner .info { font-size: 13px; opacity: 0.7; }
        .operateurs-grid {
            display: grid; grid-template-columns: 1fr 1fr; gap: 16px;
            margin-bottom: 24px;
        }
        .operateur-btn {
            border: 3px solid #e8e8e8; border-radius: 16px;
            padding: 24px; text-align: center; cursor: pointer;
            transition: all 0.2s; position: relative;
        }
        .operateur-btn:hover { border-color: #29B6F6; transform: translateY(-2px); }
        .operateur-btn.selected { border-color: #29B6F6; background: #e3f2fd; }
        .operateur-btn input { display: none; }
        .operateur-logo {
            width: 64px; height: 64px; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 12px; font-size: 24px; font-weight: 900;
            color: white;
        }
        .mtn-logo { background: #FFCC00; color: #333; }
        .orange-logo { background: #FF6600; }
        .operateur-name { font-size: 16px; font-weight: 700; color: #1a1a2e; }
        .operateur-desc { font-size: 12px; color: #888; margin-top: 4px; }
        .check-icon {
            position: absolute; top: 12px; right: 12px;
            width: 24px; height: 24px; border-radius: 50%;
            background: #29B6F6; color: white;
            display: none; align-items: center; justify-content: center;
            font-size: 12px;
        }
        .operateur-btn.selected .check-icon { display: flex; }
        .form-group { margin-bottom: 20px; }
        .form-group label {
            display: block; font-size: 13px;
            font-weight: 600; color: #555; margin-bottom: 8px;
        }
        .phone-input {
            display: flex; gap: 0; border: 2px solid #e8e8e8;
            border-radius: 10px; overflow: hidden;
        }
        .phone-prefix {
            padding: 12px 16px; background: #f8f9fa;
            font-weight: 600; color: #555; font-size: 15px;
            border-right: 2px solid #e8e8e8;
        }
        .phone-input input {
            flex: 1; padding: 12px 16px; border: none;
            font-size: 15px; outline: none;
        }
        .phone-input:focus-within { border-color: #29B6F6; }
        .error-msg { color: #e53e3e; font-size: 12px; margin-top: 4px; }
        .btn-payer {
            width: 100%; padding: 16px;
            background: linear-gradient(135deg, #1a1a2e, #29B6F6);
            color: white; border: none; border-radius: 12px;
            font-size: 16px; font-weight: 700; cursor: pointer;
            display: flex; align-items: center; justify-content: center; gap: 10px;
            transition: opacity 0.2s;
        }
        .btn-payer:hover { opacity: 0.9; }
        .securite {
            display: flex; align-items: center; gap: 8px;
            color: #888; font-size: 12px; margin-top: 16px;
            justify-content: center;
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
    <a href="{{ route('client.factures.index') }}" class="nav-item active">
        <i class="fas fa-file-invoice"></i> Mes factures
    </a>
    <span class="nav-section">Hôtel</span>
    <a href="{{ route('client.chambres.index') }}" class="nav-item">
        <i class="fas fa-bed"></i> Nos chambres
    </a>
</div>

<div class="main">
    <div class="topbar">
        <h1><i class="fas fa-mobile-alt" style="color:#29B6F6"></i> Paiement Mobile Money</h1>
        <div style="display:flex;align-items:center;gap:16px">
            <a href="{{ route('client.factures.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Retour
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

    <div class="card">
        <div class="montant-banner">
            <div class="label">Montant à payer</div>
            <div class="amount">
                {{ number_format($facture->montant_total, 0, ',', ' ') }} FCFA
            </div>
            <div class="info">
                Chambre {{ $facture->reservation->chambre->numero }} —
                {{ $facture->reservation->nombre_nuits }} nuit(s)
            </div>
        </div>

        <form method="POST"
              action="{{ route('client.paiements.initier', $facture->id_facture) }}">
            @csrf

            <p style="font-size:14px;font-weight:600;color:#1a1a2e;margin-bottom:16px">
                Choisir votre opérateur
            </p>

            <div class="operateurs-grid">
                <label class="operateur-btn" onclick="selectOp(this)">
                    <input type="radio" name="operateur" value="mtn"/>
                    <div class="check-icon"><i class="fas fa-check"></i></div>
                    <div class="operateur-logo mtn-logo">MTN</div>
                    <div class="operateur-name">MTN Mobile Money</div>
                    <div class="operateur-desc">Paiement via MTN MoMo</div>
                </label>

                <label class="operateur-btn" onclick="selectOp(this)">
                    <input type="radio" name="operateur" value="orange"/>
                    <div class="check-icon"><i class="fas fa-check"></i></div>
                    <div class="operateur-logo orange-logo">
                        <i class="fas fa-circle"></i>
                    </div>
                    <div class="operateur-name">Orange Money</div>
                    <div class="operateur-desc">Paiement via Orange Money</div>
                </label>
            </div>
            @error('operateur')
                <div class="error-msg" style="margin-bottom:16px">{{ $message }}</div>
            @enderror

            <div class="form-group">
                <label>Numéro de téléphone</label>
               <div class="phone-input">
    <span class="phone-prefix">+237</span>
    <input type="text" name="telephone"
           placeholder="690000000"
           value="{{ old('telephone') }}"
           maxlength="9"
           pattern="[0-9]{9}"
           oninput="this.value=this.value.replace(/[^0-9]/g,'')"/>
</div>
                @error('telephone')
                    <div class="error-msg">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn-payer">
                <i class="fas fa-lock"></i>
                Recevoir le code de confirmation
            </button>

            <div class="securite">
                <i class="fas fa-shield-alt" style="color:#43a047"></i>
                Paiement sécurisé — Vos données sont protégées
            </div>
        </form>
    </div>
</div>

<script>
function selectOp(label) {
    document.querySelectorAll('.operateur-btn').forEach(b => b.classList.remove('selected'));
    label.classList.add('selected');
    label.querySelector('input').checked = true;
}
</script>
</body>
</html>