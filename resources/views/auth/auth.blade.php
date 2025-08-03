@extends('layouts.app')

@section('content')
<style>
    body, html {
        height: 100%;
        background-color: #f0f2f5;
        display: flex;
        align-items: center;
        justify-content: center;
        font-family: 'Montserrat', sans-serif;
    }

    .auth-container {
        background-color: #fff;
        border-radius: 10px;
        box-shadow: 0 14px 28px rgba(0,0,0,0.25), 0 10px 10px rgba(0,0,0,0.22);
        position: relative;
        overflow: hidden;
        width: 768px;
        max-width: 100%;
        min-height: 480px;
    }

    .form-container {
        position: absolute;
        top: 0;
        height: 100%;
        transition: all 0.6s ease-in-out;
    }

    .login-container {
        left: 0;
        width: 50%;
        z-index: 2;
    }

    .register-container {
        left: 0;
        width: 50%;
        opacity: 0;
        z-index: 1;
    }

    .auth-container.right-panel-active .login-container {
        transform: translateX(100%);
    }

    .auth-container.right-panel-active .register-container {
        transform: translateX(100%);
        opacity: 1;
        z-index: 5;
        animation: show 0.6s;
    }

    @keyframes show {
        0%, 49.99% { opacity: 0; z-index: 1; }
        50%, 100% { opacity: 1; z-index: 5; }
    }

    .overlay-container {
        position: absolute;
        top: 0;
        left: 50%;
        width: 50%;
        height: 100%;
        overflow: hidden;
        transition: transform 0.6s ease-in-out;
        z-index: 100;
    }

    .auth-container.right-panel-active .overlay-container {
        transform: translateX(-100%);
    }

    .overlay {
        background: #343a40;
        background: -webkit-linear-gradient(to right, #495057, #343a40);
        background: linear-gradient(to right, #495057, #343a40);
        background-repeat: no-repeat;
        background-size: cover;
        background-position: 0 0;
        color: #FFFFFF;
        position: relative;
        left: -100%;
        height: 100%;
        width: 200%;
        transform: translateX(0);
        transition: transform 0.6s ease-in-out;
    }

    .auth-container.right-panel-active .overlay {
        transform: translateX(50%);
    }

    .overlay-panel {
        position: absolute;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        padding: 0 40px;
        text-align: center;
        top: 0;
        height: 100%;
        width: 50%;
        transform: translateX(0);
        transition: transform 0.6s ease-in-out;
    }

    .overlay-left {
        transform: translateX(-20%);
    }

    .auth-container.right-panel-active .overlay-left {
        transform: translateX(0);
    }

    .overlay-right {
        right: 0;
        transform: translateX(0);
    }

    .auth-container.right-panel-active .overlay-right {
        transform: translateX(20%);
    }

    form {
        background-color: #FFFFFF;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        padding: 0 50px;
        height: 100%;
        text-align: center;
    }

    .ghost {
        background-color: transparent;
        border-color: #FFFFFF;
    }

</style>

<div class="auth-container" id="container">
    <div class="form-container register-container">
        <form method="POST" action="{{ route('register') }}">
            @csrf
            <h1>Buat Akun</h1>
            <div class="w-100 mt-3">
                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="Name">
                @error('name') <span class="invalid-feedback"><strong>{{ $message }}</strong></span> @enderror
            </div>
            <div class="w-100 mt-3">
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Email">
                @error('email') <span class="invalid-feedback"><strong>{{ $message }}</strong></span> @enderror
            </div>
            <div class="w-100 mt-3">
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="Password">
                @error('password') <span class="invalid-feedback"><strong>{{ $message }}</strong></span> @enderror
            </div>
            <div class="w-100 mt-3">
                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" placeholder="Confirm Password">
            </div>
            <button type="submit" class="btn btn-primary mt-4">Daftar</button>
        </form>
    </div>
    <div class="form-container login-container">
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <h1>Login</h1>
            <div class="w-100 mt-3">
                <input id="login-email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Email">
                @error('email') <span class="invalid-feedback"><strong>{{ $message }}</strong></span> @enderror
            </div>
            <div class="w-100 mt-3">
                <input id="login-password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Password">
                @error('password') <span class="invalid-feedback"><strong>{{ $message }}</strong></span> @enderror
            </div>
            <a href="{{ route('password.request') }}" class="mt-3">Lupa password?</a>
            <button type="submit" class="btn btn-primary mt-3">Login</button>
        </form>
    </div>
    <div class="overlay-container">
        <div class="overlay">
            <div class="overlay-panel overlay-left">
                <h1>Selamat Datang Kembali!</h1>
                <p>Untuk tetap terhubung dengan kami, silakan login dengan info pribadi Anda</p>
                <button class="btn btn-outline-light ghost" id="signIn">Login</button>
            </div>
            <div class="overlay-panel overlay-right">
                <h1>Halo, Teman!</h1>
                <p>Masukkan detail pribadi Anda dan mulailah perjalanan dengan kami</p>
                <button class="btn btn-outline-light ghost" id="signUp">Daftar</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const signUpButton = document.getElementById('signUp');
        const signInButton = document.getElementById('signIn');
        const container = document.getElementById('container');

        signUpButton.addEventListener('click', () => {
            container.classList.add("right-panel-active");
        });

        signInButton.addEventListener('click', () => {
            container.classList.remove("right-panel-active");
        });

        // Check if we should show the register panel by default
        if (`{{ Route::currentRouteName() }}` === 'register') {
            container.classList.add("right-panel-active");
        }
    });
</script>
@endsection