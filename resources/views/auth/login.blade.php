<x-guest-layout>
    <div class="relative min-h-screen flex items-center justify-center overflow-hidden">
        <div id="particles-js"></div>

        <div class="w-full max-w-md px-4 login-card">
            <div class="bg-white shadow-2xl rounded-2xl overflow-hidden border-t-4 border-primary">
                <div class="p-8">
                    <div class="text-center mb-8">
                        <div class="flex justify-center mb-4">
                            <div class="p-4 rounded-full bg-primary/10">
                                <i class="fas fa-ticket-alt text-5xl text-primary"></i>
                            </div>
                        </div>
                        <h2 class="text-3xl font-bold text-gray-800">Mesa de Ayuda TI</h2>
                        <p class="text-secondary mt-2">Inicia sesión para crear un ticket</p>
                    </div>

                    <form class="space-y-6" method="POST" action="{{ route('login') }}">
                        @csrf
                        <div>
                            <label for="username" class="block text-sm font-medium text-gray-700 mb-2">
                                Usuario
                            </label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-3 flex items-center">
                                    <i class="fas fa-user text-secondary"></i>
                                </span>
                                <input type="text" id="username" name="username"
                                    placeholder="Ingresa tu nombre de usuario"
                                    class="w-full pl-10 pr-4 py-3 border border-secondary/50 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary transition duration-300"
                                    required>
                            </div>
                        </div>

                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                                Contraseña
                            </label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-3 flex items-center">
                                    <i class="fas fa-lock text-secondary"></i>
                                </span>
                                <input type="password" id="password" name="password"
                                    placeholder="Ingresa tu contraseña"
                                    class="w-full pl-10 pr-4 py-3 border border-secondary/50 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary transition duration-300"
                                    required>
                            </div>
                        </div>

                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <input id="remember" name="remember" type="checkbox"
                                    class="h-4 w-4 text-primary focus:ring-primary border-secondary rounded">
                                <label for="remember" class="ml-2 block text-sm text-gray-900">
                                    Recordarme
                                </label>
                            </div>

                            <div>
                                <a href="{{ route('password.request') }}"
                                    class="text-sm text-primary hover:text-primary/80 transition duration-300">
                                    ¿Olvidaste tu contraseña?
                                </a>
                            </div>
                        </div>

                        <div>
                            <button type="submit"
                                class="w-full bg-primary text-white py-3 rounded-lg hover:bg-primary/90 transition duration-300 transform hover:scale-105">
                                Iniciar Sesión
                            </button>
                        </div>
                    </form>
                </div>

                <div class="bg-gray-100 text-center p-4">
                    <p class="text-sm text-secondary">
                        ¿No tienes una cuenta?
                    </p>
                </div>
            </div>

            <div class="text-center mt-6 text-secondary">
                <p class="text-sm">© {{ date('Y') }} Mesa de Ayuda TI. Todos los derechos reservados.</p>
            </div>
        </div>
    </div>

    @push('styles')
        <style>
            #particles-js {
                position: absolute;
                width: 100%;
                height: 100%;
                z-index: -1;
            }

            .login-card {
                position: relative;
                z-index: 10;
            }
        </style>
    @endpush

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                particlesJS('particles-js', {
                    particles: {
                        number: {
                            value: 80,
                            density: {
                                enable: true,
                                value_area: 800
                            }
                        },
                        color: {
                            value: '#cc1939'
                        },
                        shape: {
                            type: 'circle',
                            stroke: {
                                width: 0,
                                color: '#000000'
                            }
                        },
                        opacity: {
                            value: 0.5,
                            random: false,
                            anim: {
                                enable: false,
                                speed: 1,
                                opacity_min: 0.1,
                                sync: false
                            }
                        },
                        size: {
                            value: 3,
                            random: true,
                            anim: {
                                enable: false,
                                speed: 40,
                                size_min: 0.1,
                                sync: false
                            }
                        },
                        line_linked: {
                            enable: true,
                            distance: 150,
                            color: '#8a8e91',
                            opacity: 0.4,
                            width: 1
                        },
                        move: {
                            enable: true,
                            speed: 6,
                            direction: 'none',
                            random: false,
                            straight: false,
                            out_mode: 'out',
                            bounce: false,
                            attract: {
                                enable: false,
                                rotateX: 600,
                                rotateY: 1200
                            }
                        }
                    },
                    interactivity: {
                        detect_on: 'canvas',
                        events: {
                            onhover: {
                                enable: true,
                                mode: 'repulse'
                            },
                            onclick: {
                                enable: true,
                                mode: 'push'
                            },
                            resize: true
                        },
                        modes: {
                            repulse: {
                                distance: 100,
                                duration: 0.4
                            },
                            push: {
                                particles_nb: 4
                            }
                        }
                    },
                    retina_detect: true
                });
            });
        </script>
    @endpush
</x-guest-layout>
