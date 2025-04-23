<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Tickets') }}
            </h2>

        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Lista de Tickets -->
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-6 border-b pb-2">
                        <h3 class="text-xl font-semibold text-gray-700">Mis Tickets</h3>
                        <a href="{{ route('tickets.create') }}"
                            class="px-4 py-2 bg-primary text-white rounded-lg hover:bg-hover transition duration-150 ease-in-out flex items-center shadow-md">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"
                                    clip-rule="evenodd" />
                            </svg>
                            Crear Ticket
                        </a>
                    </div>

                    @if ($tickets->isEmpty())
                    <div class="flex flex-col items-center justify-center py-12 bg-gray-50 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-400 mb-4" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <p class="text-gray-500 text-lg">No tienes tickets registrados.</p>
                        <a href="{{ route('tickets.create') }}"
                            class="mt-4 inline-flex items-center px-4 py-2 bg-primary text-white text-sm font-medium rounded-md hover:bg-hover focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150 ease-in-out">
                            Crear tu primer ticket
                        </a>
                    </div>
                    @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr>
                                    <th
                                        class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Título</th>
                                    <th
                                        class="px-6 py-3 bg-gray-50 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Estado</th>
                                    <th
                                        class="px-6 py-3 bg-gray-50 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Prioridad</th>
                                    <th
                                        class="px-6 py-3 bg-gray-50 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Fecha Creación</th>
                                    <th
                                        class="px-6 py-3 bg-gray-50 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($tickets as $ticket)
                                <tr class="hover:bg-gray-50 transition duration-150 ease-in-out">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ $ticket->title }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                                         {{
                                             $ticket->status == 'nuevo' ? 'bg-green-100 text-green-800' :
                                            ($ticket->status == 'en progreso' ? 'bg-yellow-100 text-yellow-800' :
                                            ($ticket->status == 'resuelto' ? 'bg-blue-100 text-blue-800' :
                                            ($ticket->status == 'cerrado' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800')))
        }}">
                                            {{ ucfirst($ticket->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-500">
                                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                                                {{
                                                    $ticket->priority == 'alta' ? 'bg-red-100 text-red-800' :
                                                    ($ticket->priority == 'media' ? 'bg-yellow-100 text-yellow-800' :
                                                    ($ticket->priority == 'baja' ? 'bg-green-100 text-green-800' :
                                                    ($ticket->priority == 'urgente' ? 'bg-orange-100 text-orange-800' : 'bg-gray-100 text-gray-800')))
                                                }}">
                                                {{ ucfirst($ticket->priority) }}
                                            </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-500">
                                        {{ $ticket->created_at->format('d/m/Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                        <div class="flex justify-center space-x-3">
                                            <a href="{{ route('tickets.show', $ticket->id) }}"
                                                class="text-blue-600 hover:text-blue-900 bg-blue-100 px-3 py-1 rounded-full transition duration-150 ease-in-out">
                                                <span class="flex items-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                    </svg>
                                                    Ver
                                                </span>
                                            </a>

                                            @if(Auth::user()->role === 'admin')
                                            <form id="delete-form-{{ $ticket->id }}"
                                                action="{{ route('tickets.destroy', $ticket->id) }}" method="POST"
                                                class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button"
                                                    onclick="confirmDelete({{ $ticket->id }}, '{{ $ticket->title }}')"
                                                    class="text-red-600 hover:text-red-900 bg-red-100 px-3 py-1 rounded-full transition duration-150 ease-in-out flex items-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                    Eliminar
                                                </button>
                                            </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Confirmation Modal -->
    <div id="deleteModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden flex items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-lg p-6 max-w-md w-full">
            <div class="mb-4 text-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-red-500 mx-auto" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                <h3 class="text-xl font-bold text-gray-900 mt-4">Confirmar eliminación</h3>
                <p class="text-sm text-gray-500 mt-2">¿Estás seguro de que deseas eliminar el ticket <span
                        id="ticketTitle" class="font-semibold"></span>? Esta acción no se puede deshacer.</p>
            </div>
            <div class="flex justify-center space-x-4">
                <button id="cancelDelete"
                    class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition duration-150 ease-in-out">
                    Cancelar
                </button>
                <button id="confirmDeleteBtn"
                    class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition duration-150 ease-in-out">
                    Eliminar
                </button>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script>
        let currentTicketId = null;
        const modal = document.getElementById('deleteModal');
        const ticketTitle = document.getElementById('ticketTitle');
        const cancelBtn = document.getElementById('cancelDelete');
        const confirmBtn = document.getElementById('confirmDeleteBtn');

        function confirmDelete(ticketId, title) {
            currentTicketId = ticketId;
            ticketTitle.textContent = title;
            modal.classList.remove('hidden');
        }

        cancelBtn.addEventListener('click', function() {
            modal.classList.add('hidden');
            currentTicketId = null;
        });

        confirmBtn.addEventListener('click', function() {
            if (currentTicketId) {
                document.getElementById('delete-form-' + currentTicketId).submit();
            }
        });

        // Close modal when clicking outside
        window.addEventListener('click', function(event) {
            if (event.target === modal) {
                modal.classList.add('hidden');
                currentTicketId = null;
            }
        });
    </script>
</x-app-layout>
