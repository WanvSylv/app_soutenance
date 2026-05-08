<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Gestion des Soutenances | HOREB ACADEMIC</title>
        
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;700;800;900&display=swap" rel="stylesheet">

        <!-- Tailwind CDN -->
        <script src="https://cdn.tailwindcss.com"></script>
        <script>
            tailwind.config = {
                darkMode: 'class',
                theme: {
                    extend: {
                        fontFamily: {
                            sans: ['Outfit', 'sans-serif'],
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
                font-family: 'Outfit', sans-serif;
                background-color: #020617;
            }

            .hero-section {
                background-image: linear-gradient(to bottom, rgba(2, 6, 23, 0.6) 0%, rgba(2, 6, 23, 0.95) 100%), url('{{ asset('images/students_african.png') }}');
                background-size: cover;
                background-position: center;
                background-attachment: fixed;
                min-height: 100vh;
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: center;
                position: relative;
                padding: 2rem;
                overflow: hidden;
            }

            .gradient-text {
                background: linear-gradient(135deg, #60A5FA 0%, #2D60FF 100%);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
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
        </style>

        @vite(['resources/js/app.js'])
    </head>
    <body class="antialiased selection:bg-blue-500 selection:text-white">
        <div class="hero-section">
            <!-- Decorative Background Blobs -->
            <div class="absolute top-[-10%] left-[-5%] w-96 h-96 bg-blue-600/20 rounded-full mix-blend-screen filter blur-[100px] animate-blob"></div>
            <div class="absolute bottom-[-10%] right-[-5%] w-96 h-96 bg-indigo-600/20 rounded-full mix-blend-screen filter blur-[100px] animate-blob" style="animation-delay: -5s"></div>

            <div class="z-10 text-center px-4 max-w-5xl">
                <div class="inline-flex items-center px-4 py-2 rounded-full bg-blue-500/10 border border-blue-500/20 text-blue-400 text-xs font-black uppercase tracking-[0.3em] mb-8 animate-fade-in">
                    Excellence Académique
                </div>
                
                <h1 class="text-5xl md:text-7xl lg:text-8xl font-black mb-8 tracking-tighter animate-fade-in" style="animation-delay: 0.1s">
                    <span class="gradient-text whitespace-nowrap">HOREB ACADEMIC</span><br>
                    <span class="text-white">Soutenances</span>
                </h1>
                
                <p class="text-xl md:text-2xl text-slate-300/80 mb-14 max-w-3xl mx-auto leading-relaxed font-medium animate-fade-in" style="animation-delay: 0.2s">
                    L'élite technologique de l'Afrique se donne rendez-vous ici. Digitalisez vos mémoires, planifiez vos jurys et célébrez vos succès.
                </p>

                <div class="flex flex-col sm:flex-row gap-8 justify-center items-center animate-fade-in mb-20" style="animation-delay: 0.3s">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="btn-premium px-10 py-4 text-lg">
                            Mon Espace Digital
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="btn-premium px-10 py-4 text-lg">
                            Se connecter
                        </a>
                    @endauth
                </div>
            </div>

            <!-- Footer -->
            <footer class="absolute bottom-10 w-full text-center text-[10px] font-black uppercase tracking-[0.5em] text-slate-600">
                &copy; 2026 HOREB IP &bull; HOREB ACADEMIC &bull; Excellence & Innovation
            </footer>
        </div>
    </body>
</html>
