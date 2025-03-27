<x-app-layout>
    <div class="bg-gray-100 min-h-screen">
        <div class="container mx-auto px-4 py-8">
            <div class="flex justify-between items-center mb-8">
                <h1 class="text-3xl font-bold text-primary">
                    <i class="fas fa-home mr-2"></i>Mi Panel
                </h1>
                <div class="flex items-center space-x-4">
                    <span class="text-gray-700">
                        Bienvenido, {{ Auth::user()->name ?? 'Usuario' }}
                    </span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-primary hover:text-primary/80">
                            <i class="fas fa-sign-out-alt"></i>
                        </button>
                    </form>
                </div>
            </div>

            <div class="grid md:grid-cols-2 gap-6">
                <!-- Crear Nuevo Ticket -->
                <div class="bg-white shadow-md rounded-lg p-6">
                    <h2 class="text-xl font-semibold mb-4 text-primary">
                        <i class="fas fa-plus-circle mr-2"></i>Crear Nuevo Ticket
                    </h2>
                    <p class="text-gray-600 mb-4">¿Necesitas ayuda con algo?</p>
                    <button class="w-full bg-primary text-white py-2 rounded-lg hover:bg-primary/90 transition">
                        Crear Ticket
                    </button>
                </div>

                <!-- Mis Tickets Recientes -->
                <div class="bg-white shadow-md rounded-lg p-6">
                    <h2 class="text-xl font-semibold mb-4 text-primary">
                        <i class="fas fa-ticket-alt mr-2"></i>Mis Tickets Recientes
                    </h2>
                    <div class="space-y-3">
                        <div class="flex justify-between items-center border-b pb-2">
                            <div>
                                <p class="font-medium">Problema con impresora</p>
                                <span class="text-sm text-secondary">Hace 2 días</span>
                            </div>
                            <span class="text-green-600 bg-green-100 px-2 py-1 rounded-full text-xs">
                                Resuelto
                            </span>
                        </div>
                        <div class="flex justify-between items-center border-b pb-2">
                            <div>
                                <p class="font-medium">Acceso a software</p>
                                <span class="text-sm text-secondary">Hace 5 días</span>
                            </div>
                            <span class="text-yellow-600 bg-yellow-100 px-2 py-1 rounded-full text-xs">
                                En Progreso
                            </span>
                        </div>
                        <div class="text-center mt-4">
                            <a href="#" class="text-primary hover:text-primary/80">
                                Ver todos los tickets
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Recursos de Ayuda -->
                <div class="bg-white shadow-md rounded-lg p-6">
                    <h2 class="text-xl font-semibold mb-4 text-primary">
                        <i class="fas fa-info-circle mr-2"></i>Recursos de Ayuda
                    </h2>
                    <ul class="space-y-3">
                        <li>
                            <a href="#" class="text-secondary hover:text-primary transition">
                                <i class="fas fa-book mr-2"></i>Base de Conocimientos
                            </a>
                        </li>
                        <li>
                            <a href="#" class="text-secondary hover:text-primary transition">
                                <i class="fas fa-video mr-2"></i>Tutoriales
                            </a>
                        </li>
                        <li>
                            <a href="#" class="text-secondary hover:text-primary transition">
                                <i class="fas fa-headset mr-2"></i>Contactar Soporte
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Notificaciones -->
                <div class="bg-white shadow-md rounded-lg p-6">
                    <h2 class="text-xl font-semibold mb-4 text-primary">
                        <i class="fas fa-bell mr-2"></i>Notificaciones
                    </h2>
                    <div class="space-y-3">
                        <div class="bg-blue-50 p-3 rounded-lg">
                            <p class="text-sm">Tu ticket #245 ha sido actualizado</p>
                            <span class="text-xs text-secondary">Hace 1 hora</span>
                        </div>
                        <div class="bg-blue-50 p-3 rounded-lg">
                            <p class="text-sm">Nuevo tutorial disponible</p>
                            <span class="text-xs text-secondary">Hace 3 horas</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('styles')
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
        <style>
            /* Agrega aquí cualquier estilo adicional */
        </style>
    @endpush

    @push('scripts')
        <script>
            // Configuración de Tailwind (puedes moverlo a tu configuración de Tailwind si lo prefieres)
            tailwind.config = {
                theme: {
                    extend: {
                        colors: {
                            'primary': '#cc1939',
                            'secondary': '#8a8e91'
                        }
                    }
                }
            }
        </script>
    @endpush
</x-app-layout>
