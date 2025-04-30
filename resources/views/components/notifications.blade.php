<!-- resources/views/components/notifications.blade.php -->
<div class="bg-white shadow-md rounded-lg p-6">
    <h2 class="text-xl font-semibold mb-4 text-primary">
        <i class="fas fa-bell mr-2"></i>Notificaciones
    </h2>
    <div class="space-y-3">
        @forelse($notifications as $notification)
            <div class="bg-blue-50 p-3 rounded-lg">
                <p class="text-sm">{{ $notification->message }}</p>
                <span class="text-xs text-secondary">
                    {{ $notification->created_at->diffForHumans() }}
                </span>
            </div>
        @empty
            <p class="text-gray-500 text-center">No hay notificaciones</p>
        @endforelse
    </div>
</div>
