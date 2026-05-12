<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>GES-SOUTENANCE — HOREB ACADEMY</title>

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
        body { margin: 0; font-family: 'Montserrat', sans-serif; background: #fff; color: var(--navy); }

        /* ── Navbar ── */
        .navbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 2rem;
            height: 72px;
            border-bottom: 1px solid var(--border);
            background: #fff;
            position: sticky;
            top: 0;
            z-index: 50;
        }

        .logo-icon {
            width: 36px; height: 36px;
            background: var(--brand);
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            box-shadow: 0 4px 14px rgba(45,96,255,0.35);
            flex-shrink: 0;
        }

        .btn-nav {
            background: var(--brand);
            color: #fff;
            font-weight: 700;
            font-size: 0.75rem;
            padding: 0.65rem 1.4rem;
            border-radius: 6px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            letter-spacing: 0.04em;
            text-transform: uppercase;
            transition: background 0.18s ease, letter-spacing 0.18s ease;
        }
        .btn-nav:hover { background: var(--brand-dark); letter-spacing: 0.07em; }
        .btn-nav:active { filter: brightness(0.92); }

        /* ── Hero ── */
        .hero {
            display: grid;
            grid-template-columns: 1fr 1fr;
            min-height: calc(100vh - 72px);
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 2rem;
            gap: 3rem;
            align-items: center;
        }

        @media (max-width: 900px) {
            .hero { grid-template-columns: 1fr; padding: 3rem 1.5rem; text-align: center; }
            .hero-image-col { display: none; }
            .hero-badges { justify-content: center; }
            .hero-cta { justify-content: center; }
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: rgba(45,96,255,0.07);
            border: 1px solid rgba(45,96,255,0.15);
            color: var(--brand);
            font-size: 0.7rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.15em;
            padding: 0.4rem 1rem;
            border-radius: 999px;
            margin-bottom: 1.5rem;
        }

        .hero-title {
            font-size: clamp(2.2rem, 4.5vw, 3.8rem);
            font-weight: 900;
            line-height: 1.08;
            letter-spacing: -0.03em;
            color: var(--navy);
            margin: 0 0 1.25rem;
        }

        .hero-title .accent {
            color: var(--brand);
            position: relative;
        }

        .hero-desc {
            font-size: 1rem;
            color: var(--muted);
            line-height: 1.75;
            font-weight: 500;
            margin: 0 0 2.5rem;
            max-width: 38rem;
        }

        .hero-cta { display: flex; gap: 1rem; flex-wrap: wrap; }

        .btn-primary {
            background: var(--brand);
            color: #fff;
            font-weight: 700;
            font-size: 0.8rem;
            padding: 0.9rem 2rem;
            border-radius: 6px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            letter-spacing: 0.04em;
            text-transform: uppercase;
            transition: background 0.18s ease, letter-spacing 0.18s ease;
        }
        .btn-primary:hover { background: var(--brand-dark); letter-spacing: 0.07em; }
        .btn-primary:active { filter: brightness(0.92); }

        /* ── Image col ── */
        .hero-image-col {
            position: relative;
            height: 560px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .image-blob {
            position: absolute;
            inset: 0;
            background: var(--bg);
            border-radius: 60% 40% 55% 45% / 50% 55% 45% 55%;
        }

        .hero-img {
            position: relative;
            z-index: 1;
            width: 90%;
            height: 90%;
            object-fit: cover;
            border-radius: 2rem;
            box-shadow: 0 30px 80px rgba(27,37,75,0.15);
        }

        /* Floating cards */
        .float-card {
            position: absolute;
            z-index: 2;
            background: #fff;
            border-radius: 1rem;
            padding: 0.75rem 1.1rem;
            box-shadow: 0 10px 40px rgba(27,37,75,0.12);
            display: flex;
            align-items: center;
            gap: 0.65rem;
            font-size: 0.78rem;
            font-weight: 700;
            color: var(--navy);
            white-space: nowrap;
            border: 1px solid var(--border);
        }

        .float-card-icon {
            width: 32px; height: 32px;
            border-radius: 0.5rem;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }

        /* ── Stats band ── */
        .stats-band {
            background: var(--navy);
            padding: 3rem 2rem;
        }

        .stats-inner {
            max-width: 900px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 2rem;
            text-align: center;
        }

        @media (max-width: 640px) {
            .stats-inner { grid-template-columns: 1fr; }
        }

        .stat-val {
            font-size: 2.5rem;
            font-weight: 900;
            color: #fff;
            line-height: 1;
        }

        .stat-label {
            font-size: 0.75rem;
            font-weight: 600;
            color: var(--muted);
            text-transform: uppercase;
            letter-spacing: 0.1em;
            margin-top: 0.5rem;
        }

        /* ── Features ── */
        .features {
            padding: 6rem 2rem;
            max-width: 1100px;
            margin: 0 auto;
        }

        .section-label {
            font-size: 0.7rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.2em;
            color: var(--brand);
            margin-bottom: 0.75rem;
        }

        .section-title {
            font-size: clamp(1.6rem, 3vw, 2.4rem);
            font-weight: 900;
            color: var(--navy);
            letter-spacing: -0.02em;
            margin: 0 0 3.5rem;
            line-height: 1.15;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1.5rem;
        }

        @media (max-width: 800px) {
            .features-grid { grid-template-columns: 1fr; }
        }

        .feat-card {
            background: var(--bg);
            border-radius: 1.25rem;
            padding: 2rem;
            border: 1px solid var(--border);
            transition: border-color 0.25s, box-shadow 0.25s, transform 0.25s;
        }

        .feat-card:hover {
            border-color: var(--brand);
            box-shadow: 0 12px 36px rgba(45,96,255,0.1);
            transform: translateY(-3px);
        }

        .feat-icon {
            width: 44px; height: 44px;
            border-radius: 0.875rem;
            display: flex; align-items: center; justify-content: center;
            margin-bottom: 1.25rem;
        }

        .feat-role {
            font-size: 0.65rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.15em;
            margin-bottom: 0.6rem;
        }

        .feat-title {
            font-size: 1rem;
            font-weight: 800;
            color: var(--navy);
            margin: 0 0 0.6rem;
            line-height: 1.3;
        }

        .feat-desc {
            font-size: 0.85rem;
            color: var(--muted);
            line-height: 1.65;
            font-weight: 500;
            margin: 0;
        }

        /* ── Footer ── */
        footer {
            border-top: 1px solid var(--border);
            padding: 1.75rem 2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 1rem;
            background: #fff;
        }

        footer span {
            font-size: 0.75rem;
            font-weight: 600;
            color: var(--muted);
        }

        .status-dot {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            font-size: 0.75rem;
            font-weight: 600;
            color: var(--muted);
        }

        /* Animations */
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(20px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .fade-up { animation: fadeUp 0.65s ease forwards; }
        .delay-1 { animation-delay: 0.1s; opacity: 0; }
        .delay-2 { animation-delay: 0.2s; opacity: 0; }
        .delay-3 { animation-delay: 0.3s; opacity: 0; }
        .delay-4 { animation-delay: 0.4s; opacity: 0; }
    </style>

    @vite(['resources/js/app.js'])
</head>
<body>

    <!-- ═══ NAVBAR ═══ -->
    <nav class="navbar">
        <div style="display:flex; align-items:center; gap:0.75rem;">
            <div class="logo-icon">
                <svg width="18" height="18" fill="none" stroke="white" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0112 20.055a11.952 11.952 0 01-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/>
                </svg>
            </div>
            <div>
                <div style="font-weight:900; font-size:0.875rem; color:var(--navy); text-transform:uppercase; letter-spacing:-0.02em; line-height:1;">GES-SOUTENANCE</div>
                <div style="font-size:0.6rem; font-weight:700; color:var(--muted); text-transform:uppercase; letter-spacing:0.15em; margin-top:2px;">HOREB ACADEMY</div>
            </div>
        </div>

        @auth
            <a href="{{ url('/dashboard') }}" class="btn-nav">
                Mon espace
                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
            </a>
        @else
            <a href="{{ route('login') }}" class="btn-nav">
                Se connecter
                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
            </a>
        @endauth
    </nav>

    <!-- ═══ HERO ═══ -->
    <section style="background:#fff;">
        <div class="hero">

            <!-- Texte -->
            <div>
                <div class="hero-badge fade-up">
                    <span style="width:6px;height:6px;border-radius:50%;background:var(--brand);"></span>
                    Plateforme académique — 2025-2026
                </div>

                <h1 class="hero-title fade-up delay-1">
                    La gestion des<br>
                    soutenances,<br>
                    <span class="accent">enfin simple.</span>
                </h1>

                <p class="hero-desc fade-up delay-2">
                    Dépôt de mémoire, constitution du jury, planification et notation — tout ce dont votre institution a besoin, centralisé en une seule plateforme.
                </p>

                <div class="hero-cta fade-up delay-3">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="btn-primary">
                            Accéder au tableau de bord
                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="btn-primary">
                            Se connecter
                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                        </a>
                    @endauth
                </div>
            </div>

            <!-- Image -->
            <div class="hero-image-col fade-up delay-2">
                <div class="image-blob"></div>
                <img src="{{ asset('images/students_african.png') }}" alt="Étudiants" class="hero-img">

                <!-- Card flottante haut-gauche -->
                <div class="float-card" style="top: 10%; left: -2%;">
                    <div class="float-card-icon" style="background:rgba(45,96,255,0.1);">
                        <svg width="16" height="16" fill="none" stroke="#2D60FF" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    </div>
                    <div>
                        <div style="font-size:0.65rem; color:var(--muted); font-weight:600;">Mémoire déposé</div>
                        <div>Validé ✓</div>
                    </div>
                </div>

                <!-- Card flottante bas-droite -->
                <div class="float-card" style="bottom: 12%; right: -4%;">
                    <div class="float-card-icon" style="background:rgba(16,185,129,0.1);">
                        <svg width="16" height="16" fill="none" stroke="#10B981" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
                    </div>
                    <div>
                        <div style="font-size:0.65rem; color:var(--muted); font-weight:600;">Note finale</div>
                        <div>16,5 / 20</div>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <!-- ═══ STATS ═══ -->
    <div class="stats-band">
        <div class="stats-inner">
            <div>
                <div class="stat-val">3</div>
                <div class="stat-label">Profils utilisateurs</div>
            </div>
            <div>
                <div class="stat-val">100%</div>
                <div class="stat-label">Processus numérisé</div>
            </div>
            <div>
                <div class="stat-val">0</div>
                <div class="stat-label">Document papier</div>
            </div>
        </div>
    </div>

    <!-- ═══ FEATURES ═══ -->
    <section class="features">
        <div class="section-label">Ce que la plateforme couvre</div>
        <h2 class="section-title">Un espace dédié<br>pour chaque acteur.</h2>

        <div class="features-grid">

            <div class="feat-card">
                <div class="feat-icon" style="background:rgba(45,96,255,0.08);">
                    <svg width="22" height="22" fill="none" stroke="#2D60FF" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                    </svg>
                </div>
                <div class="feat-role" style="color:#2D60FF;">Étudiant</div>
                <h3 class="feat-title">Dépôt & suivi du mémoire</h3>
                <p class="feat-desc">Soumettez votre fichier, suivez son statut de validation et consultez les détails de votre soutenance en temps réel.</p>
            </div>

            <div class="feat-card">
                <div class="feat-icon" style="background:rgba(124,58,237,0.08);">
                    <svg width="22" height="22" fill="none" stroke="#7C3AED" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                <div class="feat-role" style="color:#7C3AED;">Administration</div>
                <h3 class="feat-title">Planification des jurys</h3>
                <p class="feat-desc">Créez les soutenances, assignez les membres du jury, gérez les disponibilités et envoyez les convocations automatiquement.</p>
            </div>

            <div class="feat-card">
                <div class="feat-icon" style="background:rgba(16,185,129,0.08);">
                    <svg width="22" height="22" fill="none" stroke="#10B981" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                    </svg>
                </div>
                <div class="feat-role" style="color:#10B981;">Jury</div>
                <h3 class="feat-title">Notation & procès-verbaux</h3>
                <p class="feat-desc">Saisissez les notes par critère, validez les résultats et accédez aux procès-verbaux générés automatiquement en PDF.</p>
            </div>

        </div>
    </section>

    <!-- ═══ FOOTER ═══ -->
    <footer>
        <span>&copy; {{ date('Y') }} HOREB IP — Tous droits réservés</span>
        <div class="status-dot">
            <span style="width:8px;height:8px;border-radius:50%;background:#10B981;display:inline-block;"></span>
            Système opérationnel
        </div>
    </footer>

</body>
</html>
