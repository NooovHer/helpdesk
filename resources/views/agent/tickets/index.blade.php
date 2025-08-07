<x-app-layout>
    <div class="min-h-screen bg-gradient-to-br from-slate-50 via-purple-50 to-indigo-100 py-8">
        <div class="max-w-7xl mx-auto px-4 space-y-6">
            <!-- Encabezado -->
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <h1 class="text-3xl font-bold bg-gradient-to-r from-gray-800 to-gray-600 bg-clip-text text-transparent">
                        Mis Tickets Asignados
                    </h1>
                    <p class="text-gray-600 mt-1">Gestiona los tickets que tienes asignados</p>
                </div>
                <div class="flex gap-3">
                    <a href="{{ route('agent.tickets.available') }}" class="flex items-center gap-2 px-6 py-3 rounded-xl font-semibold bg-gradient-to-r from-orange-500 to-orange-700 text-white hover:from-orange-600 hover:to-orange-800 transition shadow-lg">
                        <i class="fas fa-hand-paper"></i> Ver Disponibles
                    </a>
                    <a href="{{ route('agent.dashboard') }}" class="flex items-center gap-2 px-6 py-3 rounded-xl font-semibold bg-gray-500 text-white hover:bg-gray-600 transition shadow-lg">
                        <i class="fas fa-arrow-left"></i> Volver
                    </a>
                </div>
            </div>

            <!-- Estadísticas rápidas -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="bg-white/80 backdrop-blur-sm rounded-xl shadow p-4">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-ticket-alt text-blue-500 text-xl"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Total Asignados</p>
                            <p class="text-2xl font-bold text-gray-800">{{ $assignedTickets->count() }}</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white/80 backdrop-blur-sm rounded-xl shadow p-4">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-spinner text-yellow-500 text-xl"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">En Progreso</p>
                            <p class="text-2xl font-bold text-gray-800">{{ $assignedTickets->where('status', 'en progreso')->count() }}</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white/80 backdrop-blur-sm rounded-xl shadow p-4">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-check-circle text-green-500 text-xl"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Resueltos</p>
                            <p class="text-2xl font-bold text-gray-800">{{ $assignedTickets->where('status', 'resuelto')->count() }}</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white/80 backdrop-blur-sm rounded-xl shadow p-4">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-exclamation-triangle text-red-500 text-xl"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Urgentes</p>
                            <p class="text-2xl font-bold text-gray-800">{{ $assignedTickets->where('priority', 'alta')->where('status', '!=', 'cerrado')->count() }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabla de tickets asignados -->
            <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg overflow-hidden">
                <div class="border-b px-6 py-4 bg-blue-50 flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <i class="fas fa-ticket-alt text-blue-500 text-xl"></i>
                        <h3 class="text-lg font-bold text-gray-700">Tickets Asignados</h3>
                    </div>
                    <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-semibold">
                        {{ $assignedTickets->count() }} tickets
                    </span>
                </div>

                @if($assignedTickets->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left font-semibold text-gray-500">ID</th>
                                <th class="px-4 py-3 text-left font-semibold text-gray-500">Asunto</th>
                                <th class="px-4 py-3 text-left font-semibold text-gray-500">Estado</th>
                                <th class="px-4 py-3 text-left font-semibold text-gray-500">Prioridad</th>
                                <th class="px-4 py-3 text-left font-semibold text-gray-500">Departamento</th>
                                <th class="px-4 py-3 text-left font-semibold text-gray-500">Creado por</th>
                                <th class="px-4 py-3 text-left font-semibold text-gray-500">Fecha</th>
                                <th class="px-4 py-3 text-left font-semibold text-gray-500">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @foreach($assignedTickets as $ticket)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 text-gray-700 font-mono">#{{ $ticket->id }}</td>
                                <td class="px-4 py-3">
                                    <div class="max-w-xs">
                                        <p class="text-gray-900 font-medium">{{ $ticket->title }}</p>
                                        @if($ticket->category)
                                        <p class="text-xs text-gray-500">{{ $ticket->category->name }}</p>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-4 py-3">
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold
                                        @if($ticket->status === 'abierto') bg-blue-100 text-blue-800 border border-blue-200
                                        @elseif($ticket->status === 'en progreso') bg-yellow-100 text-yellow-800 border border-yellow-200
                                        @elseif($ticket->status === 'resuelto') bg-green-100 text-green-800 border border-green-200
                                        @else bg-gray-100 text-gray-800 border border-gray-200
                                        @endif">
                                        <i class="fas fa-circle mr-1 text-xs"></i>
                                        {{ ucfirst($ticket->status) }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold
                                        @if($ticket->priority === 'alta') bg-red-100 text-red-800 border border-red-200
                                        @elseif($ticket->priority === 'media') bg-yellow-100 text-yellow-800 border border-yellow-200
                                        @else bg-blue-100 text-blue-800 border border-blue-200
                                        @endif">
                                        <i class="fas fa-flag mr-1"></i>
                                        {{ ucfirst($ticket->priority) }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-gray-600">
                                    {{ $ticket->department->name ?? 'Sin departamento' }}
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center gap-2">
                                        <div class="w-8 h-8 bg-gradient-to-br from-purple-500 to-indigo-600 rounded-full flex items-center justify-center text-white text-sm font-bold">
                                            {{ strtoupper(substr($ticket->creator->username ?? 'U', 0, 1)) }}
                                        </div>
                                        <span class="text-gray-700">{{ $ticket->creator->username ?? 'Usuario' }}</span>
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-gray-500">
                                    <div class="text-sm">
                                        <div>{{ $ticket->created_at->format('d/m/Y') }}</div>
                                        <div class="text-xs">{{ $ticket->created_at->format('H:i') }}</div>
                                    </div>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('agent.tickets.show', $ticket) }}" class="flex items-center gap-1 px-3 py-1 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition text-sm font-medium">
                                            <i class="fas fa-eye"></i>
                                            Ver
                                        </a>
                                        <form action="{{ route('agent.tickets.release', $ticket) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="flex items-center gap-1 px-3 py-1 bg-red-500 text-white rounded-lg hover:bg-red-600 transition text-sm font-medium"
                                                onclick="return confirm('¿Estás seguro de que quieres liberar este ticket?')">
                                                <i class="fas fa-unlock"></i>
                                                Liberar
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="py-12 text-center">
                    <div class="w-24 h-24 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-ticket-alt text-blue-500 text-3xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-700 mb-2">No tienes tickets asignados</h3>
                    <p class="text-gray-500">Ve a la sección de tickets disponibles para asignarte algunos.</p>
                    <a href="{{ route('agent.tickets.available') }}" class="inline-flex items-center gap-2 mt-4 px-6 py-3 bg-orange-500 text-white rounded-lg hover:bg-orange-600 transition">
                        <i class="fas fa-hand-paper"></i>
                        Ver Tickets Disponibles
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>
    <!-- FontAwesome para iconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</x-app-layout>
