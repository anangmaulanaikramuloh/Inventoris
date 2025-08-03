<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .auth-container {
            display: flex;
            min-height: 100vh;
        }
        .auth-left, .auth-right {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }
        .auth-left {
            background-color: #f8f9fa;
        }
        .auth-right {
            background-color: #ffffff;
        }
        .auth-card {
            width: 100%;
            max-width: 400px;
        }
    </style>
</head>
<body>
    <div id="app">
        <div class="auth-container">
            @yield('content')
        </div>
    </div>
</body>
</html>
