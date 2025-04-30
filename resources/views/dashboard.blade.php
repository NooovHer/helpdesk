<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Acceso a los tickets -->
            <div class="mb-4">
                <a href="{{ route('tickets.index') }}"
                    class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                    📋 Ver Todos los Tickets
                </a>
            </div>

            <!-- Botón para crear un nuevo ticket -->
            <div class="mb-4">
                <a href="{{ route('tickets.create') }}"
                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                    + Crear Ticket
                </a>
            </div>

        </div>
    </div>
</x-app-layout>
