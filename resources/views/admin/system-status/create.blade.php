<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-6">
                <a href="{{ route('admin.system-status.index') }}"
                   class="text-purple-600 hover:text-purple-800 flex items-center gap-2">
                    <i class="fas fa-arrow-left"></i>
                    Volver a la lista
                </a>
            </div>

            <div class="bg-white shadow-lg rounded-lg p-6">
                <h1 class="text-2xl font-bold text-gray-900 mb-6">Agregar Nuevo Servicio</h1>

                <form action="{{ route('admin.system-status.store') }}" method="POST">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="service_name" class="block text-sm font-medium text-gray-700 mb-2">
                                Nombre del Servicio *
                            </label>
                            <input type="text"
                                   name="service_name"
                                   id="service_name"
                                   value="{{ old('service_name') }}"
                                   class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-purple-500"
                                   placeholder="Ej: Plataforma Principal, Base de Datos, etc."
                                   required>
                            @error('service_name')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                                Estado Inicial *
                            </label>
                            <select name="status"
                                    id="status"
                                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-purple-500"
                                    required>
                                <option value="">Seleccionar estado</option>
                                <option value="operational" {{ old('status') == 'operational' ? 'selected' : '' }}>
                                    Operativo
                                </option>
                                <option value="degraded" {{ old('status') == 'degraded' ? 'selected' : '' }}>
                                    Degradado
                                </option>
                                <option value="outage" {{ old('status') == 'outage' ? 'selected' : '' }}>
                                    Fuera de Servicio
                                </option>
                                <option value="maintenance" {{ old('status') == 'maintenance' ? 'selected' : '' }}>
                                    Mantenimiento
                                </option>
                            </select>
                            @error('status')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-6">
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                            Descripción (opcional)
                        </label>
                        <textarea name="description"
                                  id="description"
                                  rows="4"
                                  class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-purple-500"
                                  placeholder="Describe el servicio o proporciona información adicional...">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mt-6 flex justify-end gap-3">
                        <a href="{{ route('admin.system-status.index') }}"
                           class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">
                            Cancelar
                        </a>
                        <button type="submit"
                                class="px-4 py-2 bg-purple-600 text-white rounded-md hover:bg-purple-700">
                            Crear Servicio
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
