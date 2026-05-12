<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'GES-SOUTENANCE') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,400&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Montserrat', 'sans-serif'] },
                }
            }
        }
    </script>

    <style>
        :root {
            --brand:      #2D60FF;
            --brand-dark: #1B4FE0;
            --navy:       #1B254B;
            --bg:         #F4F7FE;
            --border:     #E0E5F2;
            --muted:      #A3AED0;
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            font-family: 'Montserrat', sans-serif;
            background: var(--bg);
            color: var(--navy);
        }

        /* Layout split */
        .auth-wrapper {
            display: grid;
            grid-template-columns: 1fr 1fr;
            min-height: 100vh;
        }

        @media (max-width: 768px) {
            .auth-wrapper { grid-template-columns: 1fr; }
            .auth-panel   { display: none; }
        }

        /* Panneau gauche — image */
        .auth-panel {
            position: relative;
            overflow: hidden;
            background: var(--navy);
        }

        .auth-panel img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            opacity: 0.35;
        }

        .auth-panel-overlay {
            position: absolute;
            inset: 0;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 2.5rem;
        }

        .auth-panel-logo {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .logo-icon {
            width: 38px; height: 38px;
            background: var(--brand);
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }

        .auth-panel-quote {
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 12px;
            padding: 1.5rem;
            backdrop-filter: blur(8px);
        }

        /* Panneau droit — formulaire */
        .auth-form-side {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 3rem 2rem;
            background: #fff;
            overflow-y: auto;
        }

        .auth-form-inner {
            width: 100%;
            max-width: 400px;
        }

        /* Inputs propres */
        .auth-input {
            width: 100%;
            background: var(--bg);
            border: 1.5px solid var(--border);
            border-radius: 8px;
            color: var(--navy);
            padding: 0.8rem 1rem 0.8rem 2.8rem;
            font-family: 'Montserrat', sans-serif;
            font-size: 0.875rem;
            font-weight: 500;
            transition: border-color 0.18s ease, box-shadow 0.18s ease;
            outline: none;
        }

        .auth-input:focus {
            border-color: var(--brand);
            box-shadow: 0 0 0 3px rgba(45,96,255,0.1);
            background: #fff;
        }

        .auth-input::placeholder { color: var(--muted); font-weight: 400; }

        /* Bouton */
        .btn-auth {
            width: 100%;
            background: var(--brand);
            color: #fff;
            font-family: 'Montserrat', sans-serif;
            font-weight: 700;
            font-size: 0.8rem;
            letter-spacing: 0.04em;
            text-transform: uppercase;
            padding: 0.9rem;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            transition: background 0.18s ease, letter-spacing 0.18s ease;
        }

        .btn-auth:hover   { background: var(--brand-dark); letter-spacing: 0.07em; }
        .btn-auth:active  { filter: brightness(0.92); }

        /* Label */
        .auth-label {
            display: block;
            font-size: 0.75rem;
            font-weight: 700;
            color: var(--navy);
            text-transform: uppercase;
            letter-spacing: 0.08em;
            margin-bottom: 0.5rem;
        }

        /* Lien */
        .auth-link {
            color: var(--brand);
            font-size: 0.75rem;
            font-weight: 600;
            text-decoration: none;
            transition: color 0.15s;
        }
        .auth-link:hover { color: var(--brand-dark); }

        /* Input icon wrapper */
        .input-wrap { position: relative; }
        .input-icon {
            position: absolute;
            left: 0.85rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--muted);
            pointer-events: none;
            transition: color 0.18s;
        }
        .input-wrap:focus-within .input-icon { color: var(--brand); }
    </style>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
<div class="auth-wrapper">

    <!-- Panneau gauche -->
    <div class="auth-panel">
        <img src="{{ asset('images/students_african.png') }}" alt="">
        <div class="auth-panel-overlay">
            <div class="auth-panel-logo">
                <div class="logo-icon">
                    <svg width="20" height="20" fill="none" stroke="white" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0112 20.055a11.952 11.952 0 01-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/>
                    </svg>
                </div>
                <div>
                    <div style="font-weight:900;font-size:0.9rem;color:#fff;letter-spacing:-0.02em;text-transform:uppercase;">GES-SOUTENANCE</div>
                    <div style="font-size:0.6rem;font-weight:700;color:rgba(255,255,255,0.4);text-transform:uppercase;letter-spacing:0.15em;">HOREB ACADEMY</div>
                </div>
            </div>

            <div class="auth-panel-quote">
                <p style="color:rgba(255,255,255,0.8);font-size:0.95rem;font-weight:600;line-height:1.6;margin:0 0 1rem;">
                    "La réussite de chaque soutenance commence par une organisation sans faille."
                </p>
                <div style="display:flex;align-items:center;gap:0.6rem;">
                    <div style="width:32px;height:32px;border-radius:50%;background:var(--brand);display:flex;align-items:center;justify-content:center;font-size:0.75rem;font-weight:900;color:#fff;">HA</div>
                    <div>
                        <div style="color:#fff;font-size:0.75rem;font-weight:700;">HOREB ACADEMY</div>
                        <div style="color:rgba(255,255,255,0.4);font-size:0.65rem;font-weight:600;text-transform:uppercase;letter-spacing:0.1em;">Gestion académique</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Panneau droit -->
    <div class="auth-form-side">
        <div class="auth-form-inner">
            <a href="{{ url('/') }}" style="display:inline-flex;align-items:center;gap:0.4rem;font-size:0.72rem;font-weight:700;color:var(--muted);text-decoration:none;text-transform:uppercase;letter-spacing:0.08em;margin-bottom:2rem;transition:color 0.15s;" onmouseover="this.style.color='var(--brand)'" onmouseout="this.style.color='var(--muted)'">
                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                Retour à l'accueil
            </a>
            {{ $slot }}
        </div>
        <p style="margin-top:2rem;font-size:0.7rem;font-weight:600;color:var(--muted);text-align:center;">
            &copy; {{ date('Y') }} HOREB IP — Tous droits réservés
        </p>
    </div>

</div>
</body>
</html>
