<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <style>
        .container {
            padding: 1rem 1.5rem;
        }
        .mt-4 {
            margin-top: 4rem;
        }
    </style>
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
<div id="app">
    <div class="container">
        <div class="menu">
           @if(Auth::user()->isAdmin)<a href="/admin">User Admin</a>@endif
           @if(Auth::user()->isOfficer) <a href="/events">Events management</a>@endif
        </div>
        @if(!Auth::user()->isAdmin && !Auth::user()->isOfficer) <div>Merci pour s'etre enregistre</div>@endif
    </div>
</div>

<!-- Scripts -->
<!-- <script src="{{ asset('js/admin.js') }}"></script> -->
</body>
</html>

