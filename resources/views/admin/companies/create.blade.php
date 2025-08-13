@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8 max-w-lg">
    <h1 class="text-2xl font-bold mb-6">Add Company</h1>
    <form action="{{ route('admin.companies.store') }}" method="POST" class="bg-white shadow rounded-lg p-6 space-y-4">
        @csrf
        <div>
            <label class="block text-sm font-medium text-gray-700">Name</label>
            <input type="text" name="nombre" class="w-full border rounded px-3 py-2 mt-1" required>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Email</label>
            <input type="email" name="email" class="w-full border rounded px-3 py-2 mt-1">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Phone</label>
            <input type="text" name="telefono" class="w-full border rounded px-3 py-2 mt-1">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">City</label>
            <input type="text" name="ciudad" class="w-full border rounded px-3 py-2 mt-1">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Address</label>
            <input type="text" name="direccion" class="w-full border rounded px-3 py-2 mt-1">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">RFC</label>
            <input type="text" name="rfc" class="w-full border rounded px-3 py-2 mt-1">
        </div>
        <div class="flex items-center">
            <input type="checkbox" name="activo" value="1" class="mr-2" checked>
            <label class="text-sm text-gray-700">Active</label>
        </div>
        <div class="flex justify-end">
            <a href="{{ route('admin.companies.index') }}" class="mr-4 text-gray-600 hover:underline">Cancel</a>
            <button type="submit" class="bg-purple-600 text-white px-4 py-2 rounded hover:bg-purple-700 transition">Save</button>
        </div>
    </form>
</div>
@endsection
