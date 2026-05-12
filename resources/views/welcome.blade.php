<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Gestion des Soutenances | HOREB ACADEMY</title>
        
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,400&display=swap" rel="stylesheet">
        <!-- Tailwind CDN -->
        <script src="https://cdn.tailwindcss.com"></script>
        <script>
            tailwind.config = {
                darkMode: 'class',
                theme: {
                    extend: {
                        fontFamily: {
                            sans: ['Montserrat', 'sans-serif'],
                        }
                    }
                }
            }
        </script>
        <style>
            :root {
                --brand: #2D60FF;
                --brand-dark: #1E40AF;
            }
            
            body { 
                margin: 0;
                font-family: 'Montserrat', sans-serif;
                background-color: #020617;
            }

            .hero-section {
                /* 🔧 FIX: background-attachment: fixed cause des bugs sur iOS/Android */
                background-image: linear-gradient(to bottom, rgba(2, 6, 23, 0.6) 0%, rgba(2, 6, 23, 0.95) 100%), url('{{ asset('images/academic_success_bg.png') }}');
                background-size: cover;
                background-position: center;
                background-attachment: scroll; /* ✅ scroll au lieu de fixed */
                min-height: 100vh;
                min-height: 100dvh; /* ✅ dynamic viewport height pour mobile */
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: center;
                position: relative;
                /* 🔧 FIX: padding vertical généreux pour éviter que le footer chevauche le contenu */
                padding: 5rem 1.25rem 5rem;
                overflow: hidden;
                box-sizing: border-box;
            }

            .gradient-text {
                background: linear-gradient(135deg, #60A5FA 0%, #2D60FF 100%);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                background-clip: text;
            }

            .btn-premium {
                background: linear-gradient(135deg, var(--brand) 0%, var(--brand-dark) 100%);
                color: white;
                border-radius: 1.25rem;
                font-weight: 800;
                transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
                display: inline-flex;
                align-items: center;
                justify-content: center;
                box-shadow: 0 15px 30px rgba(45, 96, 255, 0.3);
                border: 1px solid rgba(255, 255, 255, 0.1);
                /* 🔧 FIX: largeur adaptée sur mobile */
                width: 100%;
                max-width: 320px;
                padding: 1rem 2rem;
                font-size: 1rem;
                text-decoration: none;
            }

            @media (min-width: 640px) {
                .btn-premium {
                    width: auto;
                    font-size: 1.125rem;
                    padding: 1rem 2.5rem;
                }
            }

            .btn-premium:hover {
                transform: translateY(-3px) scale(1.02);
                filter: brightness(1.1);
                box-shadow: 0 20px 40px rgba(45, 96, 255, 0.4);
            }

            @keyframes fadeIn {
                from { opacity: 0; transform: translateY(20px); }
                to { opacity: 1; transform: translateY(0); }
            }
            .animate-fade-in {
                animation: fadeIn 1s cubic-bezier(0.4, 0, 0.2, 1) forwards;
                opacity: 0;
            }

            @keyframes blob {
                0% { transform: translate(0px, 0px) scale(1); }
                33% { transform: translate(30px, -50px) scale(1.1); }
                66% { transform: translate(-20px, 20px) scale(0.9); }
                100% { transform: translate(0px, 0px) scale(1); }
            }
            .animate-blob {
                animation: blob 10s infinite alternate;
            }

            /* ─── Titre responsive ─────────────────────────────────── */
            .hero-title {
                font-size: clamp(2.2rem, 10vw, 5rem);
                font-weight: 900;
                line-height: 1.05;
                letter-spacing: -0.03em;
                margin-bottom: 1.5rem;
            }

            @media (min-width: 768px) {
                .hero-title {
                    font-size: clamp(4rem, 9vw, 7rem);
                }
            }

            @media (min-width: 1024px) {
                .hero-title {
                    font-size: clamp(5rem, 8vw, 8rem);
                }
            }

            /* ─── "HOREB ACADEMY" ne se coupe jamais ───────────────── */
            /* On utilise vw directement sur le span pour qu'il soit    */
            /* toujours à la bonne taille quel que soit l'écran.        */
            .hero-title .brand-name {
                display: block;
                white-space: nowrap;
                font-size: clamp(1rem, 7.5vw, 5rem); /* rétrécit jusqu'à tenir sur 320px */
            }

            @media (min-width: 768px) {
                .hero-title .brand-name {
                    font-size: clamp(4rem, 9vw, 7rem);
                }
            }

            @media (min-width: 1024px) {
                .hero-title .brand-name {
                    font-size: clamp(5rem, 8vw, 8rem);
                }
            }

            /* ─── Paragraphe responsive ────────────────────────────── */
            .hero-desc {
                font-size: clamp(0.95rem, 3.5vw, 1.35rem);
                color: rgba(203, 213, 225, 0.8);
                line-height: 1.7;
                font-weight: 500;
                margin-bottom: 2.5rem;
                max-width: 42rem;
                margin-left: auto;
                margin-right: auto;
            }

            /* ─── Badge ────────────────────────────────────────────── */
            .badge {
                display: inline-flex;
                align-items: center;
                padding: 0.4rem 1rem;
                border-radius: 9999px;
                background: rgba(59, 130, 246, 0.1);
                border: 1px solid rgba(59, 130, 246, 0.2);
                color: #60A5FA;
                font-size: clamp(0.6rem, 2vw, 0.75rem);
                font-weight: 900;
                text-transform: uppercase;
                letter-spacing: 0.25em;
                margin-bottom: 1.5rem;
                white-space: nowrap;
            }

            /* ─── Footer fixe en bas ───────────────────────────────── */
            .hero-footer {
                position: absolute;
                bottom: 1.5rem;
                left: 0;
                right: 0;
                text-align: center;
                font-size: clamp(0.55rem, 1.8vw, 0.625rem);
                font-weight: 900;
                text-transform: uppercase;
                letter-spacing: 0.4em;
                color: #475569;
                padding: 0 1rem;
            }
        </style>
        @vite(['resources/js/app.js'])
    </head>
    <body class="antialiased selection:bg-blue-500 selection:text-white">
        <div class="hero-section">
            <!-- Blobs décoratifs -->
            <div class="absolute top-[-10%] left-[-5%] w-72 h-72 md:w-96 md:h-96 bg-blue-600/20 rounded-full mix-blend-screen filter blur-[80px] md:blur-[100px] animate-blob pointer-events-none"></div>
            <div class="absolute bottom-[-10%] right-[-5%] w-72 h-72 md:w-96 md:h-96 bg-indigo-600/20 rounded-full mix-blend-screen filter blur-[80px] md:blur-[100px] animate-blob pointer-events-none" style="animation-delay: -5s"></div>

            <!-- Contenu principal -->
            <div class="relative z-10 text-center w-full max-w-5xl mx-auto">

                <!-- Badge -->
                <div class="animate-fade-in" style="animation-delay: 0s">
                    <span class="badge">Excellence Académique</span>
                </div>

                <!-- Titre -->
                <!-- 🔧 FIX: suppression de whitespace-nowrap qui cassait le layout mobile -->
                <h1 class="hero-title animate-fade-in" style="animation-delay: 0.1s">
                    <span class="gradient-text brand-name">HOREB ACADEMY</span>
                    <span class="text-white">Soutenances</span>
                </h1>

                <!-- Description -->
                <p class="hero-desc animate-fade-in" style="animation-delay: 0.2s">
                    L'élite technologique de l'Afrique se donne rendez-vous ici. Digitalisez vos mémoires, planifiez vos jurys et célébrez vos succès.
                </p>

                <!-- CTA -->
                <div class="flex flex-col sm:flex-row gap-4 justify-center items-center animate-fade-in" style="animation-delay: 0.3s">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="btn-premium">
                            Mon Espace Digital
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="btn-premium">
                            Se connecter
                        </a>
                    @endauth
                </div>
            </div>

            <!-- Footer -->
            <footer class="hero-footer">
                &copy; 2026 HOREB IP &bull; HOREB ACADEMY &bull; Excellence &amp; Innovation
            </footer>
        </div>
    </body>
</html>