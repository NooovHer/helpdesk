<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-primary leading-tight">
            {{ __('Portal de Soporte') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Banner de bienvenida -->
            <div class="mb-6 bg-primary rounded-lg shadow-md overflow-hidden">
                <div class="px-6 py-8 md:flex md:items-center md:justify-between">
                    <div class="text-white">
                        <h2 class="text-2xl font-bold">Bienvenido(a), {{ auth()->user()->username }}</h2>
                        <p class="mt-1">¿En qué podemos ayudarte hoy?</p>
                    </div>
                    <div class="mt-4 md:mt-0">
                        <a href="{{ route('tickets.create') }}"
                            class="inline-flex items-center px-5 py-3 bg-white text-primary font-semibold rounded-lg shadow hover:bg-gray-100 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                            </svg>
                            Crear Nuevo Ticket
                        </a>
                    </div>
                </div>
            </div>

            <!-- Acciones rápidas -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                <!-- Ver tickets -->
                <div class="bg-white overflow-hidden shadow-sm rounded-lg hover:shadow-md transition">
                    <a href="{{ route('tickets.index') }}" class="block p-6">
                        <div class="flex items-center">
                            <div class="bg-secondary/20 p-3 rounded-full">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-lg font-medium text-gray-900">Ver Todos los Tickets</p>
                                <p class="text-sm text-gray-500">Gestiona todos tus casos de soporte</p>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Crear ticket -->
                <div class="bg-white overflow-hidden shadow-sm rounded-lg hover:shadow-md transition">
                    <a href="{{ route('tickets.create') }}" class="block p-6">
                        <div class="flex items-center">
                            <div class="bg-primary/10 p-3 rounded-full">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-lg font-medium text-gray-900">Crear Nuevo Ticket</p>
                                <p class="text-sm text-gray-500">Solicita asistencia para un nuevo problema</p>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Centro de ayuda -->
                <div class="bg-white overflow-hidden shadow-sm rounded-lg hover:shadow-md transition">
                    <a href="#" class="block p-6">
                        <div class="flex items-center">
                            <div class="bg-secondary/20 p-3 rounded-full">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-secondary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-lg font-medium text-gray-900">Centro de Ayuda</p>
                                <p class="text-sm text-gray-500">Consulta preguntas frecuentes y guías</p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            <!-- Estado del sistema y contacto -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Estado del sistema -->
                <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                    <div class="border-b border-gray-200 bg-white px-4 py-5 sm:px-6">
                        <h3 class="text-lg font-medium text-primary">Estado del Sistema</h3>
                    </div>
                    <div class="p-6 space-y-4 text-sm text-gray-700">
                        @foreach(['Plataforma Principal', 'Sistema de Gestión', 'Base de Datos'] as $sistema)
                        <div class="flex items-center justify-between">
                            <span>{{ $sistema }}</span>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                <svg class="-ml-0.5 mr-1.5 h-2 w-2 text-green-500" fill="currentColor" viewBox="0 0 8 8">
                                    <circle cx="4" cy="4" r="3" />
                                </svg>
                                Operativo
                            </span>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Contacto directo -->
                <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                    <div class="border-b border-gray-200 bg-white px-4 py-5 sm:px-6">
                        <h3 class="text-lg font-medium text-primary">Contacto Directo</h3>
                    </div>
                    <div class="p-6 space-y-3 text-sm text-gray-700">
                        <p class="mb-4">Si necesitas asistencia inmediata, contáctanos por:</p>
                        <div class="flex items-center px-4 py-3 bg-gray-50 rounded-lg">
                            <svg class="h-5 w-5 mr-3 text-secondary" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" />
                            </svg>
                            <span>Teléfono: (800) 123-4567</span>
                        </div>
                        <div class="flex items-center px-4 py-3 bg-gray-50 rounded-lg">
                            <svg class="h-5 w-5 mr-3 text-secondary" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                            </svg>
                            <span>Email: soporte@empresa.com</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- FAQ -->
            <div class="mt-6 bg-white overflow-hidden shadow-sm rounded-lg">
                <div class="border-b border-gray-200 bg-white px-4 py-5 sm:px-6">
                    <h3 class="text-lg font-medium text-primary">Preguntas Frecuentes</h3>
                </div>
                <div class="p-6 space-y-4">
                    @foreach([
                    ['¿Cuánto tiempo tarda la resolución de un ticket?', 'El tiempo promedio de resolución es de 24-48 horas dependiendo de la complejidad del problema.'],
                    ['¿Puedo cancelar un ticket enviado?', 'Sí, puedes cerrar un ticket en cualquier momento desde la vista de detalles del ticket.'],
                    ['¿Cómo puedo actualizar la información de un ticket?', 'Puedes añadir comentarios o actualizar la información desde la sección de detalles del ticket.']
                    ] as [$titulo, $contenido])
                    <div class="border-l-4 border-primary pl-4">
                        <h4 class="text-sm font-medium text-gray-900">{{ $titulo }}</h4>
                        <p class="mt-1 text-sm text-gray-500">{{ $contenido }}</p>
                    </div>
                    @endforeach
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
