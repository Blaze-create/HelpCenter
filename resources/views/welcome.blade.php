@extends('layouts.default')
@section('content')
    <div class="container-fluid">
        <div class="home-wrapper">
            <h1>HelpCenter ICT</h1>
            <form class="form-wrapper" id="loginForm" method="POST" action="{{ route('login') }}">
                @csrf
                <div class="logo">
                    <img src="img/logo.png" alt="">
                </div>
                <div class="title">
                    Login
                </div>
                <div class="input-grp">
                    <input type="text" required placeholder="Employee ID" id="username" name="username">
                    <i class="fa-solid fa-user"></i>
                </div>
                <span class="error" id="username_error">U</span>
                <div class="input-grp">
                    <input type="password" required placeholder="Password" id="password" name="password">
                    <i class="fa-solid fa-lock"></i>
                </div>
                <span class="error" id="password_error">U</span>
                @if ($errors->has('username'))
                    <p>{{ $errors->first('username') }}</p>
                @endif
                <div class="submit-grp">
                    <input type="submit" name="loginSubmit" id="" value="Login">
                </div>
            </form>
        </div>
    </div>
@endsection
