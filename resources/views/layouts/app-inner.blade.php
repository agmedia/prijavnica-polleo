<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('APP_NAME', 'Prijavnica') }}</title>

   

    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">

      <link href="{{ asset('css/theme.css') }}" rel="stylesheet" >
        <style>
   html { 
  background: url('{{ asset($backgroundimage) }}') no-repeat center center fixed; 
  -webkit-background-size: cover;
  -moz-background-size: cover;
  -o-background-size: cover;
  background-size: cover;
}
  body{background-color:transparent;}
   </style>

</head>
<body >

<div id="app">

 <div class="fixed-top text-right m-4" id="secs"></div> 

  

        @yield('content')
  


</div>


<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
