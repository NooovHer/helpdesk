<x-app-layout>
    <div class="max-w-2xl mx-auto px-4 py-8">
        <h2 class="text-2xl font-bold mb-6 flex items-center gap-2">
            <i class="fas fa-plus text-indigo-500"></i> Crear Ticket para Usuario
        </h2>
        <form method="POST" action="{{ route('agent.tickets.store-user') }}" class="space-y-6">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Usuario</label>
                <select id="user_id_select" name="user_id" class="w-full border rounded-lg" required>
                    <option value="">Selecciona un usuario...</option>
                    @foreach($users as $user)
                    <option value="{{ $user->id }}">{{ $user->username }} ({{ $user->email }})</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Título</label>
                <input type="text" name="title" class="w-full px-4 py-2 border rounded-lg" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Descripción</label>
                <textarea name="description" rows="4" class="w-full px-4 py-2 border rounded-lg" required></textarea>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Prioridad</label>
                <select name="priority" class="w-full px-4 py-2 border rounded-lg" required>
                    <option value="baja">Baja</option>
                    <option value="media">Media</option>
                    <option value="alta">Alta</option>
                    <option value="urgente">Urgente</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Departamento</label>
                <select name="department_id" class="w-full px-4 py-2 border rounded-lg">
                    <option value="">Sin departamento</option>
                    @foreach($departments as $dep)
                    <option value="{{ $dep->id }}">{{ $dep->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Categoría</label>
                <select name="category_id" class="w-full px-4 py-2 border rounded-lg">
                    <option value="">Sin categoría</option>
                    @foreach($categories as $cat)
                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="w-full px-6 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 font-semibold">
                <i class="fas fa-save mr-2"></i> Crear Ticket
            </button>
        </form>
    </div>
</x-app-layout>
