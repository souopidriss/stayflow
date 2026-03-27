<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StayFlow — Nouvelle Évaluation</title>
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
        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%; padding: 12px 16px;
            border: 2px solid #e8e8e8; border-radius: 10px;
            font-size: 15px; outline: none; transition: border-color 0.3s;
            font-family: 'Segoe UI', sans-serif;
        }
        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus { border-color: #29B6F6; }
        .form-group textarea { resize: vertical; min-height: 100px; }
        .error-msg { color: #e53e3e; font-size: 12px; margin-top: 4px; }
        .form-actions { display: flex; gap: 12px; margin-top: 24px; }
        .star-rating {
            display: flex; gap: 8px; margin-top: 8px;
        }
        .star-rating input { display: none; }
        .star-rating label {
            font-size: 32px; color: #ddd;
            cursor: pointer; transition: color 0.2s;
        }
        .star-rating input:checked ~ label,
        .star-rating label:hover,
        .star-rating label:hover ~ label { color: #fb8c00; }
        .star-rating { flex-direction: row-reverse; }
        .star-rating label:hover,
        .star-rating label:hover ~ label { color: #fb8c00; }
        .star-rating input:checked ~ label { color: #fb8c00; }
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
    <a href="{{ route('admin.factures.index') }}" class="nav-item">
        <i class="fas fa-file-invoice"></i> Factures
    </a>
    <a href="{{ route('admin.services.index') }}" class="nav-item">
        <i class="fas fa-concierge-bell"></i> Services
    </a>
    <span class="nav-section">Rapports</span>
    <a href="{{ route('admin.evaluations.index') }}" class="nav-item active">
        <i class="fas fa-star"></i> Évaluations
    </a>
</div>

<div class="main">
    <div class="topbar">
        <h1><i class="fas fa-star" style="color:#fb8c00"></i> Nouvelle Évaluation</h1>
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
        <form method="POST" action="{{ route('admin.evaluations.store') }}">
            @csrf

            <div class="form-group">
                <label>Client</label>
                <select name="id_client" required>
                    <option value="">-- Sélectionner un client --</option>
                    @foreach($clients as $client)
                        <option value="{{ $client->id_client }}"
                            {{ old('id_client') == $client->id_client ? 'selected' : '' }}>
                            {{ $client->prenom }} {{ $client->nom }}
                        </option>
                    @endforeach
                </select>
                @error('id_client')<div class="error-msg">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                <label>Employé évalué</label>
                <select name="id_employe" required>
                    <option value="">-- Sélectionner un employé --</option>
                    @foreach($employes as $employe)
                        <option value="{{ $employe->id_employe }}"
                            {{ old('id_employe') == $employe->id_employe ? 'selected' : '' }}>
                            {{ $employe->prenom }} {{ $employe->nom }}
                            — {{ $employe->poste }}
                        </option>
                    @endforeach
                </select>
                @error('id_employe')<div class="error-msg">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                <label>Note</label>
                <select name="note" required>
                    <option value="">-- Sélectionner une note --</option>
                    <option value="1" {{ old('note') == 1 ? 'selected' : '' }}>★ — Très mauvais</option>
                    <option value="2" {{ old('note') == 2 ? 'selected' : '' }}>★★ — Mauvais</option>
                    <option value="3" {{ old('note') == 3 ? 'selected' : '' }}>★★★ — Moyen</option>
                    <option value="4" {{ old('note') == 4 ? 'selected' : '' }}>★★★★ — Bien</option>
                    <option value="5" {{ old('note') == 5 ? 'selected' : '' }}>★★★★★ — Excellent</option>
                </select>
                @error('note')<div class="error-msg">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                <label>Commentaire</label>
                <textarea name="commentaire"
                          placeholder="Commentaire sur le service reçu...">{{ old('commentaire') }}</textarea>
                @error('commentaire')<div class="error-msg">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                <label>Date</label>
                <input type="date" name="date"
                       value="{{ old('date', date('Y-m-d')) }}" required/>
                @error('date')<div class="error-msg">{{ $message }}</div>@enderror
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Enregistrer
                </button>
                <a href="{{ route('admin.evaluations.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Retour
                </a>
            </div>
        </form>
    </div>
</div>
</body>
</html>