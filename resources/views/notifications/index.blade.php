<x-app-layout>
@section('header', 'Notifications')

<div class="page-toolbar" style="margin-bottom:1.5rem;">
    <p class="page-desc">Toutes vos notifications.</p>
    @if(auth()->user()->unreadNotifications->count() > 0)
    <form action="{{ route('notifications.markAllAsRead') }}" method="POST">
        @csrf
        <button type="submit" class="btn-outline" style="font-size:0.75rem;">Tout marquer comme lu</button>
    </form>
    @endif
</div>

<div class="data-card">
    @forelse($notifications as $notif)
    <div style="display:flex;align-items:flex-start;gap:1rem;padding:1rem 1.5rem;border-bottom:1px solid #F4F7FE;{{ $notif->unread() ? 'background:#F8FAFF;' : '' }}">
        <div style="width:34px;height:34px;border-radius:8px;background:{{ $notif->unread() ? '#EFF6FF' : '#F4F7FE' }};display:flex;align-items:center;justify-content:center;flex-shrink:0;">
            <svg width="16" height="16" fill="none" stroke="{{ $notif->unread() ? '#2D60FF' : '#A3AED0' }}" viewBox="0 0 24 24" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
        </div>
        <div style="flex:1;min-width:0;">
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:0.25rem;gap:1rem;">
                <span class="row-name">{{ $notif->data['title'] ?? 'Notification' }}</span>
                <span class="row-sub" style="white-space:nowrap;">{{ $notif->created_at->diffForHumans() }}</span>
            </div>
            <p class="row-muted" style="font-size:0.8rem;line-height:1.5;">{{ $notif->data['message'] ?? '' }}</p>
            @if($notif->unread())
            <form action="{{ route('notifications.markAsRead', $notif->id) }}" method="POST" style="margin-top:0.5rem;">
                @csrf
                <button type="submit" class="auth-link" style="background:none;border:none;cursor:pointer;font-family:inherit;padding:0;">Marquer comme lu</button>
            </form>
            @elseif(isset($notif->data['url']) && $notif->data['url'] !== '#')
            <a href="{{ $notif->data['url'] }}" class="auth-link" style="font-size:0.75rem;margin-top:0.35rem;display:inline-block;">Consulter</a>
            @endif
        </div>
        @if($notif->unread())
        <div style="width:7px;height:7px;border-radius:50%;background:#2D60FF;flex-shrink:0;margin-top:0.4rem;"></div>
        @endif
    </div>
    @empty
    <div class="empty-state">
        <svg width="32" height="32" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
        Aucune notification pour le moment.
    </div>
    @endforelse
</div>

@if($notifications->hasPages())
<div style="margin-top:1rem;">{{ $notifications->links() }}</div>
@endif

@include('admin._table-styles')
</x-app-layout>
