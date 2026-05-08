<x-app-layout>
    @section('header', 'Notifications')

    <div class="max-w-4xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-bold text-[#1B254B]">Toutes vos notifications</h2>
            @if(auth()->user()->unreadNotifications->count() > 0)
                <form action="{{ route('notifications.markAllAsRead') }}" method="POST">
                    @csrf
                    <button type="submit" class="text-sm font-bold text-blue-600 hover:underline">
                        Tout marquer comme lu
                    </button>
                </form>
            @endif
        </div>

        <div class="glass-card overflow-hidden">
            <div class="divide-y divide-[#E0E5F2]">
                @forelse($notifications as $notification)
                    <div class="p-6 transition hover:bg-slate-50 {{ $notification->unread() ? 'bg-blue-50/30' : '' }}">
                        <div class="flex items-start gap-4">
                            <div class="h-10 w-10 rounded-full flex items-center justify-center shrink-0 {{ $notification->unread() ? 'bg-blue-100 text-blue-600' : 'bg-slate-100 text-slate-400' }}">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                            </div>
                            <div class="flex-grow min-w-0">
                                <div class="flex items-center justify-between mb-1">
                                    <h3 class="text-sm font-black text-[#1B254B]">{{ $notification->data['title'] ?? 'Notification' }}</h3>
                                    <span class="text-[10px] font-bold text-[#A3AED0]">{{ $notification->created_at->diffForHumans() }}</span>
                                </div>
                                <p class="text-xs text-[#A3AED0] font-medium leading-relaxed mb-3">
                                    {{ $notification->data['message'] ?? '' }}
                                </p>
                                @if($notification->unread())
                                    <div class="flex items-center gap-4">
                                        <form action="{{ route('notifications.markAsRead', $notification->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="text-[10px] font-black uppercase tracking-widest text-blue-600 hover:text-blue-700">
                                                Voir les détails
                                            </button>
                                        </form>
                                    </div>
                                @elseif(isset($notification->data['url']) && $notification->data['url'] !== '#')
                                    <a href="{{ $notification->data['url'] }}" class="text-[10px] font-black uppercase tracking-widest text-[#A3AED0] hover:text-[#1B254B]">
                                        Consulter
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="p-12 text-center">
                        <div class="h-20 w-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-6">
                            <svg class="w-10 h-10 text-slate-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                        </div>
                        <p class="text-[#A3AED0] font-bold italic">Vous n'avez aucune notification pour le moment.</p>
                    </div>
                @endforelse
            </div>
        </div>

        <div class="mt-6">
            {{ $notifications->links() }}
        </div>
    </div>
</x-app-layout>
