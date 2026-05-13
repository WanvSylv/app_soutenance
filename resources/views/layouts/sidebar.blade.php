<style>
    aside#main-sidebar { position:fixed;top:0;bottom:0;left:0;width:260px;background:#1B254B;display:flex;flex-direction:column;z-index:50;transform:translateX(-100%);transition:transform 0.3s ease;overflow-y:auto;overflow-x:hidden; }
    @media (min-width: 768px) { aside#main-sidebar { transform:translateX(0); } }
    aside#main-sidebar { scrollbar-width:none; }
    aside#main-sidebar:hover { scrollbar-width:thin;scrollbar-color:rgba(255,255,255,0.12) transparent; }
    aside#main-sidebar::-webkit-scrollbar { width:0; }
    aside#main-sidebar:hover::-webkit-scrollbar { width:3px; }
    aside#main-sidebar::-webkit-scrollbar-track { background:transparent; }
    aside#main-sidebar::-webkit-scrollbar-thumb { background:rgba(255,255,255,0.12);border-radius:4px; }
    .sidebar-logo { display:flex;align-items:center;gap:0.75rem;padding:1.5rem 1.5rem 1.25rem;border-bottom:1px solid rgba(255,255,255,0.06);flex-shrink:0; }
    .sidebar-logo-icon { width:32px;height:32px;background:#2D60FF;border-radius:8px;display:flex;align-items:center;justify-content:center;flex-shrink:0; }
    .sidebar-logo-name { font-size:0.8rem;font-weight:900;color:#fff;letter-spacing:-0.01em;text-transform:uppercase;line-height:1; }
    .sidebar-logo-sub { font-size:0.55rem;font-weight:600;color:rgba(255,255,255,0.3);text-transform:uppercase;letter-spacing:0.12em;margin-top:3px; }
    .sidebar-nav { flex:1;padding:1rem 0.75rem;display:flex;flex-direction:column;gap:1.75rem; }
    .nav-group { display:flex;flex-direction:column;gap:2px; }
    .nav-section-label { font-size:0.6rem;font-weight:800;text-transform:uppercase;letter-spacing:0.18em;color:rgba(255,255,255,0.2);padding:0 0.75rem;margin-bottom:0.25rem; }
    .nav-item { display:flex;align-items:center;gap:0.75rem;padding:0.65rem 0.75rem;color:rgba(255,255,255,0.4);font-size:0.825rem;font-weight:500;border-radius:6px;text-decoration:none;transition:color 0.15s,background 0.15s; }
    .nav-item:hover { color:rgba(255,255,255,0.8);background:rgba(255,255,255,0.05); }
    .nav-item.active { color:#fff;font-weight:700;background:#2D60FF; }
    .nav-icon { width:16px;height:16px;flex-shrink:0;opacity:0.7; }
    .nav-item.active .nav-icon, .nav-item:hover .nav-icon { opacity:1; }
    .nav-icon-wrap { position:relative;display:flex; }
    .notif-badge { position:absolute;top:-4px;right:-4px;width:14px;height:14px;background:#EF4444;color:#fff;font-size:8px;font-weight:900;border-radius:50%;display:flex;align-items:center;justify-content:center;border:1.5px solid #1B254B; }
    .sidebar-footer { display:flex;align-items:center;justify-content:space-between;padding:1rem 1rem 1.25rem;border-top:1px solid rgba(255,255,255,0.06);flex-shrink:0;gap:0.5rem; }
    .sidebar-user { display:flex;align-items:center;gap:0.65rem;min-width:0; }
    .sidebar-avatar { width:30px;height:30px;border-radius:6px;background:#2D60FF;color:#fff;font-size:0.65rem;font-weight:900;text-transform:uppercase;display:flex;align-items:center;justify-content:center;flex-shrink:0; }
    .sidebar-user-info { display:flex;flex-direction:column;min-width:0; }
    .sidebar-user-name { font-size:0.75rem;font-weight:700;color:rgba(255,255,255,0.85);white-space:nowrap;overflow:hidden;text-overflow:ellipsis; }
    .sidebar-user-role { font-size:0.6rem;font-weight:600;color:rgba(255,255,255,0.3);text-transform:uppercase;letter-spacing:0.08em; }
    .sidebar-logout { width:30px;height:30px;border-radius:6px;background:transparent;border:1px solid rgba(255,255,255,0.08);color:rgba(255,255,255,0.3);display:flex;align-items:center;justify-content:center;cursor:pointer;transition:background 0.15s,color 0.15s,border-color 0.15s;flex-shrink:0; }
    .sidebar-logout:hover { background:rgba(239,68,68,0.12);border-color:rgba(239,68,68,0.3);color:#EF4444; }
</style>

<!-- Backdrop mobile -->
<div id="sidebar-backdrop" class="fixed inset-0 bg-black/40 z-40 hidden opacity-0 transition-opacity duration-300" onclick="toggleSidebar()"></div>

<aside id="main-sidebar">

    <!-- Logo -->
    <div class="sidebar-logo">
        <div class="sidebar-logo-icon">
            <svg width="16" height="16" fill="none" stroke="white" viewBox="0 0 24 24" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5z"/>
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0112 20.055a11.952 11.952 0 01-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/>
            </svg>
        </div>
        <div>
            <div class="sidebar-logo-name">GES-SOUTENANCE</div>
            <div class="sidebar-logo-sub">HOREB ACADEMY</div>
        </div>
    </div>

    <!-- Navigation -->
    <nav class="sidebar-nav">

        <!-- Général -->
        <div class="nav-group">
            <a href="{{ route('dashboard') }}" class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                Tableau de bord
            </a>

            <a href="{{ route('notifications.index') }}" class="nav-item {{ request()->routeIs('notifications.index') ? 'active' : '' }}">
                <span class="nav-icon-wrap">
                    <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                    </svg>
                    @if(auth()->user()->unreadNotifications->count() > 0)
                        <span class="notif-badge">{{ auth()->user()->unreadNotifications->count() }}</span>
                    @endif
                </span>
                Notifications
            </a>
        </div>

        @if(auth()->user()->isAdmin())
        <div class="nav-group">
            <div class="nav-section-label">Administration</div>
            <a href="{{ route('planification.index') }}" class="nav-item {{ request()->routeIs('planification.index') ? 'active' : '' }}">
                <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                Planning
            </a>
            <a href="{{ route('admin.enseignants.index') }}" class="nav-item {{ request()->routeIs('admin.enseignants.*') ? 'active' : '' }}">
                <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                </svg>
                Jurys
            </a>
            <a href="{{ route('admin.etudiants.index') }}" class="nav-item {{ request()->routeIs('admin.etudiants.*') ? 'active' : '' }}">
                <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                Étudiants
            </a>
            <a href="{{ route('admin.memoires.index') }}" class="nav-item {{ request()->routeIs('admin.memoires.*') ? 'active' : '' }}">
                <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Mémoires
            </a>
            <a href="{{ route('admin.quitus.index') }}" class="nav-item {{ request()->routeIs('admin.quitus.*') ? 'active' : '' }}">
                <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Quitus
            </a>
            <a href="{{ route('admin.salles.index') }}" class="nav-item {{ request()->routeIs('admin.salles.*') ? 'active' : '' }}">
                <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
                Salles
            </a>
            <a href="{{ route('admin.users.index') }}" class="nav-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
                Comptes
            </a>
        </div>
        @endif

        @if(auth()->user()->role === 'etudiant')
        <div class="nav-group">
            <div class="nav-section-label">Mon espace</div>
            <a href="{{ route('etudiant.memoire.index') }}" class="nav-item {{ request()->routeIs('etudiant.memoire.*') ? 'active' : '' }}">
                <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                </svg>
                Mon mémoire
            </a>
            <a href="{{ route('planification.index') }}" class="nav-item {{ request()->routeIs('planification.index') ? 'active' : '' }}">
                <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                Mon planning
            </a>
        </div>
        @endif

        @if(auth()->user()->role === 'enseignant')
        <div class="nav-group">
            <div class="nav-section-label">Mon espace</div>
            <a href="{{ route('enseignant.evaluations.index') }}" class="nav-item {{ request()->routeIs('enseignant.evaluations.*') ? 'active' : '' }}">
                <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                </svg>
                Mes évaluations
            </a>
            <a href="{{ route('planification.index') }}" class="nav-item {{ request()->routeIs('planification.index') ? 'active' : '' }}">
                <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                Mon agenda
            </a>
        </div>
        @endif

    </nav>

    <!-- Profil + Déconnexion -->
    <div class="sidebar-footer">
        <a href="{{ route('profile.edit') }}" class="sidebar-user" style="text-decoration:none;" title="Mon profil">
            <div class="sidebar-avatar" style="overflow:hidden;">
                @if(auth()->user()->photo_path)
                    <img src="{{ asset('storage/' . auth()->user()->photo_path) }}" style="width:100%;height:100%;object-fit:cover;">
                @else
                    {{ substr(auth()->user()->prenom, 0, 1) }}{{ substr(auth()->user()->nom, 0, 1) }}
                @endif
            </div>
            <div class="sidebar-user-info">
                <span class="sidebar-user-name">{{ auth()->user()->prenom }} {{ auth()->user()->nom }}</span>
                <span class="sidebar-user-role">{{ auth()->user()->isAdmin() ? 'Administrateur' : (auth()->user()->role === 'etudiant' ? 'Étudiant' : 'Jury') }}</span>
            </div>
        </a>
        <form method="POST" action="{{ route('logout') }}" id="logout-form">
            @csrf
            <button type="button" onclick="confirmLogout()" class="sidebar-logout" title="Déconnexion">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                </svg>
            </button>
        </form>

        <script>
            function confirmLogout() {
                document.getElementById('logout-modal').style.display = 'flex';
            }
            function closeLogout() {
                document.getElementById('logout-modal').style.display = 'none';
            }
        </script>
    </div>

</aside>

