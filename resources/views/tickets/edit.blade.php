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
                            Editar Ticket #{{ $ticket->id }}
                        </h1>
                        <p class="text-white mt-1">Última actualización {{ \Carbon\Carbon::parse($ticket->updated_at)->diffForHumans() }}</p>
                    </div>
                    <div class="flex flex-wrap gap-2 mt-4 md:mt-0">
                        <a href="{{ route('tickets.show', $ticket) }}" class="inline-flex items-center px-4 py-2 bg-white bg-opacity-20 text-white rounded-md font-medium hover:bg-opacity-30 transition-colors duration-150">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            Volver
                        </a>
                    </div>
                </div>
            </div>

            <div class="p-6">
                <form action="{{ route('tickets.update', $ticket) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Información principal -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Título</label>
                            <input type="text" id="title" name="title" value="{{ old('title', $ticket->title) }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('title') border-red-500 @enderror">
                            @error('title')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="category" class="block text-sm font-medium text-gray-700 mb-1">Categoría</label>
                            <select id="category" name="category"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('category') border-red-500 @enderror">
                                <option value="hardware" {{ old('category', $ticket->category) == 'hardware' ? 'selected' : '' }}>Hardware</option>
                                <option value="software" {{ old('category', $ticket->category) == 'software' ? 'selected' : '' }}>Software</option>
                                <option value="network" {{ old('category', $ticket->category) == 'network' ? 'selected' : '' }}>Red</option>
                                <option value="access" {{ old('category', $ticket->category) == 'access' ? 'selected' : '' }}>Acceso</option>
                                <option value="other" {{ old('category', $ticket->category) == 'other' ? 'selected' : '' }}>Otro</option>
                            </select>
                            @error('category')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Estado y prioridad -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Estado</label>
                            <select id="status" name="status"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('status') border-red-500 @enderror">
                                <option value="open" {{ old('status', $ticket->status) == 'open' ? 'selected' : '' }}>Abierto</option>
                                <option value="in_progress" {{ old('status', $ticket->status) == 'in_progress' ? 'selected' : '' }}>En progreso</option>
                                <option value="pending" {{ old('status', $ticket->status) == 'pending' ? 'selected' : '' }}>Pendiente</option>
                                <option value="resolved" {{ old('status', $ticket->status) == 'resolved' ? 'selected' : '' }}>Resuelto</option>
                                <option value="closed" {{ old('status', $ticket->status) == 'closed' ? 'selected' : '' }}>Cerrado</option>
                            </select>
                            @error('status')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="priority" class="block text-sm font-medium text-gray-700 mb-1">Prioridad</label>
                            <select id="priority" name="priority"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('priority') border-red-500 @enderror">
                                <option value="low" {{ old('priority', $ticket->priority) == 'low' ? 'selected' : '' }}>Baja</option>
                                <option value="medium" {{ old('priority', $ticket->priority) == 'medium' ? 'selected' : '' }}>Media</option>
                                <option value="high" {{ old('priority', $ticket->priority) == 'high' ? 'selected' : '' }}>Alta</option>
                            </select>
                            @error('priority')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="department_id" class="block text-sm font-medium text-gray-700 mb-1">Departamento</label>
                            <select id="department_id" name="department_id"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('department_id') border-red-500 @enderror">
                                <option value="">Seleccionar departamento</option>
                                @foreach($departments ?? [] as $department)
                                <option value="{{ $department->id }}" {{ old('department_id', $ticket->department_id) == $department->id ? 'selected' : '' }}>
                                    {{ $department->name }}
                                </option>
                                @endforeach
                            </select>
                            @error('department_id')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Descripción -->
                    <div class="mb-6">
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Descripción</label>
                        <textarea id="description" name="description" rows="6"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('description') border-red-500 @enderror">{{ old('description', $ticket->description) }}</textarea>
                        @error('description')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Asignación -->
                    <div class="mb-6">
                        <label for="assigned_by" class="block text-sm font-medium text-gray-700 mb-1">Asignar a</label>
                        <select id="assigned_by" name="assigned_by"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('assigned_by') border-red-500 @enderror">
                            <option value="">Sin asignar</option>
                            @foreach($users ?? [] as $user)
                            <option value="{{ $user->id }}" {{ old('assigned_by', $ticket->assigned_by) == $user->id ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                            @endforeach
                        </select>
                        @error('assigned_by')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Archivos adjuntos -->
                    <div class="mb-8">
                        <label for="attachments" class="block text-sm font-medium text-gray-700 mb-1">Archivos adjuntos</label>
                        <input type="file" id="attachments" name="attachments[]" multiple
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('attachments') border-red-500 @enderror">
                        <p class="text-gray-500 text-xs mt-1">Puede seleccionar múltiples archivos</p>
                        @error('attachments')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror

                        @if($ticket->attachments && ($attachments = json_decode($ticket->attachments)) && is_array($attachments) && count($attachments) > 0)
                        <div class="mt-4">
                            <p class="text-sm font-medium text-gray-700 mb-2">Archivos adjuntos actuales:</p>
                            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3">
                                @foreach($attachments as $index => $attachment)
                                <div class="flex items-center justify-between p-3 rounded-md border border-gray-200">
                                    <div class="flex items-center">
                                        <div class="bg-indigo-100 p-2 rounded-md mr-3">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                                            </svg>
                                        </div>
                                        <div class="text-sm text-gray-700 truncate">
                                            {{ $attachment }}
                                        </div>
                                    </div>
                                    <div class="ml-2">
                                        <label class="inline-flex items-center">
                                            <input type="checkbox" name="remove_attachments[]" value="{{ $attachment }}" class="form-checkbox h-4 w-4 text-indigo-600">
                                            <span class="ml-2 text-sm text-gray-600">Eliminar</span>
                                        </label>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endif
                    </div>

                    <!-- Resolución -->
                    <div class="mb-8">
                        <h2 class="text-lg font-semibold text-gray-800 mb-3">Resolución</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
                            <div>
                                <label for="resolved_at" class="block text-sm font-medium text-gray-700 mb-1">Fecha de resolución</label>
                                <input type="datetime-local" id="resolved_at" name="resolved_at"
                                    value="{{ old('resolved_at', $ticket->resolved_at ? date('Y-m-d\TH:i', strtotime($ticket->resolved_at)) : '') }}"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('resolved_at') border-red-500 @enderror">
                                @error('resolved_at')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div>
                            <label for="resolution_notes" class="block text-sm font-medium text-gray-700 mb-1">Notas de resolución</label>
                            <textarea id="resolution_notes" name="resolution_notes" rows="4"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('resolution_notes') border-red-500 @enderror">{{ old('resolution_notes', $ticket->resolution_notes) }}</textarea>
                            @error('resolution_notes')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Información adicional -->
                    <div class="bg-gray-50 rounded-lg p-5 border border-gray-100 mb-8">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <span class="text-gray-600">Creado por:</span>
                                <span class="text-gray-900 ml-2">{{ $ticket->createdBy->name ?? 'N/A' }}</span>
                            </div>
                            <div>
                                <span class="text-gray-600">Creado el:</span>
                                <span class="text-gray-900 ml-2">{{ \Carbon\Carbon::parse($ticket->created_at)->format('d/m/Y H:i') }}</span>
                            </div>
                            <div>
                                <span class="text-gray-600">Última actualización:</span>
                                <span class="text-gray-900 ml-2">{{ \Carbon\Carbon::parse($ticket->updated_at)->format('d/m/Y H:i') }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Botones de acción -->
                    <div class="flex flex-col sm:flex-row justify-between gap-4">
                        <button type="submit" class="inline-flex items-center justify-center px-6 py-3 bg-indigo-600 text-white rounded-md font-medium shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-150">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Guardar cambios
                        </button>

                        @if($ticket->status != 'closed')
                        <button type="submit" name="action" value="close" class="inline-flex items-center justify-center px-6 py-3 bg-red-600 text-white rounded-md font-medium shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors duration-150">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            Cerrar ticket
                        </button>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
