<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StayFlow — Connexion</title>
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
        }
        .login-container {
            background: white;
            border-radius: 20px;
            padding: 48px 40px;
            width: 100%;
            max-width: 420px;
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
        .logo h1 span {
            color: #29B6F6;
        }
        .logo p {
            color: #888;
            font-size: 13px;
            letter-spacing: 3px;
            margin-top: 4px;
        }
        .form-group {
            margin-bottom: 20px;
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
        .form-group input:focus {
            border-color: #29B6F6;
        }
        .input-icon {
            position: relative;
        }
        .input-icon i {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #aaa;
        }
        .btn-login {
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
        .btn-login:hover { opacity: 0.9; }
        .error-msg {
            background: #fff5f5;
            color: #e53e3e;
            padding: 12px 16px;
            border-radius: 8px;
            font-size: 13px;
            margin-bottom: 20px;
            border-left: 4px solid #e53e3e;
        }
        .success-msg {
            background: #f0fff4;
            color: #38a169;
            padding: 12px 16px;
            border-radius: 8px;
            font-size: 13px;
            margin-bottom: 20px;
            border-left: 4px solid #38a169;
        }
        .register-link {
            text-align: center;
            margin-top: 24px;
            font-size: 14px;
            color: #888;
        }
        .register-link a {
            color: #29B6F6;
            text-decoration: none;
            font-weight: 600;
        }
        .remember {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 20px;
            font-size: 13px;
            color: #555;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="logo">
            <h1>Stay<span>Flow</span></h1>
            <p>HÔTEL CONNECTÉ · CAMPOST</p>
        </div>

        @if(session('success'))
            <div class="success-msg">{{ session('success') }}</div>
        @endif

        @if($errors->any())
            <div class="error-msg">{{ $errors->first() }}</div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="form-group">
                <label>Adresse email</label>
                <div class="input-icon">
                    <input type="email" name="email" value="{{ old('email') }}"
                           placeholder="exemple@stayflow.cm" required autofocus/>
                    <i class="fas fa-envelope"></i>
                </div>
            </div>

            <div class="form-group">
                <label>Mot de passe</label>
                <div class="input-icon">
                    <input type="password" name="password"
                           placeholder="••••••••" required/>
                    <i class="fas fa-lock"></i>
                </div>
            </div>

            <div class="remember">
                <input type="checkbox" name="remember" id="remember"/>
                <label for="remember">Se souvenir de moi</label>
            </div>

            <button type="submit" class="btn-login">
                <i class="fas fa-sign-in-alt"></i> Se connecter
            </button>
        </form>

        <div class="register-link">
            Pas encore de compte ?
            <a href="{{ route('register') }}">S'inscrire</a>
        </div>
    </div>
</body>
</html>