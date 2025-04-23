<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Crear Nuevo Ticket') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                <p>{{ session('success') }}</p>
            </div>
            @endif

            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg border border-gray-100">
                <div class="p-8 text-gray-900">

                    <h3 class="text-xl font-bold mb-6 text-primary border-b pb-2 border-gray-200">Nuevo Ticket</h3>

                    <!-- Formulario de creación de ticket -->
                    <form action="{{ route('tickets.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf

                        <!-- Título -->
                        <div class="mb-4">
                            <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Título</label>
                            <input type="text" name="title" id="title"
                                class="block w-full border border-gray-300 rounded-md shadow-sm p-3 focus:ring-2 focus:ring-primary focus:border-primary transition"
                                value="{{ old('title') }}" required placeholder="Ingrese un título descriptivo">
                            @error('title')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Descripción -->
                        <div class="mb-4">
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Descripción</label>
                            <textarea name="description" id="description" rows="5"
                                class="block w-full border border-gray-300 rounded-md shadow-sm p-3 focus:ring-2 focus:ring-primary focus:border-primary transition"
                                required placeholder="Describa detalladamente su problema o solicitud">{{ old('description') }}</textarea>
                            @error('description')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Prioridad -->
                            <div>
                                <label for="priority" class="block text-sm font-medium text-gray-700 mb-1">Prioridad</label>
                                <select name="priority" id="priority"
                                    class="block w-full border border-gray-300 rounded-md shadow-sm p-3 focus:ring-2 focus:ring-primary focus:border-primary transition">
                                    <option value="baja" {{ old('priority') == 'baja' ? 'selected' : '' }}>Baja</option>
                                    <option value="media" {{ old('priority') == 'media' ? 'selected' : '' }}>Media</option>
                                    <option value="alta" {{ old('priority') == 'alta' ? 'selected' : '' }}>Alta</option>
                                    <option value="urgente" {{ old('priority') == 'urgente' ? 'selected' : '' }}>Urgente</option>
                                </select>
                                @error('priority')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Departamento -->
                            <div>
                                <label for="department_id" class="block text-sm font-medium text-gray-700 mb-1">Departamento</label>
                                <select name="department_id" id="department_id"
                                    class="block w-full border border-gray-300 rounded-md shadow-sm p-3 focus:ring-2 focus:ring-primary focus:border-primary transition">
                                    <option value="">Seleccionar departamento...</option>
                                    @foreach ($departments as $department)
                                    <option value="{{ $department->id }}"
                                        {{ old('department_id') == $department->id ? 'selected' : '' }}>
                                        {{ $department->name }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('department_id')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Categoría -->
                        <div class="mb-4">
                            <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1">Categoría</label>
                            <select name="category_id" id="category_id"
                                class="block w-full border border-gray-300 rounded-md shadow-sm p-3 focus:ring-2 focus:ring-primary focus:border-primary transition">
                                <option value="">Seleccionar categoría...</option>
                                @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                                @endforeach
                            </select>
                            @error('category_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Archivo adjunto -->
                        <div class="mb-6">
                            <label for="attachments" class="block text-sm font-medium text-gray-700 mb-1">Adjuntar Archivos</label>
                            <div id="drag-drop-area" class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-dashed border-gray-300 rounded-md">
                                <div class="space-y-1 text-center">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <div class="flex text-sm text-gray-600">
                                        <label for="attachments" class="relative cursor-pointer bg-white rounded-md font-medium text-primary hover:text-hover focus-within:outline-none">
                                            <span>Seleccionar archivos</span>
                                            <input id="attachments" name="attachments[]" type="file" class="sr-only" multiple>
                                        </label>
                                        <p class="pl-1">o arrastrar y soltar</p>
                                    </div>
                                    <p class="text-xs text-gray-500">
                                        PNG, JPG, PDF hasta 10MB (Puede seleccionar varios archivos)
                                    </p>
                                </div>
                            </div>
                            @error('attachments')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                            @error('attachments.*')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror

                            <!-- Previsualización de archivos -->
                            <div id="file-preview" class="mt-3 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3"></div>
                        </div>

                        <!-- Botón de enviar -->
                        <div class="flex justify-end pt-4">
                            <a href="{{ route('tickets.index') }}" class="mr-2 px-4 py-2 bg-secondary text-white rounded-lg hover:bg-opacity-80 transition">
                                Cancelar
                            </a>
                            <button type="submit"
                                class="px-6 py-2 bg-primary text-white font-medium rounded-lg hover:bg-hover transition shadow-sm">
                                Crear Ticket
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Script para previsualización de archivos -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const dragDropArea = document.getElementById('drag-drop-area');
            const attachmentsInput = document.getElementById('attachments');
            const preview = document.getElementById('file-preview');

            // Hacer que el área de arrastre acepte archivos
            dragDropArea.addEventListener('dragover', function(event) {
                event.preventDefault(); // Evitar que el archivo se abra
                dragDropArea.classList.add('bg-gray-100');
            });

            dragDropArea.addEventListener('dragleave', function() {
                dragDropArea.classList.remove('bg-gray-100');
            });

            dragDropArea.addEventListener('drop', function(event) {
                event.preventDefault();
                dragDropArea.classList.remove('bg-gray-100');
                const files = event.dataTransfer.files;
                handleFiles(files);
            });

            // Cuando se seleccionan archivos por el input
            attachmentsInput.addEventListener('change', function(e) {
                const files = e.target.files;
                handleFiles(files);
            });

            // Función para manejar los archivos (previsualización y subida)
            function handleFiles(files) {
                if (files.length > 0) {
                    Array.from(files).forEach(file => {
                        if (!isValidFileType(file)) {
                            alert(`El archivo "${file.name}" no es un tipo permitido. Solo se aceptan PNG, JPG y PDF.`);
                            return;
                        }

                        const fileDiv = document.createElement('div');
                        fileDiv.className = 'p-2 border rounded-md flex items-center';

                        // Icono según tipo de archivo
                        let icon = `<svg class="w-6 h-6 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>`;

                        if (file.type.startsWith('image/')) {
                            const img = document.createElement('img');
                            img.className = 'w-6 h-6 mr-2 object-cover';
                            img.file = file;

                            const reader = new FileReader();
                            reader.onload = (function(aImg) {
                                return function(e) {
                                    aImg.src = e.target.result;
                                };
                            })(img);
                            reader.readAsDataURL(file);

                            fileDiv.appendChild(img);
                        } else if (file.type === 'application/pdf') {
                            icon = `<svg class="w-6 h-6 mr-2 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8l-6-6z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 2v6h6"></path></svg>`;
                            fileDiv.innerHTML = icon;
                        } else {
                            fileDiv.innerHTML = icon;
                        }

                        // Nombre del archivo
                        const fileName = document.createElement('span');
                        fileName.className = 'text-sm truncate flex-1';
                        fileName.textContent = file.name;
                        fileDiv.appendChild(fileName);

                        // Tamaño del archivo
                        const fileSize = document.createElement('span');
                        fileSize.className = 'text-xs text-gray-500 ml-2';
                        fileSize.textContent = formatBytes(file.size);
                        fileDiv.appendChild(fileSize);

                        // Botón para eliminar archivo
                        const removeBtn = document.createElement('button');
                        removeBtn.className = 'ml-2 text-red-500 hover:text-red-700';
                        removeBtn.innerHTML = `<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>`;
                        removeBtn.type = 'button';
                        removeBtn.onclick = function() {
                            fileDiv.remove();
                        };
                        fileDiv.appendChild(removeBtn);

                        // Añadir la vista previa del archivo a la lista
                        preview.appendChild(fileDiv);
                    });
                }
            }

            function isValidFileType(file) {
                const allowedTypes = ['image/png', 'image/jpeg', 'application/pdf'];
                return allowedTypes.includes(file.type);
            }

            function formatBytes(bytes, decimals = 2) {
                if (bytes === 0) return '0 Bytes';

                const k = 1024;
                const dm = decimals < 0 ? 0 : decimals;
                const sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];

                const i = Math.floor(Math.log(bytes) / Math.log(k));

                return parseFloat((bytes / Math.pow(k, i)).toFixed(dm)) + ' ' + sizes[i];
            }
        });
    </script>
</x-app-layout>
