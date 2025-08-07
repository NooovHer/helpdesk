<x-app-layout>
    <div class="max-w-5xl mx-auto py-8 px-4">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Equipos de Cómputo</h1>
            <a href="{{ route('admin.computers.create') }}" class="px-4 py-2 bg-primary text-white rounded-lg hover:bg-hover transition">Nuevo equipo</a>
        </div>
        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 rounded">{{ session('success') }}</div>
        @endif
        <div class="bg-white shadow rounded-lg overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nombre</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Serial</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Modelo</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @forelse($computers as $computer)
                        <tr>
                            <td class="px-6 py-4">{{ $computer->computer_name }}</td>
                            <td class="px-6 py-4">{{ $computer->serial_number }}</td>
                            <td class="px-6 py-4">{{ $computer->model }}</td>
                            <td class="px-6 py-4 flex gap-2">
                                <a href="{{ route('admin.computers.show', $computer) }}" class="text-blue-600 hover:underline">Ver</a>
                                <a href="{{ route('admin.computers.edit', $computer) }}" class="text-yellow-600 hover:underline">Editar</a>
                                <form action="{{ route('admin.computers.destroy', $computer) }}" method="POST" onsubmit="return confirm('¿Eliminar equipo?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-center text-gray-500">No hay equipos registrados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
