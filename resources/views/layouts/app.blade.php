<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="light">
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
                font-family: 'Montserrat', sans-serif;
            }

            /* Mobile btn-premium */
            @media (max-width: 640px) {
                .btn-premium { width: 100%; justify-content: center; }
            }

            /* Smooth horizontal scroll */
            .scroll-smooth { scroll-behavior: smooth; }
        </style>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased overflow-x-hidden">

        {{-- Modale déconnexion — en dehors de tout transform --}}
        <div id="logout-modal" onclick="if(event.target===this)closeLogout()" style="display:none;position:fixed;inset:0;background:rgba(27,37,75,0.45);backdrop-filter:blur(4px);z-index:9999;align-items:center;justify-content:center;">
            <div style="background:#fff;border-radius:12px;padding:2rem;width:100%;max-width:340px;margin:1rem;box-shadow:0 24px 60px rgba(0,0,0,0.18);">
                <div style="width:44px;height:44px;background:#FEF2F2;border-radius:10px;display:flex;align-items:center;justify-content:center;margin-bottom:1rem;">
                    <svg width="22" height="22" fill="none" stroke="#EF4444" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                </div>
                <h3 style="font-size:1rem;font-weight:800;color:#1B254B;margin:0 0 0.4rem;">Déconnexion</h3>
                <p style="font-size:0.825rem;color:#A3AED0;font-weight:500;margin:0 0 1.5rem;line-height:1.5;">Voulez-vous vraiment vous déconnecter de votre espace ?</p>
                <div style="display:flex;gap:0.75rem;">
                    <button onclick="closeLogout()" style="flex:1;padding:0.7rem;background:#F4F7FE;border:1.5px solid #E0E5F2;border-radius:6px;font-family:inherit;font-size:0.8rem;font-weight:700;color:#1B254B;cursor:pointer;text-transform:uppercase;letter-spacing:0.04em;">Annuler</button>
                    <button onclick="document.getElementById('logout-form').submit()" style="flex:1;padding:0.7rem;background:#EF4444;border:none;border-radius:6px;font-family:inherit;font-size:0.8rem;font-weight:700;color:#fff;cursor:pointer;text-transform:uppercase;letter-spacing:0.04em;">Se déconnecter</button>
                </div>
            </div>
        </div>

        <div class="flex min-h-screen min-w-0 overflow-x-hidden">
            <!-- Sidebar -->
            @include('layouts.sidebar')

            <!-- Main Content: offset by sidebar width on md+ -->
            <div class="flex-1 flex flex-col min-w-0 overflow-hidden relative md:ml-[260px]">
                <!-- Top Header -->
                <header style="height:60px;display:flex;align-items:center;justify-content:space-between;padding:0 1.5rem;border-bottom:1px solid #E0E5F2;background:#fff;position:sticky;top:0;z-index:20;">
                    <div style="display:flex;align-items:center;gap:0.75rem;">
                        <button onclick="toggleSidebar()" class="md-hidden-toggle" id="sidebar-toggle">
                            <svg style="width:20px;height:20px;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
                        </button>
                        <h1 style="font-size:0.8rem;font-weight:800;text-transform:uppercase;letter-spacing:0.12em;color:#A3AED0;margin:0;">@yield('header', 'Vue générale')</h1>
                    </div>

                    <div style="display:flex;align-items:center;gap:1.5rem;">
                        <!-- Date -->
                        <span style="font-size:0.78rem;font-weight:600;color:#A3AED0;display:none;" class="lg-date">
                            {{ now()->translatedFormat('d F Y') }}
                        </span>

                        <!-- Notifications -->
                        @php $unreadCount = auth()->user()->unreadNotifications->count(); @endphp
                        <a href="{{ route('notifications.index') }}" style="position:relative;color:#A3AED0;display:flex;align-items:center;transition:color 0.15s;" onmouseover="this.style.color='#2D60FF'" onmouseout="this.style.color='#A3AED0'">
                            <svg style="width:18px;height:18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                            @if($unreadCount > 0)
                                <span style="position:absolute;top:-3px;right:-3px;width:14px;height:14px;background:#EF4444;color:#fff;font-size:8px;font-weight:900;border-radius:50%;display:flex;align-items:center;justify-content:center;border:1.5px solid #fff;">{{ $unreadCount }}</span>
                            @endif
                        </a>

                        <!-- Séparateur -->
                        <div style="width:1px;height:24px;background:#E0E5F2;"></div>

                        <!-- Profil -->
                        <div style="display:flex;align-items:center;gap:0.6rem;">
                            <div style="text-align:right;display:none;" class="sm-name">
                                <div style="font-size:0.78rem;font-weight:700;color:#1B254B;line-height:1.2;">{{ auth()->user()->prenom }} {{ auth()->user()->nom }}</div>
                                <div style="font-size:0.6rem;font-weight:700;color:#A3AED0;text-transform:uppercase;letter-spacing:0.1em;">{{ auth()->user()->isAdmin() ? 'Admin' : (auth()->user()->role === 'etudiant' ? 'Étudiant' : 'Jury') }}</div>
                            </div>
                            <div style="width:34px;height:34px;border-radius:8px;overflow:hidden;flex-shrink:0;">
                                @if(auth()->user()->photo_path)
                                    <img src="{{ asset('storage/' . auth()->user()->photo_path) }}" alt="Profile" style="width:100%;height:100%;object-fit:cover;">
                                @else
                                    <div style="width:100%;height:100%;background:#2D60FF;display:flex;align-items:center;justify-content:center;color:#fff;font-size:0.7rem;font-weight:900;text-transform:uppercase;">{{ substr(auth()->user()->prenom,0,1) }}{{ substr(auth()->user()->nom,0,1) }}</div>
                                @endif
                            </div>
                        </div>
                    </div>
                </header>
                <style>
                    .md-hidden-toggle { display:none; }
                    @media (max-width: 767px) { .md-hidden-toggle { display:flex; align-items:center; padding:6px; background:#F4F7FE; border:1px solid #E0E5F2; border-radius:6px; color:#1B254B; cursor:pointer; } }
                    @media (min-width: 640px) { .sm-name { display:block!important; } }
                    @media (min-width: 1024px) { .lg-date { display:block!important; } }
                </style>

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
