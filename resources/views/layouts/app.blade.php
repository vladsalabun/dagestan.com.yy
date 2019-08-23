<!---



    Руководитель проекта: Сергей Кондрашов
    Дизайн: 
    Верстка и программирование: Влад Салабун

    
    
-->
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('page_header')</title>

    <!-- Скрипты: -->
    <script src="{{ asset('js/jQuery3.3.1.js') }}"></script>
    <script src="{{ asset('js/bootstrap.js') }}"></script>
    <script src="{{ asset('js/jquery-ui.js') }}"></script>
    <script src="{{ asset('js/moment.js') }}"></script>
    <script src="{{ asset('js/moment_js_locale.js') }}"></script>
    <script src="{{ asset('js/popper.js') }}"></script>
    <script src="{{ asset('js/tempus_dominus.js') }}"></script>
    <script src="{{ asset('js/ckeditor.js') }}"></script>

    <!-- Шрифты: -->
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Стили: -->
    <link href="{{ asset('css/bootstrap.css') }}" rel="stylesheet">
    <link href="{{ asset('css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/jquery-ui_dialog.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/tempus_dominus.css') }}" rel="stylesheet">
    <link href="{{ asset('css/vlad_style.css') }}" rel="stylesheet">
    
</head>
<body>
    <div id="app">
    @include('layouts.header')
        <main class="py-4">
            @yield('content')
        </main>
    </div>
    @include('layouts.footer')
</body>
</html>
