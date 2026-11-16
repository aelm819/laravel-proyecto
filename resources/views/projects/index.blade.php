@extends('layouts.app')
@section('title', 'Proyectos')
@section('content')

    <!-- Cabecera con acción -->
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Proyectos</h1>
        <a href="{{ route('projects.create') }}"
           class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg font-medium transition">
            + Nuevo proyecto
        </a>
    </div>

    <!-- Rejilla de tarjetas -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse ($projects as $project)
            @php
                $statusClasses = match (strtolower(trim($project->status))) {
                    'pendiente', 'pending' => 'bg-yellow-100 text-yellow-800',
                    'en progreso', 'en curso', 'in progress', 'activo' => 'bg-blue-100 text-blue-800',
                    'completado', 'finalizado', 'completed' => 'bg-green-100 text-green-800',
                    default => 'bg-gray-100 text-gray-800',
                };
            @endphp

            <div class="bg-white rounded-lg shadow p-6 flex flex-col justify-between">
                <div>
                    <div class="flex justify-between items-start gap-2 mb-3">
                        <h2 class="text-lg font-semibold text-gray-900">
                            {{ $project->title }}
                        </h2>
                        <span class="shrink-0 px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusClasses }}">
                            {{ ucfirst($project->status) }}
                        </span>
                    </div>

                    @if ($project->description)
                        <p class="text-sm text-gray-600 mb-4 line-clamp-2">
                            {{ $project->description }}
                        </p>
                    @endif

                    <p class="text-xs text-gray-500 mb-4">
                        <span class="font-medium">Fecha límite:</span> {{ $project->deadline }}
                    </p>
                </div>

                <!-- Acciones -->
                <div class="flex items-center justify-between pt-4 border-t border-gray-100 text-sm font-medium">
                    <div class="flex items-center space-x-3">
                        <a href="{{ route('projects.show', $project) }}"
                           class="text-indigo-600 hover:text-indigo-800 transition">
                            Ver
                        </a>
                        <a href="{{ route('projects.edit', $project) }}"
                           class="text-amber-600 hover:text-amber-800 transition">
                            Editar
                        </a>
                    </div>

                    <form action="{{ route('projects.destroy', $project) }}" method="POST"
                          onsubmit="return confirm('¿Seguro que quieres eliminar este proyecto?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="text-red-600 hover:text-red-800 transition cursor-pointer">
                            Eliminar
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="col-span-full bg-white rounded-lg shadow p-8 text-center">
                <p class="text-gray-500 mb-3">Todavía no hay proyectos creados.</p>
                <a href="{{ route('projects.create') }}"
                   class="text-indigo-600 hover:text-indigo-800 font-medium hover:underline">
                    Crear el primer proyecto →
                </a>
            </div>
        @endforelse
    </div>

@endsection
