@extends('layouts.auth_app')
@section('title')
    Register
@endsection
@section('images')
    <img src="{{asset('img/register.png')}}">
@endsection
@section('content')
    <div class="card">
        <div class="card-body">
            <a href="{{url('/')}}" class="d-block d-md-none">
                <center>
                    <img src="{{asset('img/logo_black.png')}}" alt="" class="mb-5">
                </center>
            </a>
            <h3 class="text-bold text-grey">Sign up.</h3>
            <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group mt-4">
                            <label for="first_name">Full Name:</label><span
                                    class="text-danger">*</span>
                            <input id="firstName" type="text"
                                   class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                                   name="name"
                                   tabindex="1" placeholder="Enter Full Name" value="{{ old('name') }}"
                                   autofocus required>
                            <div class="invalid-feedback">
                                {{ $errors->first('name') }}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="email">Email:</label><span
                                    class="text-danger">*</span>
                            <input id="email" type="email"
                                   class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                                   placeholder="Enter Email address" name="email" tabindex="1"
                                   value="{{ old('email') }}"
                                   required autofocus>
                            <div class="invalid-feedback">
                                {{ $errors->first('email') }}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="password" class="control-label">Password
                                :</label><span
                                    class="text-danger">*</span>
                            <input id="password" type="password"
                                   class="form-control{{ $errors->has('password') ? ' is-invalid': '' }}"
                                   placeholder="Set account password" name="password" tabindex="2" required>
                            <div class="invalid-feedback">
                                {{ $errors->first('password') }}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="password_confirmation"
                                   class="control-label">Confirm Password:</label><span
                                    class="text-danger">*</span>
                            <input id="password_confirmation" type="password" placeholder="Confirm account password"
                                   class="form-control{{ $errors->has('password_confirmation') ? ' is-invalid': '' }}"
                                   name="password_confirmation" tabindex="2">
                            <div class="invalid-feedback">
                                {{ $errors->first('password_confirmation') }}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 mt-2">
                        <div class="form-group">
                            <button type="submit" class="btn btn-grey btn-lg btn-block text-white" tabindex="4">
                                Register
                            </button>
                        </div>
                    </div>
                </div>
            </form>
            <div style="margin-bottom: -15px;"></div>
            <hr>
            <div class="form-group text-center pb-5">
                <div><small>Sudah mempunyai akun?</small></div>
                <a href="{{route('login')}}" class="btn btn-white text-black px-4" tabindex="4">
                    Log in
                </a>
            </div>
        </div>
    </div>
@endsection
