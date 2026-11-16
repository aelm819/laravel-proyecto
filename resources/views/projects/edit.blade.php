@extends('layouts.app')
@section('title', 'Editar Proyecto')
@section('content')

    <div class="max-w-2xl mx-auto bg-white rounded-lg shadow p-6">
        <div class="flex justify-between items-center mb-6 pb-4 border-b border-gray-100">
            <h1 class="text-2xl font-bold text-gray-900">Editar Proyecto</h1>
            <a href="{{ route('projects.index') }}"
               class="text-sm font-medium text-gray-600 hover:text-gray-900 transition">
                ← Volver al listado
            </a>
        </div>

        <form action="{{ route('projects.update', $project) }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')

            <!-- Título -->
            <div>
                <label for="title" class="block text-sm font-medium text-gray-700 mb-1">
                    Título
                </label>
                <input type="text" name="title" id="title" value="{{ old('title', $project->title) }}"
                       class="w-full rounded-md shadow-sm text-sm {{ $errors->has('title') ? 'border-red-500 focus:border-red-500 focus:ring-red-500' : 'border-gray-300 focus:border-indigo-500 focus:ring-indigo-500' }}">
                @error('title')
                    <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Descripción -->
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">
                    Descripción <span class="text-gray-400 font-normal">(opcional)</span>
                </label>
                <textarea name="description" id="description" rows="4"
                          class="w-full rounded-md shadow-sm text-sm {{ $errors->has('description') ? 'border-red-500 focus:border-red-500 focus:ring-red-500' : 'border-gray-300 focus:border-indigo-500 focus:ring-indigo-500' }}">{{ old('description', $project->description) }}</textarea>
                @error('description')
                    <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Fecha límite y Estado -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="deadline" class="block text-sm font-medium text-gray-700 mb-1">
                        Fecha límite
                    </label>
                    <input type="date" name="deadline" id="deadline" value="{{ old('deadline', $project->deadline) }}"
                           class="w-full rounded-md shadow-sm text-sm {{ $errors->has('deadline') ? 'border-red-500 focus:border-red-500 focus:ring-red-500' : 'border-gray-300 focus:border-indigo-500 focus:ring-indigo-500' }}">
                    @error('deadline')
                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1">
                        Estado
                    </label>
                    @php
                        $selectedStatus = old('status', $project->status);
                        $standardStatuses = [
                            'pendiente' => 'Pendiente',
                            'en progreso' => 'En progreso',
                            'completado' => 'Completado',
                        ];
                    @endphp
                    <select name="status" id="status"
                            class="w-full rounded-md shadow-sm text-sm {{ $errors->has('status') ? 'border-red-500 focus:border-red-500 focus:ring-red-500' : 'border-gray-300 focus:border-indigo-500 focus:ring-indigo-500' }}">
                        @foreach ($standardStatuses as $value => $label)
                            <option value="{{ $value }}" {{ strtolower((string) $selectedStatus) === $value ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                        @if ($selectedStatus && !array_key_exists(strtolower((string) $selectedStatus), $standardStatuses))
                            <option value="{{ $selectedStatus }}" selected>{{ ucfirst($selectedStatus) }}</option>
                        @endif
                    </select>
                    @error('status')
                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Botones -->
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
                <a href="{{ route('projects.index') }}"
                   class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg transition">
                    Cancelar
                </a>
                <button type="submit"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium px-4 py-2 rounded-lg shadow-sm transition cursor-pointer">
                    Actualizar proyecto
                </button>
            </div>
        </form>
    </div>

@endsection
