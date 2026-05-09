<!-- Mobile backdrop -->
<div id="sidebar-backdrop" class="fixed inset-0 bg-[#1B254B]/20 backdrop-blur-sm z-40 hidden transition-opacity opacity-0" onclick="toggleSidebar()"></div>

<div id="main-sidebar" class="fixed inset-y-0 left-0 transform -translate-x-full md:translate-x-0 flex flex-col w-[280px] lg:w-80 bg-[#1B254B] h-screen overflow-y-auto overflow-x-hidden overscroll-contain z-50 transition-transform duration-300 ease-in-out">
    <div class="flex items-center px-10 h-28 border-b border-white/5">
        <div class="flex items-center gap-3">
            <div class="p-2 bg-white/10 rounded-xl">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path></svg>
            </div>
            <div class="flex flex-col">
                <span class="text-xl font-black text-white tracking-tighter uppercase leading-none">GES-SOUTENANCE</span>
                <span class="text-[10px] font-bold text-white/50 uppercase tracking-widest mt-1">Gestion des soutenances</span>
            </div>
        </div>
    </div>
    
    <div class="flex flex-col flex-grow p-8 space-y-12 overflow-y-auto overflow-x-hidden overscroll-contain">
        <!-- Main Navigation -->
        <div>
            <div class="px-4 mb-6 text-[11px] font-black uppercase tracking-[0.3em] text-white/30">Menu Principal</div>
            <div class="space-y-1">
                <a href="{{ route('dashboard') }}" class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <div class="nav-icon"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg></div>
                    <span>Tableau de bord</span>
                </a>
                <a href="{{ route('notifications.index') }}" class="nav-item {{ request()->routeIs('notifications.index') ? 'active' : '' }}">
                    <div class="nav-icon relative">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                        @if(auth()->user()->unreadNotifications->count() > 0)
                            <span class="absolute -top-1 -right-1 w-4 h-4 bg-red-500 text-white text-[9px] flex items-center justify-center rounded-full border-2 border-[#1B254B] font-black">
                                {{ auth()->user()->unreadNotifications->count() }}
                            </span>
                        @endif
                    </div>
                    <span>Notifications</span>
                </a>
            </div>
        </div>

        @if(auth()->user()->isAdmin())
        <div>
            <div class="px-4 mb-6 text-[11px] font-black uppercase tracking-[0.3em] text-white/30">Administration</div>
            <div class="space-y-1">
                <a href="{{ route('planification.index') }}" class="nav-item {{ request()->routeIs('planification.index') ? 'active' : '' }}">
                    <div class="nav-icon"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg></div>
                    <span>Planning Global</span>
                </a>
                <a href="{{ route('admin.enseignants.index') }}" class="nav-item {{ request()->routeIs('admin.enseignants.*') ? 'active' : '' }}">
                    <div class="nav-icon"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg></div>
                    <span>Gestion des Jurys</span>
                </a>
                <a href="{{ route('admin.etudiants.index') }}" class="nav-item {{ request()->routeIs('admin.etudiants.*') ? 'active' : '' }}">
                    <div class="nav-icon"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path></svg></div>
                    <span>Étudiants</span>
                </a>
                <a href="{{ route('admin.salles.index') }}" class="nav-item {{ request()->routeIs('admin.salles.*') ? 'active' : '' }}">
                    <div class="nav-icon"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg></div>
                    <span>Salles</span>
                </a>
                <a href="{{ route('admin.quitus.index') }}" class="nav-item {{ request()->routeIs('admin.quitus.*') ? 'active' : '' }}">
                    <div class="nav-icon"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg></div>
                    <span>Quitus</span>
                </a>
            </div>
        </div>
        @endif

        @if(auth()->user()->role === 'etudiant')
        <div>
            <div class="px-4 mb-6 text-[11px] font-black uppercase tracking-[0.3em] text-white/30">Espace Étudiant</div>
            <div class="space-y-1">
                <a href="{{ route('etudiant.memoire.index') }}" class="nav-item {{ request()->routeIs('etudiant.memoire.*') ? 'active' : '' }}">
                    <div class="nav-icon"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg></div>
                    <span>Mon Mémoire</span>
                </a>
                <a href="{{ route('planification.index') }}" class="nav-item {{ request()->routeIs('planification.index') ? 'active' : '' }}">
                    <div class="nav-icon"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg></div>
                    <span>Mon Planning</span>
                </a>
            </div>
        </div>
        @endif

        @if(auth()->user()->role === 'enseignant')
        <div>
            <div class="px-4 mb-6 text-[11px] font-black uppercase tracking-[0.3em] text-white/30">Espace Jury</div>
            <div class="space-y-1">
                <a href="{{ route('enseignant.evaluations.index') }}" class="nav-item {{ request()->routeIs('enseignant.evaluations.*') ? 'active' : '' }}">
                    <div class="nav-icon"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg></div>
                    <span>Mes Évaluations</span>
                </a>
                <a href="{{ route('planification.index') }}" class="nav-item {{ request()->routeIs('planification.index') ? 'active' : '' }}">
                    <div class="nav-icon"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg></div>
                    <span>Mon Agenda</span>
                </a>
            </div>
        </div>
        @endif
    </div>
    
    <div class="p-8">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="logout-btn w-full">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                <span>Déconnexion</span>
            </button>
        </form>
    </div>
</div>

<style>
    .nav-item {
        display: flex;
        align-items: center;
        padding: 1.1rem 1.5rem;
        color: rgba(255, 255, 255, 0.6);
        font-weight: 500;
        font-size: 0.95rem;
        border-radius: 0.75rem;
        transition: all 0.2s;
        gap: 1rem;
        position: relative;
        margin: 0 0.5rem;
    }

    .nav-item:hover {
        background: rgba(255, 255, 255, 0.05);
        color: white;
    }

    .nav-item.active {
        background: #2D60FF;
        color: white;
        font-weight: 700;
        box-shadow: 0 10px 20px rgba(45, 96, 255, 0.2);
    }

    /* Custom Scrollbar for Sidebar */
    #main-sidebar {
        scrollbar-width: none; /* Firefox */
        -ms-overflow-style: none;  /* IE and Edge */
    }

    #main-sidebar::-webkit-scrollbar {
        width: 5px;
        display: none;
    }

    #main-sidebar:hover {
        scrollbar-width: thin; /* Firefox */
    }

    #main-sidebar:hover::-webkit-scrollbar {
        display: block;
    }

    #main-sidebar::-webkit-scrollbar-track {
        background: transparent;
    }

    #main-sidebar::-webkit-scrollbar-thumb {
        background: rgba(255, 255, 255, 0.1);
        border-radius: 10px;
    }

    #main-sidebar::-webkit-scrollbar-thumb:hover {
        background: rgba(255, 255, 255, 0.2);
    }

    .nav-icon {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .logout-btn {
        display: flex;
        align-items: center;
        padding: 1rem;
        color: #EF4444;
        font-weight: 700;
        border-radius: 0.75rem;
        transition: all 0.2s;
        gap: 0.75rem;
        width: 100%;
        font-size: 0.9rem;
    }

    .logout-btn:hover {
        background: rgba(239, 68, 68, 0.1);
    }
</style>
