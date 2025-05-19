<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-primary leading-tight">
            {{ __('Panel de Agente de Soporte') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Banner de agente -->
            <div class="bg-primary rounded-lg shadow-md overflow-hidden">
                <div class="px-6 py-8 md:flex md:items-center md:justify-between">
                    <div class="text-white">
                        <h2 class="text-2xl font-bold">
                            Bienvenido(a), {{ auth()->user()->username }}
                        </h2>
                        <p class="mt-1">
                            Tienes <strong>{{ $assignedCount }}</strong> tickets asignados
                        </p>
                    </div>
                    <div class="mt-4 md:mt-0">
                        <a href="{{ route('agent.tickets.index') }}"
                            class="inline-flex items-center px-5 py-3 bg-white text-primary font-semibold rounded-lg shadow hover:bg-gray-100 transition">
                            Ver Mis Tickets
                        </a>
                    </div>
                </div>
            </div>

            <!-- Acciones rápidas -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="bg-white shadow rounded-lg p-5 hover:shadow-md transition">
                    <a href="{{ route('agent.tickets.index') }}" class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-primary mr-3" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414
                                     5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <span class="text-lg font-medium text-gray-900">
                            Mis Tickets
                        </span>
                    </a>
                </div>
                <div class="bg-white shadow rounded-lg p-5 hover:shadow-md transition">
                    <form action="{{ route('agent.tickets.next') }}" method="POST" class="flex items-center">
                        @csrf
                        <button type="submit" class="w-full flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-primary mr-3" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            <span class="text-lg font-medium text-gray-900">
                                Tomar Siguiente Ticket
                            </span>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Tickets asignados recientes -->
            <div class="bg-white shadow rounded-lg overflow-hidden">
                <div class="border-b px-6 py-4 bg-gray-50">
                    <h3 class="text-lg font-medium text-gray-700">
                        Tickets Recientes Asignados
                    </h3>
                </div>
                <ul class="divide-y divide-gray-200">
                    @forelse($recentAssigned as $ticket)
                        <li class="px-6 py-4 flex justify-between items-center">
                            <div>
                                <p class="text-sm font-semibold text-gray-900">
                                    #{{ $ticket->id }} — {{ $ticket->title }}
                                </p>
                                <p class="text-xs text-gray-500">
                                    {{ $ticket->created_at->diffForHumans() }}
                                </p>
                            </div>
                            <a href="{{ route('agent.tickets.show', $ticket) }}" class="text-primary hover:underline">
                                Ver detalles
                            </a>
                        </li>
                    @empty
                        <li class="px-6 py-4 text-center text-gray-500">
                            No tienes tickets asignados recientemente.
                        </li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</x-app-layout>
