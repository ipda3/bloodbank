<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.rtlcss.com/bootstrap/v4.2.1/css/bootstrap.min.css"
          integrity="sha384-vus3nQHTD+5mpDiZ4rkEPlnkcyTP+49BhJ4wJeJunw06ZAp+wzzeBPUXr42fi8If" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css"
          integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">

    <!-- custom CSS -->
    <link rel="stylesheet" href="{{asset('front/css/owl.carousel.min.css')}}">
    <link rel=stylesheet href="{{asset('front/css/owl.theme.default.min.css')}}">
    <link rel="stylesheet" href="{{asset('front/css/hover-min.css')}}">
    <link rel="stylesheet" href="{{asset('front/css/style.css')}}">
    <!-- custom font -->
    <link href="https://fonts.googleapis.com/css?family=Cairo&display=swap" rel="stylesheet">

    <title>بنك الدم الرئيسية </title>
</head>
<body>
<!-- top nav section -->
<section id="top-nav">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="lang">
                    <span><a href="#" id="arabic">عربى</a></span>
                    <span><a href="#" id="en">EN</a></span>
                </div>
            </div>
            <div class="col-md-4">
                <div class="social-media">
                    <i class="fab fa-facebook-f"></i>
                    <i class="fab fa-instagram"></i>
                    <i class="fab fa-twitter"></i>
                    <i class="fab fa-whatsapp"></i>

                </div>

            </div>
            <div class="col-md-4">
                <div class="contact">

                    <p class="email"> bloodbank@gmail.com</p>

                    <i class="fas fa-envelope-square email "></i>
                    <p class="phone "> +966506954964
                    </p>
                    <i class="fas fa-phone-volume phone hvr-buzz"></i>
                </div>

            </div>
        </div>

    </div>
</section>
<!-- oradaniry nav section -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="nav-logo " href="home.blade.php"><img class="logo" src="{{asset('front/imgs/logo.png')}}"></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText"
            aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarText">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">

                <a class="nav-link " href="home.blade.php">الرئيسية </a>
                <span class="test"></span>


            </li>
            <li class="nav-item">
                <a class="nav-link border-left" href="#">عن بنك الدم </a>
            </li>
            <li class="nav-item">
                <a class="nav-link border-left" href="#">المقالات</a>
            </li>
            <li class="nav-item">
                <a class="nav-link border-left" href="donations.blade.php">طلبات التبرع</a>
            </li>
            <li class="nav-item">
                <a class="nav-link border-left" href="how-we-are.blade.php">من نحن</a>

            </li>
            <li class="nav-item">
                <a class="nav-link border-left" href="contact-us.blade.php">اتصل بنا </a>
            </li>
        </ul>
        @if(auth()->guard('client')->check())
            <a href="{{url('client/logout')}}" ><button class="btn login-btn shadow"> تسجيل خروج</button></a>

        @else
            <span class="navbar-text">
           <a class="new-account" href="{{url('sign-up')}}">انشاء حــساب جديد</a>
           <a href="{{url('client-login')}}"><button class="btn login-btn shadow">دخول</button></a>
          </span>
        @endif
    </div>
</nav>
