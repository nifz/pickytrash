<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    {{-- <link href="https://fonts.googleapis.com/css2?family=Ubuntu&display=swap" rel="stylesheet"> --}}
    <link href="https://fonts.googleapis.com/css2?family=Mulish&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <link href="{{ asset('assets/css/@fortawesome/fontawesome-free/css/all.css') }}" rel="stylesheet" type="text/css">
    <title>{{ config('app.name') }}</title>
    <link rel="icon" type="image/png" href="{{ asset('img/logo_square.png') }}">
    <!-- Owl Stylesheets -->
    <link rel="stylesheet" href="https://syntx.id/assets/owlcarousel/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="https://syntx.id/assets/owlcarousel/assets/owl.theme.default.min.css">
    <style>
        body, html{
        height: 100%;
        width: 100%;
        font-family: 'Mulish', sans-serif;
        }
 		.navbar{
 			z-index: 2;
 			transition: 0.5s;
 			background-color: rgba(255, 255, 255, 0);
 		}
        .text-warning
        {
            color: #F9F871 !important;
        }
        .border-bold
        {
            border-width: 3px !important;
        }
        .bg-team
        {
            background-image: url('{{ asset('img/team/bg.png') }}');
            padding: 50px 0px 30px 0px;
			background-repeat:no-repeat;
 			position: relative;
        }
        .nav-item .active
        {
            color: #F9F871 !important;
        }
        a.text-primary:focus, a.text-primary:hover{
            color: #4457b5 !important;
        }
 		#fa_bars{
 			color:#000;
 		}
        .bg-dark
        {
            background-color: #333331 !important;
        }
        .text-bold
        {
            font-weight: bold;
        }
        .text-primary
        {
            color: #4457b5 !important;
        }
        .text-success
        {
            color: #68b544 !important;
        }
        .btn-primary
        {
            background-color: #4457b5 !important;
            border: 0 !important;
        }
        .btn:focus,.btn:active {
            outline: none !important;
            box-shadow: none !important;
        }
        .btn-success
        {
            background-color: #68b544 !important;
        }
        .border-none
        {
            border: none;
            outline: none !important;
            box-shadow: none !important;
        }

        .btn
        {
            border-radius: 0;
        }
        .btn-white
        {
            background-color: white !important;
        }
        .border-radius-10
        {
            border-radius: 10px;
        }
        .text-semibold
        {
            font-weight: 500;
        }
        .text-black
        {
            color: black;
        }
        .text-gray
        {
            color: rgba(0, 0, 0, 0.4);
        }
        .card_portofolio{
            width: 100%;
            background-color: #333331; 
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.07);
            margin-bottom: 20px;
            transition: 1s;
            position: relative;
            overflow: hidden;
        }
        .card_team{
            width: 100%;
            background-color: white; 
            border-radius: 10px; 
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.07);
            margin-bottom: 20px;
            transition: 1s;
            position: relative;
            overflow: hidden;
        }
        .aligen
        {
            position: absolute; 
            top: 90%; 
            transform: translate(0%, -70%);
        }
        .btn-portofolio{
            position: relative;
            border-radius: 5px; 
            background-color: #4457b5; 
            border: none; 
            font-weight: bold; 
            position: absolute; 
            top: 90%; 
            left: 50%; 
            transform: translate(-50%, -50%);
            overflow: hidden;
        }
        .btn-portofolio:before{
            content: "";
            position: absolute;
            left: -10px;
            top: 0;
            width: 0px;
            height: 100%;
            background-color: #1e1e8a;
            transform: skew(-25deg);
            transition: .3s;
            z-index: -1;
        }
        .spacer {
            width: 100%;
            height: 100px;
        }
        .spirate
        {
            color: rgba(0, 0, 0, 0.07);
            font-size: 2rem;
            top: -10px;
            position: relative;
        }
        .img-team
        {
            height: 95%;
        }
        .noline
        {
            text-decoration: none !important;
        }
        .btn-grey
        {
            color: #fff !important;
            background-color:#333331;
            /* padding: .4rem 1.5rem !important; */
            border-radius: 0 !important;
        }
        @media (max-width: 768px) {
            .navbar-light
            {
                background-color: #f8f9fa!important;
            }
            .img-team
            {
                width: 100%;
            }
            .spirate
            {
                display: none;
            }
            .abot
            {
                width: 100%;
            }
            .card_desc
            {
                margin-top: -120px !important;
                background-color: #333331 !important;
            }
        }
        @media (min-width: 768px) {
            .nav-item
            {
                margin: 0 10px !important;
            }
            .title
            {
                font-size: 3.5rem;
            }
            .btn-login
            {
                color: #F9F871 !important;
                border:#F9F871 solid 1px;
                padding: .4rem 1.5rem !important;
            }
            .btn-login:hover,a.btn-login:focus, a.btn-login:hover
            {
                color: #333331 !important;
                background-color: #F9F871 !important;
            }
            .nav-item .active
            {
                color: #F9F871 !important;
                border-bottom: 2px solid #F9F871;
            }
            .nav-link:hover
            {
                color: #F9F871 !important;
            }
            .w-100
            {
                width: 90% !important;
            }
            .ima
            {
                padding-left: 0 !important;
            }
            .centered{
                position: relative;
                top: 50%;
                transform: translate(10%,-50%);
            }
            .profil
            {
                min-height: 100px;
                width: 100%;
                background: linear-gradient(to right, #333331 73%, #f8f9fc 0%);
            }
            .contact
            {
                min-height: 100px;
                width: 100%;
                background: linear-gradient(to right, #f8f9fc 55%, #F9F871 50%);
            }
            .rg{
                width: 100%;
                background: linear-gradient(to right, #f8f9fc 40%, #F9F871 0%);
            }
        }
        .rg{
            width: 100%;
            background-color: #F9F871;
        }
        .profile
        {
            min-height: 100px;
            width: 100%;
            background-color: #f8f9fc;
        }
        .profil
        {
            min-height: 100px;
            width: 100%;
            background-color: #333331;
        }
 		.fs{
			width: 100%;
 		}
        .sell,.contact
        {
            min-height: 100px;
            width: 100%;
            background-color: #F9F871;
        }
        .team
        {
            min-height: 100px;
            width: 100%;;
            background-color: #f8f9fc;
        }
        .footer
        {
            color: white;
            min-height: auto;
            width: 100%;;
            background-color: #333331;
        }
        .card_desc
        {
            background-color: #333331;
            font-size: .8em;
        }
        .owl-nav
        {
            display: none;
        }
        .br-none
        {
            border: none;
        }
        .form-control, .input-group-text 
        {
            border: 1px solid #333331;
            border-radius: 0 !important;
            box-shadow: none !important;
        }
        .form-control:focus, .input-group-text:focus, .custom-select:focus, .custom-file-label:focus 
        {
            background-color: #fefeff;
            border-color: #333331;
        }
        .btn-secondary 
        {
            border: 1px solid #333331;
            background-color: white;
            color: #000 !important;
            border-radius: 0;
            box-shadow: none;
        }
        .btn-secondary:hover 
        {
            color: #fff !important;
            background-color: #333331 !important;
        }
        .dropdown-menu 
        {
            border-radius: 0;
        }
        .dropdown-item.active, .dropdown-item:active 
        {
            color: #fff;
            text-decoration: none;
            background-color: #333331;
        }
        .submitted 
        {
            opacity: .5;
            cursor: not-allowed;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-md fixed-top navbar-dark bg-dark" id="navbar">
        <div class="container pl-3">
            <a class="navbar-brand" href="{{url('/')}}">
                <img src="{{asset('img/logo_white.png')}}" height="40" alt="">
            </a>
            <button class="navbar-toggler" style="border-color: transparent;" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link activated active" href="#header">Home <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link activated" href="#profile">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link activated" href="#sell">Price</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link activated" href="#team">Team</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link activated" href="#contact">Contact</a>
                    </li>
                </ul>
                <ul class="navbar-nav ml-auto">
                    @guest
                        <li class="nav-item">
                            <a class="nav-link btn-transparent btn-login" href="{{route('login')}}">Log In</a>
                        </li>
                    @else
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Halo, {{Auth::user()->name}}
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{route(Role::is().'.dashboard')}}">Dashboard</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item text-danger" href="{{ url('logout') }}" onclick="event.preventDefault(); localStorage.clear();  document.getElementById('logout-form').submit();">Logout</a>
                            </div>
                        </li>
                        <form id="logout-form" action="{{ url('/logout') }}" method="POST" class="d-none">
                            {{ csrf_field() }}
                        </form>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>
    <section class="fs header" id="header">
        <div class="rg">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6 ima">
                        <img src="{{asset('img/hero.png')}}" style="margin-top: 100px; width: 100%" class="mb-5">
                    </div>
                    <div class="col-md-5">
                        <div class="centered py-3">
                            <h6>Jadikan lingkungan yang bersih dan sehat</h6>
                            <h1 class="title text-bold">Jual Sampah Dimanapun</h1>
                            <div class="col-md-8" style="padding: 0 !important;">
                                <a href="{{route('register')}}" class="bg-white text-black btn-block btn my-4" style="border-radius: 0 !important; text-align: left !important">Daftar Sekarang <i class="fas fa-arrow-right py-1" style="float: right !important;"></i></a>
                                <p>Bumi bersih hidup pun sehat, ciptakan lingkungan bersih dengan mudah, menggunakan digital.</p>
                                <a href="#profile" class="bg-white px-2 py-1 mb-3 text-secondary" style="border-radius: 100%; float: right;"><i class="fas fa-arrow-down"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section id="profile" class="profile">
        <div class="spacer"></div>
        <div class="profil">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="spacer"></div>
                    {{-- <h2 class="text-center px-2 text-bold">Profil</h2> --}}
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="card-title pt-4 text-bold text-warning text-uppercase">About us</h6>
                        <h2 class="text-white font-bold">Kami menjemput, membersihkan dan selalu bersih</h2>
                        <p class="text-white">Platform global yang mendukung penghijauan Dunia dengan cara menjaga kualitas lingkungan. Kami disini sebagai perusahaan pengangkut, pengumpul, pemanfaat, serta pengolah sampah yang menjalankan program ramah  lingkungan dengan metode modern dan bermanfaat bagi masyarakat melalui program buang sampah digital.</p>
                        <div class="spacer"></div>
                    </div>
                    <div class="col-md-4 offset-md-1">
                        <img src="{{asset('img/about.png')}}" class="abot" style="margin-top: -40px; width: 100%">
                        <div class="spacer d-block d-md-none"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="spacer"></div>
    </section>
    <section id="sell" class="sell">
        <div class="container">
            <div class="row justify-content-center">
                <div class="spacer"></div>
                <h2 class="text-center px-2 text-bold">Jual sampah anda dan dapatkan banyak <br>keuntungan</h2>
                <div class="owl-carousel owl-theme nonloop pt-4">
                    @foreach($types as $ty)
                    <div style="padding: 10px;">
                        <div class="card_portofolio">
                            <img src="{{asset($ty->image)}}" alt="logo">
                            <p class="text-white text-semibold px-3 pt-3 card_desc">
                                {{$ty->type}}
                                <span class="text-warning" style="float:right;">Rp.{{number_format($ty->price)}}/kg</span>
                            </p>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="card bg-transparent br-none">
                    <h2 class="text-center px-2 pt-5 text-bold">Kalkulator</h2>
                    <div class="card-body">
                        <div class="input-wrapper">
                            <div class="form-group row">
                                <label for="garbage" class="col-md-3 col-form-label">Jenis Sampah</label>
                                <div class="col-10 col-md-8">
                                    <select name="garbage[]" id="0" class="form-control garbage">
                                        <option value="" selected disabled>== Jenis Sampah ==</option>
                                        @foreach($types as $type)
                                            @if($type->status == 1)
                                                <option value="{{$type->id}}">{{$type->type}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                                <button type="button" id="add" class="btn btn-grey btn_qty"><i class="fas fa-plus"></i></button>
                            </div>
                            <div class="form-group row">
                                <label for="qty" class="col-md-3 col-form-label">Per</label>
                                <div class="col-4 col-md-3">
                                    <div class="input-group mb-2 mr-sm-2">
                                        <input type="number" class="form-control qty" name="qty[0]" id="0" min="1" step="0.1" value="1" placeholder="0.0" required disabled>
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">kg</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-8 col-md-6">
                                    <div class="input-group mb-2 mr-sm-2">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">Rp</div>
                                        </div>
                                        <input type="hidden" class="realprice" id="realprice0" name="realprice">
                                        <input type="text" class="form-control price" id="price0" name="price" value="0" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="form-group row">
                            <label for="qty" class="col-md-3 col-form-label">Total</label>
                            <div class="col-12 col-md-9">
                                <div class="input-group mb-2 mr-sm-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">Rp</div>
                                    </div>
                                    <input type="hidden" class="realtotal">
                                    <input type="text" class="form-control total" id="total" value="0" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="spacer"></div>
            </div>
        </div>
    </section>
    <section id="team" class="team">
        <div class="container">
            <div class="row justify-content-center">
                <div class="spacer"></div>
                <h2 class="text-center px-2 text-bold mb-5">Team</h2>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-4">
                    <div class="row bg-team">
                        <div class="col-4">
                            <img src="{{asset('img/team/bugita.png')}}" class="w-100">
                        </div>
                        <div class="col-8">
                            <h5 class="text-bold text-white">Gita Fadila Fitriana, S.Kom., M.Kom</h5>
                            <span class="text-warning">Pembimbing</span>
                        </div>
                    </div>
                    <div class="row my-5 bg-team">
                        <div class="col-4">
                            <img src="{{asset('img/team/beny.png')}}" class="w-100">
                        </div>
                        <div class="col-8">
                            <h5 class="text-bold text-white">Rohman Beny R</h5>
                            <span class="text-warning">UI / UX Designer</span>
                            <h6 class="mt-2 text-white">S1 Software Engineering</h6>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 offset-md-1">
                    <div class="row bg-team">
                        <div class="col-4">
                            <img src="{{asset('img/team/hanif.png')}}" class="w-100">
                        </div>
                        <div class="col-8">
                            <h5 class="text-bold text-white">Mochammad Hanif</h5>
                            <span class="text-warning">Programmer</span>
                            <h6 class="mt-2 text-white">S1 Software Engineering</h6>
                        </div>
                    </div>
                    <div class="row my-5 bg-team">
                        <div class="col-4">
                            <img src="{{asset('img/team/rendi.png')}}" class="w-100">
                        </div>
                        <div class="col-8">
                            <h5 class="text-bold text-white">Rendi Putra Pradana</h5>
                            <span class="text-warning">System Analysis</span>
                            <h6 class="mt-2 text-white">S1 Software Engineering</h6>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="spacer"></div>
            </div>
        </div>
    </section>
    <section id="contact" class="contact">
        <div class="container">
            <div class="row">
                <div class="spacer"></div>
                <div class="col-md-4">
                    <h3 class="text-bold mb-4">Hubungi Kami</h3>
                    <form  method="POST" action="{{ route('contact_us_store') }}" enctype="multipart/form-data">
                        @csrf
                    <div class="form-group">
                        <label for="name">Nama</label>
                        <input type="text" name="name" id="name" class="form-control" style="background-color: transparent; border: black 1px solid; border-radius: 0;" placeholder="Masukkan nama" aria-describedby="name" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="text" name="email" id="email" class="form-control" style="background-color: transparent; border: black 1px solid; border-radius: 0;" placeholder="Masukkan email" aria-describedby="email" required>
                    </div>
                    <div class="form-group">
                        <label for="subject">Subject</label>
                        <input type="text" name="subject" id="subject" class="form-control" style="background-color: transparent; border: black 1px solid; border-radius: 0;" placeholder="Masukkan subject" aria-describedby="subject" required>
                    </div>
                    <div class="form-group">
                        <label for="message">Pesan</label>
                        <textarea name="message" id="message" class="form-control" style="background-color: transparent; border: black 1px solid; border-radius: 0;" placeholder="Masukkan pesan" aria-describedby="message" rows="3" required></textarea>
                    </div>
                    <button class="btn btn-grey px-3">Kirim Pesan</button>
                    </form>
                </div>
                <div class="col-md-5 mt-5">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d8113882.799116625!2d105.2794756253608!3d-6.787270333163018!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e655ea49d9f9885%3A0x62be0b6159700ec9!2sInstitut%20Teknologi%20Telkom%20Purwokerto!5e0!3m2!1sid!2sid!4v1625218008649!5m2!1sid!2sid" height="450" width="100%" style="border:0; box-shadow: 0px 0px 9px rgb(0 0 0 / 20%);" allowfullscreen="" loading="lazy"></iframe>
                </div>
                <div class="col-md-2 mt-5">
                    <div class="mb-5">
                        <span class="text-uppercase text-bold"><i class="fas fa-mobile-alt"></i>&nbsp;&nbsp;Phones</span>
                        <ul style="list-style-type: none; padding-inline-start: 2px !important;" class="mt-1">
                            <li style="padding: 0;">081390919501</li>
                            <li>085155116676</li>
                        </ul>
                    </div>
                    <div class="mb-5">
                        <span class="text-uppercase text-bold"><i class="far fa-envelope"></i>&nbsp;&nbsp;Email</span>
                        <ul style="list-style-type: none; padding-inline-start: 2px !important;" class="mt-1">
                            <li style="padding: 0;">pickytrash@gmail.com</li>
                        </ul>
                    </div>
                    <div class="mb-5">
                        <span class="text-uppercase text-bold"><i class="fas fa-map-marker-alt"></i>&nbsp;&nbsp;Alamat</span>
                        <ul style="list-style-type: none; padding-inline-start: 2px !important;" class="mt-1">
                            <li style="padding: 0;">Telkom Purwokerto</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="spacer"></div>
        </div>
    </section>
    <section id="footer" class="footer">
        <div class="container">
            <div class="row py-5">
                <div class="col-md-3">
                    <img src="{{asset('img/logo_white.png')}}" alt="" class="w-100">
                    <p>Kami menciptakan kemungkinan untuk dunia yang <span class="text-bold">bersih</span> dan <span class="text-bold">sehat</span></p>
                </div>
                <div class="col-md-2 offset-md-5">
                    <span class="text-bold pb-2 border-bold border-bottom">Explore</span>
                    <ul style="list-style-type: none; padding-inline-start: 2px !important;" class="mt-3">
                        <li style="padding: 0;">
                            <a href="#header" class="text-white">Home</a>
                        </li>
                        <li>
                            <a href="#profile" class="text-white">About Us</a>
                        </li>
                        <li>
                            <a href="#sell" class="text-white">Price</a>
                        </li>
                        <li>
                            <a href="#sell" class="text-white">Team</a>
                        </li>
                        <li>
                            <a href="#contact" class="text-white">Contact Us</a>
                        </li>
                    </ul>
                </div>
                <div class="col-md-2">
                    <span class="text-bold pb-2 border-bold border-bottom">Quick Links</span>
                    <ul style="list-style-type: none; padding-inline-start: 2px !important;" class="mt-3">
                        <li style="padding: 0;">
                            <a href="{{route('register')}}" class="text-white">Sign up</a>
                        </li>
                        <li>
                            <a href="{{route('login')}}" class="text-white">Log In</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <hr style="border-color: white;">
        <div class="container">
            <div class="d-flex justify-content-center justify-content-lg-between pt-2 pb-4">
                <!-- Left -->
                <div class="me-5 d-none d-lg-block">
                  <span>Copyright &copy; 2021. All right reserved.</span>
                </div>
                <!-- Left -->
  
                <!-- Right -->
                <div>
                    <a href="" class="px-2 text-white noline">
                        <i class="fab fa-youtube"></i>
                    </a>
                    <a href="" class="px-2 text-white noline">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="" class="px-2 text-white noline">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="" class="px-2 text-white noline">
                        <i class="fab fa-twitter"></i>
                    </a>
                </div>
                <!-- Right -->
            </div>
        </div>
    </section>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
    <!-- javascript owlcarousel -->
    <script src="https://syntx.id/assets/vendors/jquery.min.js"></script>
    <script src="https://syntx.id/assets/owlcarousel/owl.carousel.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        @if(session('sukses'))
            alert('Pesan anda berhasil dikirim.');
        @endif
        $('form').submit(function (event) {
            if ($(this).hasClass('submitted')) {
                event.preventDefault();
            }
            else {
                $(this).find(':submit').html('<i class="fa fa-spinner fa-spin"></i>');
                $(this).addClass('submitted');
            }
        });
        function getprice() {
            let gprice = document.getElementsByName("price");
            let totalprice = 0;
            for(var i = 0; i < gprice.length; i++){
                totalprice += parseInt(gprice[i].value);
            }
            $('#total').val(totalprice);
        }
        $(document).ready(function(){
            var no = 0;
            var total = {{ count($types) }};
            $('#add').click(function(){
                if(no+1 < total)
                {
                    no++;
                    $('.input-wrapper').append(`
                        <div id="temp`+no+`">
                            <div class="form-group row">
                                <label for="garbage" class="col-md-3 col-form-label">Jenis Sampah</label>
                                <div class="col-10 col-md-8">
                                    <select name="garbage[]" id="`+no+`" class="form-control garbage">
                                        <option value="" selected disabled>== Jenis Sampah ==</option>
                                        @foreach($types as $type)
                                            @if($type->status == 1)
                                                <option value="{{$type->id}}">{{$type->type}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                                <button type="button" id="`+no+`" class="btn btn-secondary btn_remove btn_qty"><i class="fas fa-minus"></i></button>
                            </div>
                            <div class="form-group row">
                                <label for="qty" class="col-md-3 col-form-label">Per</label>
                                <div class="col-4 col-md-3">
                                    <div class="input-group mb-2 mr-sm-2">
                                        <input type="number" class="form-control qty" name="qty[`+no+`]" id="`+no+`" step="0.1" value="1" min="1" placeholder="0.0" required disabled>
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">kg</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-8 col-md-6">
                                    <div class="input-group mb-2 mr-sm-2">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">Rp</div>
                                        </div>
                                        <input type="hidden" class="realprice" id="realprice`+no+`" name="realprice">
                                        <input type="text" class="form-control price" name="price" id="price`+no+`" value="0" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `);
                }
            });

            $(document).on('click', '.btn_remove', function(){
                no--;
                var button_id = $(this).attr("id"); 
                $('#temp'+button_id).remove();
            });
            $(document).on('change', '.garbage', function(){
                var button_id = $(this).attr("id"); 
                axios.post('{{ route('types.store') }}', {id: $(this).val()}).then(function (response) {
                    $('#price'+button_id).val(Math.round(response.data.price));
                    $('#realprice'+button_id).val(response.data.price);
                    $('[name="qty['+button_id+']"]').prop("disabled", false);
                    $('[name="qty['+button_id+']"]').val(1);
                    getprice();
                });
            });
            $(document).on('change', '.qty', function(){
                var button_id = $(this).attr("id"); 
                var price = $('#realprice'+button_id).val();
                var qty = $(this).val();
                var count = price * qty;
                $('#price'+button_id).val(Math.round(count));          
            });
            $(document).on('click', function(){
                getprice();
            });
        });
        $('.owl-carousel').owlCarousel({
            loop:false,
            margin:10,
            nav:true,
            responsive:{
                0:{
                    items:1
                },
                600:{
                    items:3
                },
                1000:{
                    items:4
                }
            }
        });
        $(document).ready(function () {
            $(document).on("scroll", onScroll);
            //smoothscroll
            $(document).on('click', 'a[href^="#"]', function (event) {
                event.preventDefault();
                // $(document).off("scroll");
                $('a').each(function () {
                    $(this).removeClass('active');
                })
                $(this).addClass('active');
                window.location.hash = "";
                $('html, body').stop().animate({
                    scrollTop: $($.attr(this, 'href')).offset().top + 1
                }, 500, 'swing', function () {
                    $(document).on("scroll", onScroll);
                });
            });
        });

        function onScroll(){
            console.clear();
            history.replaceState('', document.title, window.location.origin + window.location.pathname + window.location.search);
            var scrollPos = $(this).scrollTop();
            $('#navbarSupportedContent .activated').each(function () {
                var currLink = $(this);
                var refElement = $(currLink.attr("href"));
                if (refElement.position().top <= scrollPos && refElement.position().top + refElement.height() > scrollPos) {
                    $('#navbarSupportedContent ul li .activated').removeClass("active");
                    currLink.addClass("active");
                }
                else{
                    currLink.removeClass("active");
                }
            });
        }
    </script>
</body>
</html>