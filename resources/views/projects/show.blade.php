@extends('layouts.app')
@section('title', $project->title . ' - Detalle')
@section('content')

    @php
        $statusClasses = match (strtolower(trim($project->status))) {
            'pendiente', 'pending' => 'bg-yellow-100 text-yellow-800',
            'en progreso', 'en curso', 'in progress', 'activo' => 'bg-blue-100 text-blue-800',
            'completado', 'finalizado', 'completed' => 'bg-green-100 text-green-800',
            default => 'bg-gray-100 text-gray-800',
        };
    @endphp

    <!-- 1. Tarjeta del proyecto -->
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <div class="flex flex-wrap justify-between items-start gap-4 mb-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">{{ $project->title }}</h1>
                <p class="text-sm text-gray-500 mt-1">
                    Fecha límite: <span class="font-medium text-gray-700">{{ $project->deadline }}</span>
                </p>
            </div>

            <span class="px-3 py-1 rounded-full text-xs font-medium {{ $statusClasses }}">
                {{ ucfirst($project->status) }}
            </span>
        </div>

        <div class="text-gray-700 mb-6">
            @if ($project->description)
                <p>{{ $project->description }}</p>
            @else
                <p class="italic text-gray-400">Este proyecto no tiene descripción.</p>
            @endif
        </div>

        <div class="flex flex-wrap items-center justify-between pt-4 border-t border-gray-100 gap-3">
            <a href="{{ route('projects.index') }}"
               class="text-sm font-medium text-gray-600 hover:text-gray-900 transition">
                ← Volver al listado
            </a>

            @if ($project->user_id === Auth::id())
                <a href="{{ route('projects.edit', $project) }}"
                   class="bg-amber-500 hover:bg-amber-600 text-white text-sm font-medium px-4 py-2 rounded-lg transition">
                    Editar proyecto
                </a>
            @endif
        </div>
    </div>

    <!-- 2. Equipo asignado -->
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg font-semibold text-gray-900">
                Equipo asignado ({{ $project->users->count() }})
            </h2>
            <span class="text-xs font-medium bg-gray-100 text-gray-700 px-2.5 py-1 rounded-full">
                Total: {{ $project->users->sum('pivot.contribution_hours') }} h
            </span>
        </div>

        <div>
            @forelse ($project->users as $user)
                <div class="flex justify-between items-center py-3 border-b last:border-b-0 border-gray-100">
                    <div class="flex flex-wrap items-center gap-3">
                        <span class="font-medium text-gray-900">{{ $user->name }}</span>
                        <span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                            {{ $user->pivot->role }}
                        </span>
                        <span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-700">
                            {{ $user->pivot->contribution_hours }} h
                        </span>
                    </div>

                    @if ($project->user_id === Auth::id())
                        <form action="{{ route('projects.users.detach', [$project, $user]) }}" method="POST"
                              onsubmit="return confirm('¿Seguro que quieres quitar a {{ $user->name }} de este proyecto?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="text-sm font-medium text-red-600 hover:text-red-800 bg-red-50 hover:bg-red-100 px-3 py-1 rounded-md transition cursor-pointer">
                                Eliminar
                            </button>
                        </form>
                    @endif
                </div>
            @empty
                <p class="text-sm text-gray-500 italic py-2">
                    No hay colaboradores asignados a este proyecto todavía.
                </p>
            @endforelse
        </div>
    </div>

    <!-- 3. Formulario de asignación y validación (solo propietario) -->
    @if ($project->user_id === Auth::id())
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Asignar colaborador</h2>

        <form action="{{ route('projects.users.attach', $project) }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-start">
                <!-- Usuario -->
                <div>
                    <label for="user_id" class="block text-sm font-medium text-gray-700 mb-1">
                        Usuario
                    </label>
                    <select name="user_id" id="user_id"
                            class="w-full rounded-md shadow-sm text-sm {{ $errors->has('user_id') ? 'border-red-500 focus:border-red-500 focus:ring-red-500' : 'border-gray-300 focus:border-indigo-500 focus:ring-indigo-500' }}">
                        <option value="">Selecciona un usuario...</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('user_id')
                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Rol -->
                <div>
                    <label for="role" class="block text-sm font-medium text-gray-700 mb-1">
                        Rol
                    </label>
                    <input type="text" name="role" id="role" value="{{ old('role') }}"
                           placeholder="Ej: Frontend, Backend..."
                           class="w-full rounded-md shadow-sm text-sm {{ $errors->has('role') ? 'border-red-500 focus:border-red-500 focus:ring-red-500' : 'border-gray-300 focus:border-indigo-500 focus:ring-indigo-500' }}">
                    @error('role')
                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Horas -->
                <div>
                    <label for="hours" class="block text-sm font-medium text-gray-700 mb-1">
                        Horas de contribución
                    </label>
                    <input type="number" name="contribution_hours" id="hours" min="1"
                           value="{{ old('contribution_hours') }}" placeholder="Ej: 15"
                           class="w-full rounded-md shadow-sm text-sm {{ $errors->has('contribution_hours') ? 'border-red-500 focus:border-red-500 focus:ring-red-500' : 'border-gray-300 focus:border-indigo-500 focus:ring-indigo-500' }}">
                    @error('contribution_hours')
                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Botón -->
                <div class="md:pt-6">
                    <button type="submit"
                            class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-medium text-sm px-4 py-2 rounded-md shadow-sm transition cursor-pointer">
                        Enviar
                    </button>
                </div>
            </div>
        </form>
        </div>
    @endif

@endsection
