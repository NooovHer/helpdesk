<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Ticket') }} #{{ $ticket->id }}
            </h2>
        </div>
    </x-slot>
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <!-- Encabezado del ticket -->
            <div class="bg-gradient-to-r from-primary to-red-500 px-6 py-4">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center">
                    <div class="flex-1">
                        <h1 class="text-xl md:text-2xl font-bold text-white">
                            {{ $ticket->title }}
                        </h1>
                        <p class="text-white mt-1">Creado
                            {{ \Carbon\Carbon::parse($ticket->created_at)->diffForHumans() }}
                        </p>
                    </div>
                    <div class="flex flex-wrap gap-2 mt-4 md:mt-0">
                        @if($ticket->status != 'closed')
                        <a href="{{ route('tickets.edit', $ticket) }}"
                            class="inline-flex items-center px-4 py-2 bg-white text-primary rounded-md font-medium shadow hover:bg-red-50 transition-colors duration-150">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 0L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            Editar
                        </a>
                        @endif
                        <a href="{{ route('tickets.index') }}"
                            class="inline-flex items-center px-4 py-2 bg-white bg-opacity-20 text-white rounded-md font-medium hover:bg-opacity-30 transition-colors duration-150">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            Volver
                        </a>
                    </div>
                </div>
            </div>

            <div class="p-6">
                <!-- Información del ticket -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <div class="bg-gray-50 rounded-lg p-5 border border-gray-100">
                        <h2 class="text-lg font-semibold text-gray-800 mb-4">Detalles del ticket</h2>
                        <div class="space-y-3">
                            <div class="flex items-center">
                                <span class="text-gray-600 w-24">Estado:</span>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                {{ $ticket->status == 'nuevo' ? 'bg-green-100 text-green-800' :
                                    ($ticket->status == 'en progreso' ? 'bg-yellow-100 text-yellow-800' :
                                    ($ticket->status == 'resuelto' ? 'bg-blue-100 text-blue-800' :
                                    ($ticket->status == 'cerrado' ? 'bg-red-100 text-red-800' :
                                    'bg-gray-100 text-gray-800'))) }}">
                                    {{ ucfirst(str_replace('_', ' ', $ticket->status)) }}
                                </span>
                            </div>
                            <div class="flex items-center">
                                <span class="text-gray-600 w-24">Prioridad:</span>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                {{ $ticket->priority == 'alta' ? 'bg-red-100 text-red-800' :
                                ($ticket->priority == 'media' ? 'bg-yellow-100 text-yellow-800' :
                                ($ticket->priority == 'baja' ? 'bg-green-100 text-green-800' :
                                ($ticket->priority == 'urgente' ? 'bg-orange-100 text-orange-800' :
                                'bg-blue-100 text-blue-800'))) }}">
                                    {{ ucfirst($ticket->priority) }}
                                </span>
                            </div>
                            <div class="flex items-center">
                                <span class="text-gray-600 w-28">Departamento:</span>
                                <span class="text-gray-900">{{ $ticket->department->name ?? 'N/A' }}</span>
                            </div>
                            <div class="flex items-center">
                                <span class="text-gray-600 w-24">Categoría:</span>
                                <span class="text-gray-900">{{ $ticket->category->name }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gray-50 rounded-lg p-5 border border-gray-100">
                        <h2 class="text-lg font-semibold text-gray-800 mb-4">Asignación</h2>
                        <div class="space-y-3">
                            <div class="flex items-center">
                                <span class="text-gray-600 w-28">Creado por:</span>
                                <span class="text-gray-900">{{ $ticket->creator->username ?? 'N/A' }}</span>

                            </div>
                            <div class="flex items-center">
                                <span class="text-gray-600 w-28">Asignado a:</span>
                                <span class="text-gray-900">{{ $ticket->assignedTo->username ?? 'No asignado' }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Descripción -->
                <div class="mb-8">
                    <h2 class="text-lg font-semibold text-gray-800 mb-3">Descripción</h2>
                    <div class="bg-gray-50 rounded-lg p-5 border border-gray-100">
                        <div class="prose max-w-none">
                            {!! nl2br(e($ticket->description)) !!}
                        </div>
                    </div>
                </div>

                @php
                $attachments = json_decode($ticket->attachments, true);
                function isImageFile($filename) {
                $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
                return in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp', 'bmp']);
                }
                @endphp

                @if(!empty($attachments))
                <div class="mb-8">
                    <h2 class="text-lg font-semibold text-gray-800 mb-3">Archivos adjuntos</h2>
                    <div class="bg-gray-50 rounded-lg p-5 border border-gray-100">
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3">
                            @foreach($attachments as $attachment)
                            @if(isImageFile($attachment))
                            <div class="border border-gray-200 rounded-md overflow-hidden hover:shadow-md transition-all duration-200">
                                <div class="relative pb-[60%] bg-gray-100">
                                    <img src="{{ Storage::url($attachment) }}"
                                        alt="{{ basename($attachment) }}"
                                        class="absolute inset-0 w-full h-full object-cover image-thumbnail"
                                        data-src="{{ Storage::url($attachment) }}"
                                        data-filename="{{ basename($attachment) }}">
                                </div>
                                <div class="p-2 bg-white">
                                    <p class="text-xs text-gray-700 truncate">{{ basename($attachment) }}</p>
                                </div>
                            </div>
                            @else
                            <a href="{{ Storage::url($attachment) }}" target="_blank"
                                class="flex items-center p-3 rounded-md hover:bg-gray-100 border border-gray-200 group transition-colors duration-150">
                                <div class="bg-indigo-100 p-2 rounded-md mr-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-600" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                                    </svg>
                                </div>
                                <div class="text-sm text-gray-700 truncate group-hover:text-primary">
                                    {{ basename($attachment) }}
                                </div>
                            </a>
                            @endif
                            @endforeach
                        </div>
                    </div>
                </div>
                @elseif(!empty($ticket->attachments))
                <div class="mb-8">
                    <h2 class="text-lg font-semibold text-gray-800 mb-3">Archivos adjuntos</h2>
                    <div class="bg-gray-50 rounded-lg p-5 border border-gray-100">
                        <p class="text-gray-500">Error al cargar los archivos adjuntos. Formato no válido.</p>
                    </div>
                </div>
                @endif

                <!-- Resolución -->
                @if($ticket->resolved_at)
                <div class="mb-8">
                    <h2 class="text-lg font-semibold text-gray-800 mb-3">Resolución</h2>
                    <div class="bg-gray-50 rounded-lg p-5 border border-gray-100">
                        <div class="mb-4">
                            <span class="text-gray-600">Fecha de resolución:</span>
                            <span
                                class="text-gray-900 ml-2">{{ \Carbon\Carbon::parse($ticket->resolved_at)->format('d/m/Y H:i') }}</span>
                        </div>
                        <div>
                            <span class="text-gray-600 block mb-2">Notas de resolución:</span>
                            <div class="prose max-w-none">
                                {!! nl2br(e($ticket->resolution_notes)) !!}
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Información adicional -->
                <div class="mb-8">
                    <h2 class="text-lg font-semibold text-gray-800 mb-3">Información adicional</h2>
                    <div class="bg-gray-50 rounded-lg p-5 border border-gray-100">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <span class="text-gray-600">Creado el:</span>
                                <span
                                    class="text-gray-900 ml-2">{{ \Carbon\Carbon::parse($ticket->created_at)->format('d/m/Y H:i') }}</span>
                            </div>
                            <div>
                                <span class="text-gray-600">Última actualización:</span>
                                <span
                                    class="text-gray-900 ml-2">{{ \Carbon\Carbon::parse($ticket->updated_at)->format('d/m/Y H:i') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Formulario de resolución -->
                @if($ticket->status != 'closed' && (auth()->user()->role == 'manager' || auth()->user()->role == 'admin'))
                <div class="bg-gray-200 rounded-lg p-6 border border-gray-300">
                    <h2 class="text-lg font-semibold text-primary mb-4">Marcar como resuelto</h2>
                    <form action="{{ route('tickets.update', $ticket) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="status" value="closed">
                        <div class="mb-4">
                            <label for="resolution_notes" class="block text-sm font-medium text-primary mb-2">Notas
                                de resolución</label>
                            <textarea id="resolution_notes" name="resolution_notes" rows="4"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                                placeholder="Describe cómo se resolvió el ticket...">{{ $ticket->resolution_notes }}</textarea>
                        </div>
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 bg-primary text-white rounded-md font-medium shadow-sm hover:bg-hover focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition-colors duration-150">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            Resolver ticket
                        </button>
                    </form>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Modal para vista previa de imágenes -->
    <div id="imageModal" class="fixed inset-0 bg-black bg-opacity-75 z-50 hidden flex items-center justify-center">
        <div class="max-w-4xl w-full mx-4 bg-white rounded-lg overflow-hidden shadow-xl">
            <div class="bg-gray-100 px-4 py-3 border-b border-gray-200 flex justify-between items-center">
                <h3 class="text-lg font-medium text-gray-900" id="modal-title">Vista previa</h3>
                <button id="closeModalBtn" type="button" class="text-gray-400 hover:text-gray-500">
                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div class="bg-gray-50 p-6 flex items-center justify-center">
                <img id="modalImage" src="" alt="Imagen" class="max-h-[70vh] max-w-full object-contain">
            </div>
            <div class="bg-gray-100 px-4 py-3 border-t border-gray-200 flex justify-between">
                <a id="downloadBtn" href="" download class="inline-flex items-center px-4 py-2 bg-primary text-white rounded-md font-medium shadow hover:bg-hover transition-colors duration-150">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                    </svg>
                    Descargar
                </a>
                <a id="openNewTabBtn" href="" target="_blank" class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray-800 rounded-md font-medium shadow hover:bg-gray-300 transition-colors duration-150">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                    </svg>
                    Abrir en nueva pestaña
                </a>
            </div>
        </div>
    </div>
</x-app-layout>

<!-- Añadir esto justo antes del cierre del body -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Seleccionamos todos los thumbnails de imágenes
        const thumbnails = document.querySelectorAll('.image-thumbnail');
        const modal = document.getElementById('imageModal');
        const modalImage = document.getElementById('modalImage');
        const modalTitle = document.getElementById('modal-title');
        const closeModalBtn = document.getElementById('closeModalBtn');
        const downloadBtn = document.getElementById('downloadBtn');
        const openNewTabBtn = document.getElementById('openNewTabBtn');

        // Asignamos evento click a cada thumbnail
        thumbnails.forEach(function(thumbnail) {
            thumbnail.addEventListener('click', function() {
                const imageSrc = this.getAttribute('data-src');
                const filename = this.getAttribute('data-filename');

                // Actualizamos el contenido del modal
                modalImage.src = imageSrc;
                modalTitle.textContent = filename;
                downloadBtn.href = imageSrc;
                openNewTabBtn.href = imageSrc;

                // Mostramos el modal
                modal.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            });
        });

        // Cerrar el modal al hacer clic en el botón de cerrar
        closeModalBtn.addEventListener('click', function() {
            modal.classList.add('hidden');
            document.body.style.overflow = '';
        });

        // Cerrar el modal al hacer clic fuera del contenido
        modal.addEventListener('click', function(event) {
            if (event.target === modal) {
                modal.classList.add('hidden');
                document.body.style.overflow = '';
            }
        });

        // Cerrar el modal con la tecla Escape
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape' && !modal.classList.contains('hidden')) {
                modal.classList.add('hidden');
                document.body.style.overflow = '';
            }
        });
    });
</script>
