@extends('layouts.app-inner')

@section('jumbotron')

    <section class="jumbotron text-center" style="padding: 0;">
        <img src="{{ asset('img/header.png') }}" alt="Prijavnica">
    </section>

@stop


@section('content')

    <div class="row width">

        <div class="col-sm ">

            @if (session('error'))
                <div class="alert alert-success">
                    {{ session('error') }}
                </div>
            @endif

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif


            <form action="{{ route('register-user') }}" method="post" class="form-signup">
                @csrf


                <div class="row ">

                    <div class="col-sm ">

                        <label for="inputName" class="sr-only">Ime</label>
                        <input type="text"  name="firstname" class="form-control form-control-lg polleoform" placeholder="Ime" value="{{ old('name') }}" required>

                        <label for="inputEmail" class="sr-only">Email address</label>
                        <input type="email"  name="email" class="form-control form-control-lg polleoform" placeholder="Email adresa" value="{{ old('email') }}" required>

                        <label for="inputAddress" class="sr-only">Adresa</label>
                        <input type="text"  name="address" class="form-control form-control-lg polleoform" placeholder="Adresa" value="{{ old('address') }}" required>

                        <label for="inputAddress" class="sr-only">Poštanski broj</label>
                        <input type="text"  name="zip" class="form-control form-control-lg polleoform" placeholder="Poštanski broj" value="{{ old('zip') }}" required>

                        <div class="form-inline">

                            <label for="inputMobitel" class="sr-only">Mobitel</label>
                            <input type="text"  name="telephone" class="form-control form-control-lg polleoform" id="telephone" placeholder="Mobitel 09X-XXX-XXXX" value="{{ old('mobile') }}" required>


                        </div>
                        <p class="blue">*Nakon upisa broja mobitela, isti je potrebno autentificirati upisom potvrdnog koda pristiglog porukom.</p>

                    </div>



                    <div class="col-sm ">

                        <label for="inputSurname" class="sr-only">Prezime</label>
                        <input type="text"  name="lastname" class="form-control form-control-lg polleoform" placeholder="Prezime" value="{{ old('lastname') }}" required>

                        <label for="inputPassword" class="sr-only">Password</label>
                        <input type="password"  class="form-control form-control-lg polleoform" placeholder="Lozinka" name="password" placeholder="Lozinka" required>

                        <label for="inputMjesto" class="sr-only">Mjesto</label>
                        <input type="text"  name="city" class="form-control form-control-lg polleoform" placeholder="Grad" value="{{ old('city') }}" required>

                        <label for="inputMjesto" class="sr-only">Datum rođenja</label>
                        <input type="text"  name="birthday" id="birthday" class="form-control form-control-lg polleoform" placeholder="Datum rođenja mm/dd/yyyy" value="{{ old('birthday') }}" required>

                        <div class="custom-control custom-radio custom-control-inline" style="margin-left:-20px">

                            <label >Spol:</label>
                        </div>


                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio"  name="sex" class="custom-control-input" id="M" value="M" {{ (old('sex') == 'M') ? 'checked' : '' }} >
                            <label class="custom-control-label" for="M">Muško</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio"  name="sex" class="custom-control-input" id="F" value="F" {{ (old('sex') == 'F') ? 'checked' : '' }}>
                            <label class="custom-control-label" for="F">Žensko</label>
                        </div>

                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio"  name="sex" class="custom-control-input" id="O" value="O" {{ (old('sex') == 'O') ? 'checked' : '' }}>
                            <label class="custom-control-label" for="O" >Ostalo</label>
                        </div>




                    </div>

                </div>

                <div class="row">
                    <div class="col-sm ">
                        <button class="btn blue-full fright " type="submit">SLJEDEĆI KORAK</button>
                    </div>
                </div>



            </form>
        </div>

    </div>

@stop