<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'HOREB ACADEMIC') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

        <!-- Tailwind CDN -->
        <script src="https://cdn.tailwindcss.com"></script>
        <script>
            tailwind.config = {
                darkMode: 'class',
                theme: {
                    extend: {
                        colors: {
                            premium: {
                                50: '#f0f9ff',
                                100: '#e0f2fe',
                                500: '#0ea5e9',
                                600: '#0284c7',
                                700: '#0369a1',
                                900: '#0c4a6e',
                            }
                        },
                        fontFamily: {
                            sans: ['Outfit', 'sans-serif'],
                        }
                    }
                }
            }
        </script>

        <style>
            :root {
                --primary: #2563eb;
                --primary-dark: #1e40af;
            }
            
            body { 
                margin: 0;
                font-family: 'Outfit', sans-serif;
                background-color: #0f172a;
            }

            .auth-bg {
                background-image: linear-gradient(to bottom, rgba(15, 23, 42, 0.8), rgba(15, 23, 42, 0.9)), url('{{ asset('images/students_african.png') }}');
                background-size: cover;
                background-position: center;
                background-attachment: fixed;
            }

            .glass-container {
                background: rgba(255, 255, 255, 0.03);
                backdrop-filter: blur(20px);
                -webkit-backdrop-filter: blur(20px);
                border: 1px solid rgba(255, 255, 255, 0.1);
                box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            }

            .gradient-text {
                background: linear-gradient(135deg, #60a5fa 0%, #2563eb 100%);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
            }

            .btn-premium {
                background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
                color: white;
                border-radius: 1rem;
                font-weight: 700;
                transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                box-shadow: 0 10px 15px -3px rgba(37, 99, 235, 0.4);
            }

            .btn-premium:hover {
                transform: translateY(-2px) scale(1.02);
                filter: brightness(1.1);
                box-shadow: 0 20px 25px -5px rgba(37, 99, 235, 0.5);
            }

            @keyframes slideUp {
                from { opacity: 0; transform: translateY(30px); }
                to { opacity: 1; transform: translateY(0); }
            }

            .animate-slide-up {
                animation: slideUp 0.6s ease-out forwards;
            }
        </style>

        @vite(['resources/js/app.js'])
    </head>
    <body class="antialiased selection:bg-blue-500 selection:text-white overflow-x-hidden">
        <div class="min-h-screen flex flex-col justify-center items-center p-4 auth-bg relative">
            <!-- Decorative Elements -->
            <div class="absolute top-0 left-0 w-full h-full overflow-hidden pointer-events-none">
                <div class="absolute top-1/4 -left-20 w-96 h-96 bg-blue-600 rounded-full mix-blend-screen filter blur-[128px] opacity-20"></div>
                <div class="absolute bottom-1/4 -right-20 w-96 h-96 bg-indigo-600 rounded-full mix-blend-screen filter blur-[128px] opacity-20"></div>
            </div>

            <div class="z-10 w-full max-w-xl animate-slide-up">
                <div class="text-center mb-10">
                    <a href="/" class="inline-block transition hover:scale-105 duration-300">
                        <span class="text-4xl font-black gradient-text tracking-tighter">HOREB ACADEMIC</span>
                    </a>
                </div>

                <div class="glass-container rounded-[2.5rem] p-8 md:p-12 relative overflow-hidden">
                    <!-- Subtle inner glow -->
                    <div class="absolute -top-24 -right-24 w-48 h-48 bg-blue-500 opacity-10 rounded-full blur-3xl"></div>
                    
                    <div class="relative z-10">
                        {{ $slot }}
                    </div>
                </div>

                <div class="mt-10 text-center">
                    <p class="text-slate-400 text-sm font-medium">
                        &copy; 2026 HOREB ACADEMIC &bull; Propulsé par <span class="font-bold text-white">HOREB IP</span>
                    </p>
                </div>
            </div>
        </div>
    </body>
</html>
