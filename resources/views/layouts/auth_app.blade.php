<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>@yield('title') | {{ config('app.name') }}</title>
    <link rel="icon" type="image/png" href="{{ asset('img/logo_square.png') }}">

    <!-- General CSS Files -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Mulish&display=swap" rel="stylesheet">

    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ asset('web/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('web/css/components.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/css/iziToast.min.css') }}">
    <link href="{{ asset('assets/css/sweetalert.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/css/select2.min.css') }}" rel="stylesheet" type="text/css"/>
    <style>
        body,html
        {
            font-family: 'Mulish', sans-serif;
        }
        .limiter {
            width: 100%;
            margin: 0 auto;
        }
        .container-login100 {
            width: 100%;
            min-height: 100vh;
            display: -webkit-box;
            display: -webkit-flex;
            display: -moz-box;
            display: -ms-flexbox;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            align-items: center;
            background: #f2f2f2;
        }
        .wrap-login100 {
            width: 100%;
            background: #fff;
            overflow: hidden;
            display: -webkit-box;
            display: -webkit-flex;
            display: -moz-box;
            display: -ms-flexbox;
            display: flex;
            flex-wrap: wrap;
            align-items: stretch;
            flex-direction: row-reverse;
        }
        .login100-form {
            width: 560px;
            min-height: 100vh;
            background-color: #F9F871;
            display: block;
            position: relative;
        }
        .login100-more {
            width: calc(100% - 560px);
            /* background-repeat: no-repeat;
            background-size: cover;
            background-position: center bottom; */
            position: relative;
            z-index: 1;
        }
        .bottom img
        {
            position: fixed;
            left: 5%;
            bottom: 0;
            width: 600px;
        }
        .top img
        {
            position: fixed;
            left: 4%;
            top: 5%;
        }
        .centered{
            position: relative;
            top: 55%;
            transform: translate(0,-50%);
        }
        .card
        {
            background-color: #F9F871;
            box-shadow: none;
        }
        @media (max-width: 768px) {
            .bottom
            {
                display: none;
            }
            .login100-form {
                width: 100%;
                transform: translate(0,0%);
            }
        }
        
        .text-bold
        {
            font-weight: bold;
        }
        .text-grey
        {
            color:#333331 !important;
        }
        .form-control
        {
            border: 2px solid #333331;
            border-radius: 0 !important;
        }
        .btn
        {
            border-radius: 0 !important;
        }
        .btn-grey
        {
            background-color: #333331 !important;
        }
        .btn-white
        {
            border: 2px solid #333331;
            background-color: white;
        }
        .btn-white:focus
        {
            border: 2px solid #333331;
        }
        .alert {
            border-radius: 0;
        }
    </style>
</head>

<body>
{{-- <div id="app">
    <section class="section">
        <div class="container mt-5">
            <div class="row">
                <div class="col-md-6 offset-md-3">
                    <div class="login-brand">
                        <img src="{{ asset('img/logo.png') }}" alt="logo" width="100"
                             class="shadow-light">
                    </div>
                    @yield('content')
                    <div class="simple-footer">
{{--                        Copyright &copy; {{ getSettingValue('application_name') }}  {{ date('Y') }}
                    </div>
                </div>
            </div>
        </div>
    </section>
</div> --}}
<div class="limiter">
    <div class="container-login100">
        <div class="bottom">
            @yield('images')
        </div>
        <div class="top">
            <a href="{{url('/')}}">
                <img src="{{asset('img/logo_black.png')}}" alt="">
            </a>
        </div>
        <div class="wrap-login100">
            <div class="login100-form">
                <div class="centered">
                    <div class="row justify-content-center">
                        <div class="col-md-10">
                            @yield('content')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- General JS Scripts -->
<script src="{{ asset('assets/js/jquery.min.js') }}"></script>
<script src="{{ asset('assets/js/popper.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery.nicescroll.js') }}"></script>

<!-- JS Libraies -->

<!-- Template JS File -->
<script src="{{ asset('web/js/stisla.js') }}"></script>
<script src="{{ asset('web/js/scripts.js') }}"></script>
<!-- Page Specific JS File -->
</body>
</html>
