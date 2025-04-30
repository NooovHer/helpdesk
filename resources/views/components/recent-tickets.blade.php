<!-- resources/views/components/recent-tickets.blade.php -->
<div class="bg-white shadow-md rounded-lg p-6">
    <h2 class="text-xl font-semibold mb-4 text-primary">
        <i class="fas fa-ticket-alt mr-2"></i>Mis Tickets Recientes
    </h2>
    <div class="space-y-3">
        @forelse($tickets as $ticket)
            <div class="flex justify-between items-center border-b pb-2">
                <div>
                    <p class="font-medium">{{ $ticket->title }}</p>
                    <span class="text-sm text-secondary">{{ $ticket->created_at->diffForHumans() }}</span>
                </div>
                <span class="text-{{ $ticket->status_color }}-600 bg-{{ $ticket->status_color }}-100 px-2 py-1 rounded-full text-xs">
                    {{ $ticket->status }}
                </span>
            </div>
        @empty
            <p class="text-gray-500 text-center">No hay tickets recientes</p>
        @endforelse
        <div class="text-center mt-4">
            <a href="{{ route('tickets.index') }}" class="text-primary hover:text-primary/80">
                Ver todos los tickets
            </a>
        </div>
    </div>
</div>