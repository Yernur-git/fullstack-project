@extends('layouts.site')

@section('title', __('Login and Register - Creator File Storage'))

@section('content')
<div class="section" style="margin-top:0;">
    <div class="eyebrow">{{ __('Account access') }}</div>
    <h1 style="font-size:clamp(28px,5vw,42px);">{{ __('Login or create your account.') }}</h1>
    <p>{{ __('Authentication keeps uploaded files connected to the right editor, creator, or photographer.') }}</p>
</div>

<section class="section">
    <div class="card form-card" id="loginCard">
        <h2>{{ __('Welcome Back') }}</h2>
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="field">
                <label for="username">{{ __('Username or Email') }}</label>
                <input id="username" name="username" autocomplete="username" required>
            </div>
            <div class="field">
                <label for="password">{{ __('Password') }}</label>
                <input id="password" type="password" name="password" autocomplete="current-password" required>
            </div>
            <button class="btn primary" type="submit" style="width:100%;">{{ __('Log In') }}</button>
        </form>
        <p style="text-align:center;margin-bottom:0;">
            {{ __('No account?') }}
            <button type="button" class="link-button" onclick="showRegister()">{{ __('Create one') }}</button>
        </p>
    </div>

    <div class="card form-card" id="registerCard" style="display:none;">
        <h2>{{ __('Create Account') }}</h2>
        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="field">
                <label for="name">{{ __('Choose a Username') }}</label>
                <input id="name" name="name" autocomplete="username" required>
            </div>
            <div class="field">
                <label for="email">{{ __('Email Address') }}</label>
                <input id="email" type="email" name="email" autocomplete="email" required>
            </div>
            <div class="field">
                <label for="new_password">{{ __('Password') }}</label>
                <input id="new_password" type="password" name="password" minlength="6" autocomplete="new-password" required>
            </div>
            <button class="btn primary" type="submit" style="width:100%;">{{ __('Register') }}</button>
        </form>
        <p style="text-align:center;margin-bottom:0;">
            {{ __('Already have an account?') }}
            <button type="button" class="link-button" onclick="showLogin()">{{ __('Log In') }}</button>
        </p>
    </div>
</section>

<script>
    function showRegister() {
        document.getElementById('loginCard').style.display = 'none';
        document.getElementById('registerCard').style.display = 'block';
    }

    function showLogin() {
        document.getElementById('registerCard').style.display = 'none';
        document.getElementById('loginCard').style.display = 'block';
    }
</script>
@endsection
