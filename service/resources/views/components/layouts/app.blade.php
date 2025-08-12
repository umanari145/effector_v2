<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', '光輪コーポレーション') }}</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    @livewireStyles
</head>
<body class="bg-gray-50">
    @include('components.layouts.parts.header')
    <div id="app">
    <div class="bg-white">
        <!-- Main Content -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="flex gap-8">
                @include('components.layouts.parts.sidebar')
                @yield('content')
            </div>
        </div>    
    </div>
    @include('components.layouts.parts.footer')
    @livewireScripts
</body>
</html>