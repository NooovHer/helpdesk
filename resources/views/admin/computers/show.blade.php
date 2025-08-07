<x-app-layout>
    <div class="max-w-xl mx-auto py-8 px-4">
        <div class="bg-white shadow rounded-lg p-6">
            <h1 class="text-2xl font-bold text-gray-800 mb-4">Equipo: {{ $computer->computer_name }}</h1>
            <div class="mb-2"><span class="font-semibold">Serial:</span> {{ $computer->serial_number }}</div>
            <div class="mb-2"><span class="font-semibold">Modelo:</span> {{ $computer->model }}</div>
            <div class="mb-2"><span class="font-semibold">RAM:</span> {{ $computer->ram }}</div>
            <div class="mb-2"><span class="font-semibold">Procesador:</span> {{ $computer->processor }}</div>
            <div class="mb-2"><span class="font-semibold">Sistema Operativo:</span> {{ $computer->operating_system }}</div>
            <div class="flex justify-end gap-2 mt-6">
                <a href="{{ route('admin.computers.edit', $computer) }}" class="px-4 py-2 bg-yellow-500 text-white rounded-lg">Editar</a>
                <a href="{{ route('admin.computers.index') }}" class="px-4 py-2 bg-gray-200 rounded-lg">Volver</a>
            </div>
        </div>
    </div>
</x-app-layout>
