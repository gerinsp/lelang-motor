@props(['title' => config('app.name', 'Laravel')])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title }}</title>
    <link rel="icon" href="{{ asset('logo-lelang.png') }}">

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body x-data="{isDark: $persist(false)}" x-bind:class="{'dark': isDark}" @keydown.ctrl.space="isDark = ! isDark"
    class="font-sans antialiased bg-white text-slate-700 dark:bg-slate-900 dark:text-slate-300">
    <div class="flex flex-col items-center min-h-screen pt-6 bg-gray-100 sm:justify-center sm:pt-0 dark:bg-gray-900">
        <div>
            <img src="{{ asset('logo-lelang.png') }}" alt="Lelang Logo" class="w-20 h-20 mb-4 sm:mb-0">
        </div>

        <div
            class="w-full px-6 py-4 mt-6 overflow-hidden bg-white shadow-md sm:max-w-md dark:bg-gray-800 sm:rounded-lg">
            {{ $slot }}
        </div>
    </div>
</body>

</html>