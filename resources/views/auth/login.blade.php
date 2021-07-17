@extends('layouts.auth_app')
@section('title')
    Login
@endsection
@section('images')
    <img src="{{asset('img/login.png')}}">
@endsection
@section('content')
    <div class="card">
        <div class="card-body">
            <a href="{{url('/')}}" class="d-block d-md-none">
                <center>
                    <img src="{{asset('img/logo_black.png')}}" alt="" class="mb-5">
                </center>
            </a>
            <h3 class="text-bold text-grey">Log in.</h3>
            <span>Masuk menggunakan data yang anda masukkan saat mendaftar.</span>
            <form method="POST" action="{{ route('login') }}">
                @csrf
                @if ($errors->any())
                    <div class="alert alert-danger p-0">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="form-group mt-4">
                    <label for="email">Email</label>
                    <input aria-describedby="emailHelpBlock" id="email" type="email"
                           class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email"
                           placeholder="Enter Email" tabindex="1"
                           value="{{ (Cookie::get('email') !== null) ? Cookie::get('email') : old('email') }}" autofocus
                           required>
                    <div class="invalid-feedback">
                        {{ $errors->first('email') }}
                    </div>
                </div>

                <div class="form-group">
                    {{-- <div class="d-block">
                        <label for="password" class="control-label">Password</label>
                        <div class="float-right">
                            <a href="{{ route('password.request') }}" class="text-small">
                                Forgot Password?
                            </a>
                        </div>
                    </div> --}}
                    <input aria-describedby="passwordHelpBlock" id="password" type="password"
                           value="{{ (Cookie::get('password') !== null) ? Cookie::get('password') : null }}"
                           placeholder="Enter Password"
                           class="form-control{{ $errors->has('password') ? ' is-invalid': '' }}" name="password"
                           tabindex="2" required>
                    <div class="invalid-feedback">
                        {{ $errors->first('password') }}
                    </div>
                </div>

                <div class="form-group">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" name="remember" class="custom-control-input" tabindex="3"
                               id="remember"{{ (Cookie::get('remember') !== null) ? 'checked' : '' }}>
                        <label class="custom-control-label" for="remember">Remember Me</label>
                    </div>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-grey btn-lg btn-block text-white" tabindex="4">
                        Login
                    </button>
                </div>
            </form>
            <hr>
            <div class="form-group text-center pb-5">
                <div><small>Belum mempunyai akun?</small></div>
                <a href="{{route('register')}}" class="btn btn-white text-black px-4" tabindex="4">
                    Sign Up
                </a>
            </div>
        </div>
    </div>
@endsection
