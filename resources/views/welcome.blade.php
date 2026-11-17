<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Gestor de Proyectos</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-gray-100 text-gray-800 min-h-screen flex flex-col">
        <!-- Barra superior -->
        <header class="bg-white border-b border-gray-200 shadow-sm">
            <div class="max-w-5xl mx-auto px-4 h-16 flex justify-between items-center">
                <div class="flex items-center gap-2">
                    <x-application-logo class="block h-8 w-auto fill-current text-indigo-600" />
                    <span class="font-bold text-lg text-gray-900">Gestor de Proyectos</span>
                </div>

                @if (Route::has('login'))
                    <nav class="flex items-center gap-3">
                        @auth
                            <a href="{{ route('projects.index') }}"
                               class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium px-4 py-2 rounded-lg transition">
                                Ir a Proyectos
                            </a>
                            <a href="{{ route('dashboard') }}"
                               class="text-sm font-medium text-gray-600 hover:text-gray-900 px-3 py-2 transition">
                                Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}"
                               class="text-sm font-medium text-gray-700 hover:text-indigo-600 px-3 py-2 transition">
                                Iniciar sesión
                            </a>

                            @if (Route::has('register'))
                                <a href="{{ route('register') }}"
                                   class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium px-4 py-2 rounded-lg transition">
                                    Registrarse
                                </a>
                            @endif
                        @endauth
                    </nav>
                @endif
            </div>
        </header>

        <!-- Contenido principal -->
        <main class="flex-1 flex items-center justify-center px-4 py-12">
            <div class="max-w-4xl w-full">
                <!-- Hero -->
                <div class="bg-white rounded-xl shadow p-8 md:p-10 text-center mb-8">
                    <span class="inline-block px-3 py-1 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800 mb-4">
                        Laravel + Tailwind CSS
                    </span>
                    <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                        Organiza tus proyectos y equipos en un solo lugar
                    </h1>
                    <p class="text-gray-600 max-w-2xl mx-auto mb-8">
                        Crea proyectos, haz seguimiento de su estado y fechas límite, y asigna colaboradores con su rol y horas de contribución.
                    </p>

                    <div class="flex flex-wrap justify-center gap-4">
                        @auth
                            <a href="{{ route('projects.index') }}"
                               class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium px-6 py-3 rounded-lg shadow-sm transition">
                                Ver mis proyectos →
                            </a>
                            <a href="{{ route('projects.create') }}"
                               class="bg-gray-100 hover:bg-gray-200 text-gray-800 font-medium px-6 py-3 rounded-lg transition">
                                + Nuevo proyecto
                            </a>
                        @else
                            <a href="{{ route('login') }}"
                               class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium px-6 py-3 rounded-lg shadow-sm transition">
                                Iniciar sesión
                            </a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}"
                                   class="bg-gray-100 hover:bg-gray-200 text-gray-800 font-medium px-6 py-3 rounded-lg transition">
                                    Crear cuenta
                                </a>
                            @endif
                        @endauth
                    </div>
                </div>

                <!-- Tarjetas de características -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-white rounded-lg shadow p-6">
                        <h2 class="font-semibold text-gray-900 mb-2">📋 Gestión completa</h2>
                        <p class="text-sm text-gray-600">
                            Crea, consulta, edita y elimina proyectos con validación de campos y alertas en tiempo real.
                        </p>
                    </div>

                    <div class="bg-white rounded-lg shadow p-6">
                        <h2 class="font-semibold text-gray-900 mb-2">👥 Equipos y roles</h2>
                        <p class="text-sm text-gray-600">
                            Asigna colaboradores a cada proyecto indicando su rol y calculando las horas totales invertidas.
                        </p>
                    </div>

                    <div class="bg-white rounded-lg shadow p-6">
                        <h2 class="font-semibold text-gray-900 mb-2">🔐 Acceso protegido</h2>
                        <p class="text-sm text-gray-600">
                            Todas las rutas de proyectos están protegidas mediante autenticación con Laravel Breeze.
                        </p>
                    </div>
                </div>
            </div>
        </main>
    </body>
</html>
