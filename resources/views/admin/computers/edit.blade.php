<x-app-layout>
    <div class="max-w-xl mx-auto py-8 px-4">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Editar equipo</h1>
        <form action="{{ route('admin.computers.update', $computer) }}" method="POST" class="space-y-5 bg-white shadow rounded-lg p-6">
            @csrf
            @method('PUT')
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nombre del equipo</label>
                <input type="text" name="computer_name" value="{{ old('computer_name', $computer->computer_name) }}" class="w-full border border-gray-300 rounded-lg px-3 py-2" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Serial</label>
                <input type="text" name="serial_number" value="{{ old('serial_number', $computer->serial_number) }}" class="w-full border border-gray-300 rounded-lg px-3 py-2">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Modelo</label>
                <input type="text" name="model" value="{{ old('model', $computer->model) }}" class="w-full border border-gray-300 rounded-lg px-3 py-2">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">RAM</label>
                <input type="text" name="ram" value="{{ old('ram', $computer->ram) }}" class="w-full border border-gray-300 rounded-lg px-3 py-2">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Procesador</label>
                <input type="text" name="processor" value="{{ old('processor', $computer->processor) }}" class="w-full border border-gray-300 rounded-lg px-3 py-2">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Sistema Operativo</label>
                <input type="text" name="operating_system" value="{{ old('operating_system', $computer->operating_system) }}" class="w-full border border-gray-300 rounded-lg px-3 py-2">
            </div>
            <div class="flex justify-end gap-2">
                <a href="{{ route('admin.computers.index') }}" class="px-4 py-2 bg-gray-200 rounded-lg">Cancelar</a>
                <button type="submit" class="px-6 py-2 bg-primary text-white rounded-lg">Actualizar</button>
            </div>
        </form>
    </div>
</x-app-layout>
