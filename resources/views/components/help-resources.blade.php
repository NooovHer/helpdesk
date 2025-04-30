<!-- resources/views/components/help-resources.blade.php -->
<div class="bg-white shadow-md rounded-lg p-6">
    <h2 class="text-xl font-semibold mb-4 text-primary">
        <i class="fas fa-info-circle mr-2"></i>Recursos de Ayuda
    </h2>
    <ul class="space-y-3">
        @foreach ($resources as $resource)
            <li>
                <a href="{{ $resource['link'] }}" class="text-secondary hover:text-primary transition">
                    <i class="fas fa-{{ $resource['icon'] }} mr-2"></i>
                    {{ $resource['text'] }}
                </a>
            </li>
        @endforeach
    </ul>
</div>
