<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('APP_NAME', 'Prijavnica') }}</title>

    <link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css">
     <style>
   html { 
          background: url('{{ asset('images/first-screen.png') }}') no-repeat center center fixed; 
          -webkit-background-size: cover;
          -moz-background-size: cover;
          -o-background-size: cover;
          background-size: cover;
        }
        body{background-color:transparent;}
   </style>

</head>
<body>

<div class="cover-container d-flex h-100 p-3 mx-auto flex-column" id="app">


    <main role="main" class="inner cover">
        @yield('content')
    </main>

</div>


<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
