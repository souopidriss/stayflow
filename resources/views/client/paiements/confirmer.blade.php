<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StayFlow — Confirmer Paiement</title>
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
            max-width: 500px;
        }
        .otp-banner {
            background: linear-gradient(135deg,
                {{ $otp->operateur == 'mtn' ? '#FFCC00, #FF8800' : '#FF6600, #FF3300' }});
            border-radius: 12px; padding: 24px;
            text-align: center; margin-bottom: 32px; color: white;
        }
        .otp-banner .operateur-name {
            font-size: 18px; font-weight: 700; margin-bottom: 8px;
        }
        .otp-banner .phone {
            font-size: 14px; opacity: 0.9; margin-bottom: 16px;
        }
        .otp-code-display {
            background: rgba(255,255,255,0.2);
            border-radius: 10px; padding: 16px;
            font-size: 36px; font-weight: 900;
            letter-spacing: 12px; color: white;
        }
        .otp-hint {
            font-size: 12px; opacity: 0.8; margin-top: 8px;
        }
        .timer {
            display: flex; align-items: center; justify-content: center;
            gap: 8px; margin: 16px 0;
            font-size: 14px; color: #888;
        }
        .timer #countdown {
            font-weight: 700; color: #e53935;
            font-size: 18px;
        }
        .otp-inputs {
            display: flex; gap: 12px; justify-content: center;
            margin-bottom: 24px;
        }
        .otp-input {
            width: 52px; height: 60px;
            border: 2px solid #e8e8e8; border-radius: 12px;
            font-size: 24px; font-weight: 700; text-align: center;
            outline: none; transition: border-color 0.2s;
        }
        .otp-input:focus { border-color: #29B6F6; }
        .hidden-input { display: none; }
        .error-msg {
            color: #e53e3e; font-size: 13px;
            text-align: center; margin-bottom: 16px;
            background: #fff5f5; padding: 10px;
            border-radius: 8px; border-left: 4px solid #e53e3e;
        }
        .btn-valider {
            width: 100%; padding: 16px;
            background: linear-gradient(135deg, #1a1a2e, #29B6F6);
            color: white; border: none; border-radius: 12px;
            font-size: 16px; font-weight: 700; cursor: pointer;
            display: flex; align-items: center;
            justify-content: center; gap: 10px;
        }
        .btn-valider:hover { opacity: 0.9; }
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
        .steps {
            display: flex; justify-content: center;
            gap: 8px; margin-bottom: 24px;
        }
        .step {
            width: 32px; height: 6px; border-radius: 3px;
            background: #e8e8e8;
        }
        .step.active { background: #29B6F6; }
        .step.done { background: #43a047; }
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
        <h1><i class="fas fa-shield-alt" style="color:#29B6F6"></i> Confirmation OTP</h1>
        <div style="display:flex;align-items:center;gap:16px">
            <a href="{{ route('client.paiements.index', $facture->id_facture) }}"
               class="btn btn-secondary">
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
        <div class="steps">
            <div class="step done"></div>
            <div class="step active"></div>
            <div class="step"></div>
        </div>

        <div class="otp-banner">
            <div class="operateur-name">
                {{ $otp->operateur == 'mtn' ? 'MTN Mobile Money' : 'Orange Money' }}
            </div>
            <div class="phone">
                Code envoyé au +237 {{ $otp->telephone }}
            </div>
            <div class="otp-code-display">
                {{ $otp->code_otp }}
            </div>
            <div class="otp-hint">
                Utilisez ce code pour confirmer votre paiement
            </div>
        </div>

        <div class="timer">
            <i class="fas fa-clock"></i>
            Code valide pendant <span id="countdown">05:00</span>
        </div>

        @if($errors->any())
            <div class="error-msg">{{ $errors->first() }}</div>
        @endif

        <form method="POST"
              action="{{ route('client.paiements.valider', $facture->id_facture) }}">
            @csrf

            <input type="hidden" name="code_otp" id="code_otp_hidden"/>

            <p style="text-align:center;font-size:14px;color:#555;margin-bottom:16px;font-weight:600">
                Entrez le code à 6 chiffres
            </p>

            <div class="otp-inputs">
                <input type="text" class="otp-input" maxlength="1" oninput="moveNext(this, 0)"/>
                <input type="text" class="otp-input" maxlength="1" oninput="moveNext(this, 1)"/>
                <input type="text" class="otp-input" maxlength="1" oninput="moveNext(this, 2)"/>
                <input type="text" class="otp-input" maxlength="1" oninput="moveNext(this, 3)"/>
                <input type="text" class="otp-input" maxlength="1" oninput="moveNext(this, 4)"/>
                <input type="text" class="otp-input" maxlength="1" oninput="moveNext(this, 5)"/>
            </div>

            <button type="submit" class="btn-valider" onclick="return assembleOtp()">
                <i class="fas fa-check-circle"></i>
                Confirmer le paiement de
                {{ number_format($facture->montant_total, 0, ',', ' ') }} FCFA
            </button>
        </form>
    </div>
</div>

<script>
const inputs = document.querySelectorAll('.otp-input');

function moveNext(input, index) {
    input.value = input.value.replace(/[^0-9]/g, '');
    if (input.value && index < 5) {
        inputs[index + 1].focus();
    }
    updateHidden();
}

function updateHidden() {
    let code = '';
    inputs.forEach(i => code += i.value);
    document.getElementById('code_otp_hidden').value = code;
}

function assembleOtp() {
    updateHidden();
    return true;
}

inputs.forEach((input, index) => {
    input.addEventListener('keydown', function(e) {
        if (e.key === 'Backspace' && !input.value && index > 0) {
            inputs[index - 1].focus();
        }
    });
});

// Countdown timer
let seconds = 300;
const countdown = document.getElementById('countdown');
const timer = setInterval(() => {
    seconds--;
    const m = Math.floor(seconds / 60).toString().padStart(2, '0');
    const s = (seconds % 60).toString().padStart(2, '0');
    countdown.textContent = m + ':' + s;
    if (seconds <= 0) {
        clearInterval(timer);
        countdown.textContent = 'Expiré';
        countdown.style.color = '#888';
    }
}, 1000);
</script>
</body>
</html>