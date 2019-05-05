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

            <form action="{{ route('register-user') }}" method="post" class="form-signup">
                @csrf
                <div class="row ">
                    <div class="col-sm ">
                        <label for="inputName" class="sr-only">{{ __('auth.name') }}</label>
                        <input type="text" name="firstname" class="form-control form-control-lg polleoform" placeholder="{{ __('auth.name') }}" value="{{ old('name') }}" required>

                        <label for="inputEmail" class="sr-only">{{ __('auth.email_address') }}</label>
                        <input type="email" name="email" class="form-control form-control-lg polleoform" placeholder="{{ __('auth.email_address') }}" value="{{ old('email') }}" required>

                        <label for="inputAddress" class="sr-only">{{ __('auth.adress') }}</label>
                        <input type="text" name="address" class="form-control form-control-lg polleoform" placeholder="{{ __('auth.adress') }}" value="{{ old('address') }}" required>

                        <label for="inputAddress" class="sr-only">{{ __('auth.zip') }}</label>
                        <input type="text" name="zip" class="form-control form-control-lg polleoform" placeholder="{{ __('auth.zip') }}" value="{{ old('zip') }}" required>

                        <div class="form-inline">
                            <label for="inputMobitel" class="sr-only">{{ __('auth.mobile') }}</label>
                            <input type="text" name="telephone" class="form-control form-control-lg polleoform" id="telephone" placeholder="{{ __('auth.mobile_long') }}" value="{{ old('mobile') }}" required>
                        </div>
                        <p class="blue">{{ __('auth.mobile_info') }}</p>
                    </div>

                    <div class="col-sm ">
                        <label for="inputSurname" class="sr-only">{{ __('auth.lastname') }}</label>
                        <input type="text" name="lastname" class="form-control form-control-lg polleoform" placeholder="{{ __('auth.lastname') }}" value="{{ old('lastname') }}" required>

                        <label for="inputPassword" class="sr-only">{{ __('auth.password') }}</label>
                        <input type="password" class="form-control form-control-lg polleoform" placeholder="{{ __('auth.password') }}" name="password" required>

                        <label for="inputMjesto" class="sr-only">{{ __('auth.city') }}</label>
                        <input type="text" name="city" class="form-control form-control-lg polleoform" placeholder="{{ __('auth.city') }}" value="{{ old('city') }}" required>

                        <label for="inputMjesto" class="sr-only">{{ __('auth.birth') }}</label>
                        <input type="text" name="birthday" id="birthday" class="form-control form-control-lg polleoform" placeholder="{{ __('auth.birth_long') }}" value="{{ old('birthday') }}" required>

                        <div class="custom-control custom-radio custom-control-inline" style="margin-left:-20px">
                            <label>{{ __('auth.gender.title') }}:</label>
                        </div>

                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" name="sex" class="custom-control-input" id="M" value="M" {{ (old('sex') == 'M') ? 'checked' : '' }} >
                            <label class="custom-control-label" for="M">{{ __('auth.gender.m') }}</label>
                        </div>

                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" name="sex" class="custom-control-input" id="F" value="F" {{ (old('sex') == 'F') ? 'checked' : '' }}>
                            <label class="custom-control-label" for="F">{{ __('auth.gender.f') }}</label>
                        </div>

                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" name="sex" class="custom-control-input" id="O" value="O" {{ (old('sex') == 'O') ? 'checked' : '' }}>
                            <label class="custom-control-label" for="O">{{ __('auth.gender.o') }}</label>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm ">
                        <button class="btn blue-full fright " type="submit">{{ __('auth.btn_next_step') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

@stop
