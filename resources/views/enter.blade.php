@extends('layouts.app-inner')

@section('content')

    <div class="row width">
        <div class="col-sm text-center">
            <a class="btn white-outline" href="{{ route('register') }}">{{ __('auth.register') }}</a>
        </div>
        <div class="col-sm text-center">

            <form class="form-signin " action="{{ route('log-user') }}" method="post">
                @csrf
                <label for="inputEmail" class="sr-only">{{ __('auth.email_address') }}</label>
                <input type="email" id="inputEmail" class="form-control form-control-lg polleoform" name="email" placeholder="{{ __('auth.email_address') }}" required>
                <label for="inputPassword" class="sr-only">{{ __('auth.password') }}</label>
                <input type="password" id="inputPassword" class="form-control form-control-lg polleoform" name="pass" placeholder="{{ __('auth.password') }}" required>
                @if (session('error'))
                    <div class="alert alert-success">
                        {{ session('error') }}
                    </div>
                @endif
                <button class="btn blue-full" type="submit">{{ __('auth.login') }}</button>
            </form>

        </div>
    </div>

@stop
