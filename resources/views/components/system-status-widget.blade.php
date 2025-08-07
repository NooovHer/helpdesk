@props(['showManageButton' => false])

<div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg p-6">
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center gap-3">
            <div class="bg-gradient-to-br from-green-500 to-green-600 p-3 rounded-xl">
                <i class="fas fa-server text-xl text-white"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-800">Estado del Sistema</h3>
        </div>
        @if($showManageButton && (auth()->user()->role === 'admin' || auth()->user()->role === 'agent'))
        <a href="{{ route('admin.system-status.index') }}"
           class="text-sm text-purple-600 hover:text-purple-800 bg-purple-50 hover:bg-purple-100 px-3 py-1 rounded-lg transition-colors">
            <i class="fas fa-cog mr-1"></i>
            Gestionar
        </a>
        @endif
    </div>

    <div class="space-y-4">
        @forelse(\App\Models\SystemStatus::orderBy('service_name')->get() as $status)
        <div class="flex items-center justify-between p-3 bg-gray-50/50 rounded-xl">
            <div class="flex-1">
                <span class="font-medium text-gray-700">{{ $status->service_name }}</span>
                @if($status->description)
                <p class="text-xs text-gray-500 mt-1">{{ $status->description }}</p>
                @endif
            </div>
            <div class="flex items-center gap-2">
                <div class="w-2 h-2 bg-{{ $status->status_color }}-500 rounded-full {{ $status->status === 'operational' ? 'animate-pulse' : '' }}"></div>
                <span class="text-sm font-semibold text-{{ $status->status_color }}-600">{{ $status->status_text }}</span>
            </div>
        </div>
        @empty
        <div class="text-center py-8 text-gray-500">
            <i class="fas fa-info-circle text-2xl mb-2"></i>
            <p>No hay servicios configurados</p>
            @if(auth()->user()->role === 'admin' || auth()->user()->role === 'agent')
            <a href="{{ route('admin.system-status.create') }}" class="text-purple-600 hover:text-purple-800 text-sm mt-2 inline-block">
                Configurar servicios
            </a>
            @endif
        </div>
        @endforelse
    </div>

    @if(\App\Models\SystemStatus::where('status', '!=', 'operational')->count() > 0)
    <div class="mt-4 p-3 bg-yellow-50 border border-yellow-200 rounded-lg">
        <div class="flex items-center gap-2 text-yellow-800">
            <i class="fas fa-exclamation-triangle"></i>
            <span class="text-sm font-medium">Hay servicios con problemas</span>
        </div>
    </div>
    @endif
</div>
