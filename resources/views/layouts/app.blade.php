<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Grupo AFS')</title>

    {{-- CSS --}}
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/choices.min.css') }}">

    {{-- JS (head) --}}
    <script src="{{ asset('js/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/signature_pad.umd.min.js') }}"></script>

    @stack('styles')
</head>

<body class="bg-light">

    {{-- Contenido principal --}}
    @yield('content')

    {{-- JS (footer) --}}
    <script src="{{ asset('js/choices.min.js') }}"></script>
    <script src="{{ asset('js/justValidate.min.js') }}"></script>
    <script src="{{ asset('js/form-utils.js') }}"></script>
    {{-- <script src="{{ asset(path: 'js/main.js') }}"></script> --}}

    @stack('scripts')
</body>

</html>