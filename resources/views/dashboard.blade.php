// resources/views/dashboard.blade.php
<x-app-layout>
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-primary">
            <i class="fas fa-home mr-2"></i>Mi Panel
        </h1>
        <div class="flex items-center space-x-4">
            <span class="text-gray-700">
                Bienvenido, {{ Auth::user()->name }}
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
        <x-create-ticket />
        <x-recent-tickets />
        <x-help-resources />
        <x-notifications />
    </div>
</x-app-layout>
