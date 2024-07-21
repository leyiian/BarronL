<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        @vite('resources/css/app.css')
        <title>Laravel</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        <!-- Styles -->

    </head>
    <body class="font-sans antialiased dark:bg-gray-900 dark:text-gray-300">
        <div class="bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-200">
            <header class="fixed top-0 left-0 w-full bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 dark:from-gray-800 dark:via-gray-900 dark:to-gray-800 shadow-md z-10">
                <div class="flex items-center justify-between px-6 py-4 max-w-7xl mx-auto">
                    <div class="flex-1 flex justify-start">
                        <h1 class="text-2xl font-bold text-white dark:text-gray-100">Hospital Admin</h1>
                    </div>
                    @if (Route::has('login'))
                        <nav class="flex space-x-4">
                            @auth
                                <a href="{{ url('/home') }}"
                                   class="bg-blue-800 text-white rounded-md px-4 py-2 text-center hover:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 transition"
                                >
                                    Home
                                </a>
                            @else
                                <a href="{{ route('login') }}"
                                   class="bg-blue-800 text-white rounded-md px-4 py-2 text-center hover:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 transition"
                                >
                                    Inicia Sesion
                                </a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}"
                                       class="bg-blue-800 text-white rounded-md px-4 py-2 text-center hover:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 transition"
                                    >
                                        Registrate
                                    </a>
                                @endif
                            @endauth
                        </nav>
                    @endif
                </div>
            </header>
            <main class="pt-15"> <!-- Adjust the padding top to the height of the header -->
                <div class="relative min-h-screen flex flex-col items-center justify-center selection:bg-[#FF2D20] selection:text-white">

                    <img src="{{ asset('img/hospital.png') }}" alt="img" class="w-40 h-40  object-cover mb-6">

                    <div class="relative w-full max-w-2xl px-6 lg:max-w-7xl">

                        @auth
                            <div class="bg-white dark:bg-gray-700 p-6 rounded-lg shadow-lg">
                                <div class="flex items-center space-x-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 text-blue-500 dark:text-blue-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8.5A3.5 3.5 0 018.5 12 3.5 3.5 0 0112 15.5 3.5 3.5 0 0115.5 12 3.5 3.5 0 0112 8.5zM4.5 12A7.5 7.5 0 0112 4.5 7.5 7.5 0 0119.5 12 7.5 7.5 0 0112 19.5 7.5 7.5 0 014.5 12z"/>
                                    </svg>
                                    <div>
                                        <h2 class="text-2xl font-semibold text-gray-900 dark:text-gray-100">Bienvenido, {{ Auth::user()->name }}!</h2>
                                        <p class="mt-2 text-gray-600 dark:text-gray-300">
                                            Bienvenido al Sistema de Gestión del Super Hospital ☆*: .｡. o(≧▽≦)o .｡.:*☆ . Explore y gestione sus tareas e información de forma eficiente.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="bg-white dark:bg-gray-700 p-6 rounded-lg shadow-lg">
                                <div class="flex items-center space-x-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 text-blue-500 dark:text-blue-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8.5A3.5 3.5 0 018.5 12 3.5 3.5 0 0112 15.5 3.5 3.5 0 0115.5 12 3.5 3.5 0 0112 8.5zM4.5 12A7.5 7.5 0 0112 4.5 7.5 7.5 0 0119.5 12 7.5 7.5 0 0112 19.5 7.5 7.5 0 014.5 12z"/>
                                    </svg>
                                    <div>
                                        <h2 class="text-2xl font-semibold text-gray-900 dark:text-gray-100">Bienvenido, Admin / Doctor!</h2>
                                        <p class="mt-2 text-gray-600 dark:text-gray-300">
                                            Puede iniciar sesión para gestionar tareas e información relacionadas con el hospital. Inicie sesión para empezar.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endauth
                    </div>
                </div>
            </main>
        </div>
    </body>

</html>
