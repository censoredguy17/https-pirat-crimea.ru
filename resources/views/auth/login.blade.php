@extends('layouts.app')
@section('title', 'Registration on Laravel 12')

@section('content')

    <div class="container">
        <div class="col-md-4 m-auto">
            <form method="post" action="{{ route('login.post') }}" class="mb-4">
                @csrf
                <h1 class="h3 mb-3 fw-normal">Вход</h1>
                <div class="form-floating mb-2">
                    <input type="email" name="email" class="form-control" id="floatingInput" placeholder="name@example.com" value="{{ old('email') }}">
                    <label for="floatingInput">Email address</label>
                </div>
                @error('email') <p class="text-red-400 text-sm mt-1">{{ $message }}</p> @enderror()
                <div class="form-floating mb-2">
                    <input type="password" name="password" class="form-control" id="floatingPassword" placeholder="Password">
                    <label for="floatingPassword">Password</label>
                </div>
                @error('password') <p class="text-red-400 text-sm mt-1">{{ $message }}</p> @enderror()
                <div class="form-check text-start my-3">
                    <input class="form-check-input" type="checkbox" name="remember_me" value="1" id="checkDefault">
                    <label class="form-check-label" for="checkDefault">Remember me</label>
                </div>
                <button class="btn btn-primary w-100 py-2" type="submit">Войти</button>
            </form>

            <div>
                Еще не зарегестрированы?
                <a href="{{ route('register') }}">Регистрация</a>
            </div>
        </div>
    </div>

@endsection
