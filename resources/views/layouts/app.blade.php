<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="light">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'HOREB ACADEMIC') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

        <!-- Tailwind CDN -->
        <script src="https://cdn.tailwindcss.com"></script>
        <script>
            tailwind.config = {
                darkMode: 'class',
                theme: {
                    extend: {
                        colors: {
                            brand: {
                                50: '#f0f9ff',
                                100: '#e0f2fe',
                                500: '#3b82f6',
                                600: '#2563eb',
                                700: '#1d4ed8',
                                800: '#1e40af',
                                900: '#1e3a8a',
                            },
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
                --brand: #2D60FF;
                --bg-main: #F4F7FE;
                --surface: #FFFFFF;
                --text-main: #1B254B;
                --text-muted: #A3AED0;
            }

            body {
                background-color: var(--bg-main);
                color: var(--text-main);
                font-family: 'Outfit', sans-serif;
            }

            /* Premium Surface V3 (Light) */
            .glass-card {
                background: var(--surface);
                border: 1px solid #E0E5F2;
                box-shadow: 0px 4px 20px rgba(112, 144, 176, 0.08);
                border-radius: 1rem;
                transition: all 0.3s ease;
            }

            .glass-card:hover {
                box-shadow: 0px 10px 30px rgba(112, 144, 176, 0.12);
            }

            /* Vibrant Buttons */
            .btn-premium {
                background: var(--brand);
                color: white;
                padding: 1rem 2.5rem;
                border-radius: 1.25rem;
                font-weight: 800;
                display: inline-flex;
                align-items: center;
                gap: 0.75rem;
                transition: all 0.3s ease;
                border: none;
                box-shadow: 0px 10px 20px rgba(45, 96, 255, 0.2);
            }

            .btn-premium:hover {
                transform: translateY(-2px);
                filter: brightness(1.1);
                box-shadow: 0px 15px 30px rgba(45, 96, 255, 0.3);
            }

            /* Typography */
            .gradient-text {
                background: linear-gradient(135deg, #2D60FF 0%, #8A2BE2 100%);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
            }

            /* Inputs */
            input, select, textarea {
                background: #F4F7FE !important;
                border: 1px solid #E0E5F2 !important;
                border-radius: 1.25rem !important;
                color: #1B254B !important;
                padding: 0.9rem 1.2rem !important;
                transition: all 0.3s ease !important;
                font-weight: 600 !important;
            }

            @media (min-width: 768px) {
                input, select, textarea {
                    padding: 1.2rem 1.5rem !important;
                }
            }

            input:focus {
                border-color: var(--brand) !important;
                box-shadow: 0 0 0 4px rgba(45, 96, 255, 0.1) !important;
                background: #FFFFFF !important;
            }

            input::placeholder {
                color: #A3AED0 !important;
                font-weight: 400 !important;
            }

            /* Table Styles */
            .premium-table {
                min-width: 600px;
            }

            .premium-table th {
                color: #A3AED0;
                font-weight: 700;
                text-transform: uppercase;
                letter-spacing: 0.1em;
                font-size: 0.75rem;
            }

            .premium-table tr {
                background: transparent;
                transition: all 0.2s;
            }

            .premium-table tr:hover {
                background: #F4F7FE;
            }

            /* Mobile responsive table cells */
            @media (max-width: 768px) {
                .premium-table th,
                .premium-table td {
                    padding-left: 1rem !important;
                    padding-right: 1rem !important;
                    padding-top: 0.875rem !important;
                    padding-bottom: 0.875rem !important;
                }
            }

            /* Mobile btn-premium */
            @media (max-width: 640px) {
                .btn-premium {
                    width: 100%;
                    justify-content: center;
                }
            }

            /* Animations */
            @keyframes fadeIn {
                from { opacity: 0; transform: translateY(15px); }
                to { opacity: 1; transform: translateY(0); }
            }
            .animate-fade-in { animation: fadeIn 0.6s ease-out forwards; }

            /* Smooth horizontal scroll for planning grid on touch devices */
            .scroll-smooth { scroll-behavior: smooth; }
        </style>

        @vite(['resources/js/app.js'])
    </head>
    <body class="font-sans antialiased overflow-x-hidden">
        <div class="flex min-h-screen min-w-0 overflow-x-hidden">
            <!-- Sidebar -->
            @include('layouts.sidebar')

            <!-- Main Content: offset by sidebar width on md+ -->
            <div class="flex-1 flex flex-col min-w-0 overflow-hidden relative md:ml-[280px] lg:ml-[320px]">
                <!-- Top Header -->
                <header class="h-16 md:h-24 flex items-center justify-between px-4 sm:px-6 md:px-12 border-b border-[#E0E5F2] bg-white/80 backdrop-blur-sm z-20">
                    <div class="flex items-center gap-3">
                        <button onclick="toggleSidebar()" class="md:hidden p-2.5 rounded-xl bg-[#F4F7FE] text-[#1B254B] shadow-sm hover:shadow-md transition border border-[#E0E5F2]">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                        </button>
                        <h1 class="text-base md:text-2xl font-extrabold uppercase tracking-tight text-[#1B254B] truncate max-w-[160px] sm:max-w-none">@yield('header', 'Overview')</h1>
                    </div>
                    
                    <div class="flex items-center gap-3 md:gap-8">
                        <!-- Date (hidden on mobile) -->
                        <div class="hidden lg:flex items-center gap-3 text-[#1B254B]">
                            <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            <span class="font-bold text-sm">{{ now()->translatedFormat('d F Y') }}</span>
                        </div>

                        <!-- Notifications -->
                        @php $unreadCount = auth()->user()->unreadNotifications->count(); @endphp
                        <a href="{{ route('notifications.index') }}" class="relative p-2 text-slate-400 hover:text-blue-600 transition-colors">
                            <svg class="w-5 h-5 md:w-6 md:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                            @if($unreadCount > 0)
                                <span class="absolute top-0.5 right-0.5 w-4 h-4 bg-red-500 text-white text-[9px] flex items-center justify-center rounded-full border-2 border-white font-black">{{ $unreadCount }}</span>
                            @endif
                        </a>

                        <!-- Profile -->
                        <div class="flex items-center gap-2 md:gap-4">
                            <!-- Name hidden on mobile -->
                            <div class="hidden sm:flex flex-col items-end leading-none">
                                <span class="text-sm font-black text-[#1B254B]">{{ auth()->user()->prenom }} {{ auth()->user()->nom }}</span>
                                <span class="text-[10px] uppercase tracking-widest text-[#A3AED0] font-bold mt-1">
                                    {{ auth()->user()->isAdmin() ? 'Admin' : (auth()->user()->role === 'etudiant' ? 'Étudiant' : 'Jury') }}
                                </span>
                            </div>
                            <div class="h-9 w-9 md:h-12 md:w-12 rounded-full ring-2 ring-blue-500/10 overflow-hidden shadow-sm shrink-0">
                                @if(auth()->user()->photo_path)
                                    <img src="{{ asset('storage/' . auth()->user()->photo_path) }}" alt="Profile" class="h-full w-full object-cover">
                                @else
                                    <div class="h-full w-full bg-[#2D60FF] flex items-center justify-center text-white font-black text-sm uppercase">
                                        {{ substr(auth()->user()->prenom, 0, 1) }}{{ substr(auth()->user()->nom, 0, 1) }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </header>

                <!-- Main Scrollable Area -->
                <main class="flex-1 overflow-y-auto p-4 sm:p-6 md:p-12 z-10 pt-4 md:pt-4 flex flex-col">
                    <div class="animate-fade-in flex-grow">
                        {{ $slot }}
                    </div>

                    <!-- Footer Premium -->
                    <footer class="mt-16 pt-8 border-t border-[#E0E5F2] flex flex-col md:flex-row items-center justify-between text-[#A3AED0] text-sm font-medium">
                        <div class="mb-4 md:mb-0 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-[#2D60FF]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                            <span>&copy; {{ date('Y') }} <span class="font-bold text-[#1B254B]">HOREB IP</span>. Tous droits réservés.</span>
                        </div>
                        <div class="flex space-x-6">
                            <a href="#" class="hover:text-[#2D60FF] transition-colors">Support Technique</a>
                            <a href="#" class="hover:text-[#2D60FF] transition-colors">Documentation</a>
                            <div class="flex items-center">
                                <span class="w-2 h-2 rounded-full bg-green-500 mr-2 animate-pulse"></span>
                                Système opérationnel
                            </div>
                        </div>
                    </footer>
                </main>
            </div>
        </div>
        @yield('scripts')
        <script>
            function toggleSidebar() {
                const sidebar = document.getElementById('main-sidebar');
                const backdrop = document.getElementById('sidebar-backdrop');
                
                if (sidebar.classList.contains('-translate-x-full')) {
                    // Open
                    sidebar.classList.remove('-translate-x-full');
                    backdrop.classList.remove('hidden');
                    // timeout to allow display:block to apply before opacity transition
                    setTimeout(() => backdrop.classList.remove('opacity-0'), 10);
                } else {
                    // Close
                    sidebar.classList.add('-translate-x-full');
                    backdrop.classList.add('opacity-0');
                    setTimeout(() => backdrop.classList.add('hidden'), 300); // Wait for transition
                }
            }
        </script>
    </body>
</html>
