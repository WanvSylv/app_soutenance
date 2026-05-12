<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'HOREB ACADEMY') }}</title>

        <!-- Fonts : Montserrat — charte graphique unique -->
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
                        colors: {
                            brand: {
                                50:  '#f0f4ff',
                                100: '#e0eaff',
                                500: '#2D60FF',
                                600: '#1B4FE0',
                                700: '#1B254B',
                                800: '#162040',
                                900: '#0f1630',
                            },
                        },
                        fontFamily: {
                            sans: ['Montserrat', 'sans-serif'],
                        }
                    }
                }
            }
        </script>

        <style>
            body {
                margin: 0;
                font-family: 'Montserrat', sans-serif;
                background-color: #0f172a;
            }

            .auth-bg {
                background-image: linear-gradient(to bottom, rgba(15, 23, 42, 0.8), rgba(15, 23, 42, 0.9)), url('{{ asset('images/academic_success_bg.png') }}');
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
                background: linear-gradient(135deg, #7EB4FF 0%, #2D60FF 100%);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                background-clip: text;
            }

            .btn-premium {
                background: #2D60FF;
                color: white;
                border-radius: 0.75rem;
                font-weight: 700;
                transition: all 0.25s ease;
                box-shadow: 0 10px 20px rgba(45, 96, 255, 0.35);
            }

            .btn-premium:hover {
                background: #1B4FE0;
                transform: translateY(-2px);
                box-shadow: 0 16px 28px rgba(45, 96, 255, 0.45);
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
                        <span class="text-4xl font-black gradient-text tracking-tighter">HOREB ACADEMY</span>
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
                        &copy; 2026 HOREB ACADEMY &bull; Propulsé par <span class="font-bold text-white">HOREB IP</span>
                    </p>
                </div>
            </div>
        </div>
    </body>
</html>
