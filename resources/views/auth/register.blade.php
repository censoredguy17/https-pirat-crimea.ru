@extends('layouts.app')
@section('title', 'Registration on Laravel 12')

@section('content')

    <div class="container">
        <div class="col-md-4 m-auto">
            <form method="post" action="{{ route('register.post') }}" class="mb-4">
                @csrf
                <h1 class="h3 mb-3 fw-normal">Регистрация</h1>
                <div class="form-floating mb-2">
                    <input type="text" name="name" class="form-control" id="floatingInput" placeholder="Name" value="{{ old('name') }}">
                    <label for="floatingInput">NickName</label>
                </div>
                @error('name') <p class="text-red-400 text-sm mt-1">{{ $message }}</p> @enderror()
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
                <div class="form-floating mb-2">
                    <input type="password" name="password_confirmation" class="form-control" id="floatingPassword" placeholder="Password">
                    <label for="floatingPassword">Password</label>
                </div>
                <button class="btn btn-primary w-100 py-2" type="submit">Зарегестрироваться</button>
            </form>

            <div>
                Уже есть аккаунт?
                <a href="{{ route('login') }}">Войти</a>
            </div>
        </div>
    </div>

@endsection
