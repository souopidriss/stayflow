<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StayFlow — Inscription</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, #0A1628 0%, #1a2f4e 50%, #0d2137 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .register-container {
            background: white;
            border-radius: 20px;
            padding: 48px 40px;
            width: 100%;
            max-width: 460px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        }
        .logo {
            text-align: center;
            margin-bottom: 32px;
        }
        .logo h1 {
            font-size: 32px;
            font-weight: 700;
            color: #0A1628;
        }
        .logo h1 span { color: #29B6F6; }
        .logo p {
            color: #888;
            font-size: 13px;
            letter-spacing: 3px;
            margin-top: 4px;
        }
        .form-group {
            margin-bottom: 18px;
        }
        .form-group label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: #555;
            margin-bottom: 8px;
        }
        .form-group input {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid #e8e8e8;
            border-radius: 10px;
            font-size: 15px;
            transition: border-color 0.3s;
            outline: none;
        }
        .form-group input:focus { border-color: #29B6F6; }
        .input-icon { position: relative; }
        .input-icon i {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #aaa;
        }
        .btn-register {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #1E88E5, #29B6F6);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: opacity 0.3s;
            margin-top: 8px;
        }
        .btn-register:hover { opacity: 0.9; }
        .error-msg {
            background: #fff5f5;
            color: #e53e3e;
            padding: 12px 16px;
            border-radius: 8px;
            font-size: 13px;
            margin-bottom: 20px;
            border-left: 4px solid #e53e3e;
        }
        .login-link {
            text-align: center;
            margin-top: 24px;
            font-size: 14px;
            color: #888;
        }
        .login-link a {
            color: #29B6F6;
            text-decoration: none;
            font-weight: 600;
        }
    </style>
</head>
<body>
    <div class="register-container">
        <div class="logo">
            <h1>Stay<span>Flow</span></h1>
            <p>CRÉER UN COMPTE</p>
        </div>

        @if($errors->any())
            <div class="error-msg">{{ $errors->first() }}</div>
        @endif

        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="form-group">
                <label>Nom complet</label>
                <div class="input-icon">
                    <input type="text" name="name" value="{{ old('name') }}"
                           placeholder="Jean Dupont" required autofocus/>
                    <i class="fas fa-user"></i>
                </div>
            </div>

            <div class="form-group">
                <label>Adresse email</label>
                <div class="input-icon">
                    <input type="email" name="email" value="{{ old('email') }}"
                           placeholder="exemple@email.com" required/>
                    <i class="fas fa-envelope"></i>
                </div>
            </div>

            <div class="form-group">
                <label>Mot de passe</label>
                <div class="input-icon">
                    <input type="password" name="password"
                           placeholder="Minimum 8 caractères" required/>
                    <i class="fas fa-lock"></i>
                </div>
            </div>

            <div class="form-group">
                <label>Confirmer le mot de passe</label>
                <div class="input-icon">
                    <input type="password" name="password_confirmation"
                           placeholder="Répétez le mot de passe" required/>
                    <i class="fas fa-lock"></i>
                </div>
            </div>

            <button type="submit" class="btn-register">
                <i class="fas fa-user-plus"></i> Créer mon compte
            </button>
        </form>

        <div class="login-link">
            Déjà un compte ?
            <a href="{{ route('login') }}">Se connecter</a>
        </div>
    </div>
</body>
</html>