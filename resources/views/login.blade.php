@extends('layouts.app-inner')

@section('jumbotron')

    <section class="jumbotron text-center" style="padding: 0;">
        <img src="{{ asset('img/header.png') }}" alt="Prijavnica">
    </section>

@stop


@section('content')

    <div class="album py-5">
        <div class="container">
            <form action="{{ route('log-user') }}" method="post">
                @csrf

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="firstName">Username</label>
                        <input type="text" class="form-control" name="email" placeholder="Username" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="lastName">Password</label>
                        <input type="password" class="form-control" name="pass" placeholder="Password" required>
                    </div>
                </div>

                @if (session('error'))
                    <div class="alert alert-success">
                        {{ session('error') }}
                    </div>
                @endif

                <hr class="mb-4">
                <button class="btn btn-primary btn-lg btn-block" type="submit">Logiraj se!</button>
            </form>
        </div>
    </div>

@stop