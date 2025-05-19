<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-primary leading-tight">
            {{ __('Panel de Administración') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Métricas generales -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="bg-white shadow rounded-lg p-5 text-center">
                    <h3 class="text-lg font-medium text-gray-700">Tickets Totales</h3>
                    <p class="mt-2 text-3xl font-bold text-primary">{{ $totalTickets }}</p>
                </div>
                <div class="bg-white shadow rounded-lg p-5 text-center">
                    <h3 class="text-lg font-medium text-gray-700">Tickets Abiertos</h3>
                    <p class="mt-2 text-3xl font-bold text-primary">{{ $openTickets }}</p>
                </div>
                <div class="bg-white shadow rounded-lg p-5 text-center">
                    <h3 class="text-lg font-medium text-gray-700">Tickets Cerrados</h3>
                    <p class="mt-2 text-3xl font-bold text-primary">{{ $closedTickets }}</p>
                </div>
                <div class="bg-white shadow rounded-lg p-5 text-center">
                    <h3 class="text-lg font-medium text-gray-700">Agentes en Línea</h3>
                    <p class="mt-2 text-3xl font-bold text-primary">{{ $onlineAgents }}</p>
                </div>
            </div>

            <!-- Acciones rápidas -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <a href="{{ route('admin.users.index') }}" class="bg-primary text-white p-5 rounded-lg shadow hover:bg-primary-dark transition">
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 15c2.76 0 5.26.88 7.379 2.374M15 10a3 3 0 11-6 0 3 3 0 016 0zm-6 8a6 6 0 0112 0H3z" />
                        </svg>
                        <span class="font-semibold">Gestionar Usuarios</span>
                    </div>
                </a>
                <a href="{{ route('admin.stats.index') }}" class="bg-secondary text-white p-5 rounded-lg shadow hover:bg-secondary-dark transition">
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17l-5-5m0 0l5-5m-5 5h12" />
                        </svg>
                        <span class="font-semibold">Ver Estadísticas</span>
                    </div>
                </a>
            </div>

            <!-- Tickets recientes -->
            <div class="bg-white shadow rounded-lg overflow-hidden">
                <div class="border-b px-6 py-4 bg-gray-50">
                    <h3 class="text-lg font-medium text-gray-700">Últimos Tickets</h3>
                </div>
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Asunto</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Asignado a</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Creado</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($recentTickets as $ticket)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $ticket->id }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $ticket->subject }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $ticket->status_class }}">{{ $ticket->status_label }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $ticket->agent?->username ?? '—' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $ticket->created_at->diffForHumans() }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>

