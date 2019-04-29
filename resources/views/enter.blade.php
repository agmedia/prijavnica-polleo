@extends('layouts.app-inner')

 

@section('content')




 <div class="row width">


    <div class="col-sm text-center">

     <a  class="btn white-outline" href="{{ route('register') }}" >REGISTRIRAJ SE</a>
    </div>


    <div class="col-sm text-center">




      <form class="form-signin " action="{{ route('log-user') }}" method="post">
          @csrf

  <label for="inputEmail" class="sr-only">Email address</label>
  <input type="email" id="inputEmail" class="form-control form-control-lg polleoform" name="email" placeholder="Email adresa" required>
  <label for="inputPassword" class="sr-only">Password</label>
  <input type="password" id="inputPassword" class="form-control form-control-lg polleoform" name="pass" placeholder="Lozinka" required>

          @if (session('error'))
              <div class="alert alert-success">
                  {{ session('error') }}
              </div>
          @endif

  <button class="btn blue-full" type="submit">PRIJAVI SE</button>

</form>











 
    </div>
  
  </div>

 

@stop