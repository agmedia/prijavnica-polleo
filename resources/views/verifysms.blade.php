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

            <form action="{{ route('verify-sms') }}" method="post" class="form-signup">
                @csrf
                <div class="row ">
                    <div class="col-sm">
                        <label class="sr-only">{{ __('auth.pin') }}</label>
                        <input type="text" name="pin" class="form-control form-control-lg polleoform" placeholder="{{ __('auth.pin') }}" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm ">
                        <button class="btn blue-full fright" type="submit">{{ __('auth.btn_verify') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@stop
