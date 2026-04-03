<!doctype html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="icon" href="{{ asset('royal-master/image/favicon.png') }}" type="image/png">
        <title>StayFlow - Hôtel Connecté</title>
        <link rel="stylesheet" href="{{ asset('royal-master/css/bootstrap.css') }}">
        <link rel="stylesheet" href="{{ asset('royal-master/vendors/linericon/style.css') }}">
        <link rel="stylesheet" href="{{ asset('royal-master/css/font-awesome.min.css') }}">
        <link rel="stylesheet" href="{{ asset('royal-master/vendors/owl-carousel/owl.carousel.min.css') }}">
        <link rel="stylesheet" href="{{ asset('royal-master/vendors/bootstrap-datepicker/bootstrap-datetimepicker.min.css') }}">
        <link rel="stylesheet" href="{{ asset('royal-master/vendors/nice-select/css/nice-select.css') }}">
        <link rel="stylesheet" href="{{ asset('royal-master/css/style.css') }}">
        <link rel="stylesheet" href="{{ asset('royal-master/css/responsive.css') }}">
    </head>
    <body>
        <header class="header_area">
            <div class="container">
                <nav class="navbar navbar-expand-lg navbar-light">
                    <a class="navbar-brand logo_h" href="{{ url('/') }}">
                        <img src="{{ asset('royal-master/image/Logo.png') }}" alt="Logo">
                    </a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent">
                        <span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span>
                    </button>
                    <div class="collapse navbar-collapse offset" id="navbarSupportedContent">
                        <ul class="nav navbar-nav menu_nav ml-auto">
                            <li class="nav-item active"><a class="nav-link" href="{{ url('/') }}">Accueil</a></li> 
                            <li class="nav-item"><a class="nav-link" href="#about">À propos</a></li>
                            <li class="nav-item"><a class="nav-link" href="#chambres">Hébergement</a></li>
                            <li class="nav-item"><a class="nav-link" href="#contact">Contact</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Connexion</a></li>
                        </ul>
                    </div> 
                </nav>
            </div>
        </header>

        <section class="banner_area">
            <div class="booking_table d_flex align-items-center">
                <div class="overlay bg-parallax" data-stellar-ratio="0.9" data-stellar-vertical-offset="0"></div>
                <div class="container">
                    <div class="banner_content text-center">
                        <h6>Bienvenue sur StayFlow</h6>
                        <h2>L'Hôtel Digital de Demain</h2>
                        <p>Une expérience client simplifiée, de la réservation au check-out.</p>
                        <a href="{{ route('register') }}" class="btn theme_btn button_hover">Créer un compte</a>
                    </div>
                </div>
            </div>
        </section>

        <section class="about_history_area section_gap" id="about">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 d_flex align-items-center">
                        <div class="about_content ">
                            <h2 class="title title_color">À propos de <br>StayFlow</h2>
                            <p>StayFlow est né de la volonté de digitaliser les services hôteliers locaux pour offrir une gestion transparente et moderne. Notre plateforme permet aux clients de gérer leurs séjours en toute autonomie.</p>
                            <a href="{{ route('login') }}" class="button_hover theme_btn_two">Explorer nos services</a>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <img class="img-fluid" src="{{ asset('royal-master/image/about_bg.jpg') }}" alt="About StayFlow">
                    </div>
                </div>
            </div>
        </section>

       <section class="accomodation_area section_gap" id="chambres">
    <div class="container">
        <div class="section_title text-center">
            <h2 class="title_color">Nos Chambres & Suites</h2>
             <h2 class="title_color">Sur Tous Les Formes Et Prix</h2>
            <p>Une technologie de pointe alliée au confort absolu.</p>
        </div>
        <div class="row mb_30">
            <div class="col-lg-3 col-sm-6">
                <div class="accomodation_item text-center">
                    <div class="hotel_img">
                        <img src="{{ asset('royal-master/image/room1.jpg') }}" alt="Chambre Simple">
                        <a href="{{ route('login') }}" class="btn theme_btn button_hover">Réserver</a>
                    </div>
                    <a href="#"><h4 class="sec_h4">Chambre Simple </h4></a>
                    <h5>15 000 FCFA<small>/nuit</small></h5>
                    <p><i class="fa fa-user"></i> 1 Personne</p>
                </div>
            </div>

            <div class="col-lg-3 col-sm-6">
                <div class="accomodation_item text-center">
                    <div class="hotel_img">
                        <img src="{{ asset('royal-master/image/room2.jpg') }}" alt="Chambre Double">
                        <a href="{{ route('login') }}" class="btn theme_btn button_hover">Réserver</a>
                    </div>
                    <a href="#"><h4 class="sec_h4">Chambre Double </h4></a>
                    <h5>25 000 FCFA<small>/nuit</small></h5>
                    <p><i class="fa fa-users"></i> 2 Personnes</p>
                </div>
            </div>

            <div class="col-lg-3 col-sm-6">
                <div class="accomodation_item text-center">
                    <div class="hotel_img">
                        <img src="{{ asset('royal-master/image/room3.jpg') }}" alt="Suite Junior">
                        <a href="{{ route('login') }}" class="btn theme_btn button_hover">Réserver</a>
                    </div>
                    <a href="#"><h4 class="sec_h4">Suite Junior </h4></a>
                    <h5>45 000 FCFA<small>/nuit</small></h5>
                    <p><i class="fa fa-users"></i> 2 Personnes</p>
                </div>
            </div>

            <div class="col-lg-3 col-sm-6">
                <div class="accomodation_item text-center">
                    <div class="hotel_img">
                        <img src="{{ asset('royal-master/image/room4.jpg') }}" alt="Suite Présidentielle">
                        <a href="{{ route('login') }}" class="btn theme_btn button_hover">Réserver</a>
                    </div>
                    <a href="#"><h4 class="sec_h4">Suite Présidentielle </h4></a>
                    <h5>80 000 FCFA<small>/nuit</small></h5>
                    <p><i class="fa fa-users"></i> 4 Personnes</p>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
    <div class="accomodation_item text-center">
        <div class="hotel_img">
            <img src="{{ asset('royal-master/image/room5.jpg') }}" alt="Deluxe Connectée">
            <a href="{{ route('login') }}" class="btn theme_btn button_hover">Réserver</a>
        </div>
        <a href="#"><h4 class="sec_h4">Deluxe Connectée </h4></a>
        <h5>30 000 FCFA<small>/nuit</small></h5>
        <p><i class="fa fa-tablet"></i> Domotique incluse</p>
    </div>
</div>

<div class="col-lg-3 col-sm-6">
    <div class="accomodation_item text-center">
        <div class="hotel_img">
            <img src="{{ asset('royal-master/image/room6.jpg') }}" alt="Suite Familiale">
            <a href="{{ route('login') }}" class="btn theme_btn button_hover">Réserver</a>
        </div>
        <a href="#"><h4 class="sec_h4">Suite Familiale </h4></a>
        <h5>55 000 FCFA<small>/nuit</small></h5>
        <p><i class="fa fa-users"></i> 4 Personnes</p>
    </div>
</div>

<div class="col-lg-3 col-sm-6">
    <div class="accomodation_item text-center">
        <div class="hotel_img">
            <img src="{{ asset('royal-master/image/room7.jpg') }}" alt="Business Smart">
            <a href="{{ route('login') }}" class="btn theme_btn button_hover">Réserver</a>
        </div>
        <a href="#"><h4 class="sec_h4">Business Smart </h4></a>
        <h5>20 000 FCFA<small>/nuit</small></h5>
        <p><i class="fa fa-laptop"></i> Espace Travail</p>
    </div>
</div>

<div class="col-lg-3 col-sm-6">
    <div class="accomodation_item text-center">
        <div class="hotel_img">
            <img src="{{ asset('royal-master/image/room8.jpg') }}" alt="Suite Penthouse">
            <a href="{{ route('login') }}" class="btn theme_btn button_hover">Réserver</a>
        </div>
        <a href="#"><h4 class="sec_h4">Suite Penthouse </h4></a>
        <h5>120 000 FCFA<small>/nuit</small></h5>
        <p><i class="fa fa-star"></i> Vue Panoramique</p>
    </div>
</div>
        </div>
    </div>
</section>
        <section class="contact_area section_gap" id="contact">
            <div class="container text-center">
                <h2 class="title_color">Contactez-nous</h2>
                <p>Une question sur votre future réservation ? Notre équipe est là pour vous aider.</p>
                <div class="row mt-5">
                    <div class="col-md-4">
                        <i class="lnr lnr-home" style="font-size: 30px; color: #f3c300;"></i>
                        <p> Douala,Bonamoussadi</p>
                    </div>
                    <div class="col-md-4">
                        <i class="lnr lnr-phone-handset" style="font-size: 30px; color: #f3c300;"></i>
                        <p>+237 692273676</p>
                        <p>+237 677720883</p>
                    </div>
                    <div class="col-md-4">
                        <i class="lnr lnr-envelope" style="font-size: 30px; color: #f3c300;"></i>
                        <p>stayflow@gmail.com</p>
                    </div>
                </div>
            </div>
        </section>

        <footer class="footer-area section_gap">
            <div class="container text-center">
                <p>&copy; 2026 <b>StayFlow</b> - Projet de fin de formation Localhost Academy.</p>
            </div>
        </footer>

        <script src="{{ asset('royal-master/js/jquery-3.2.1.min.js') }}"></script>
        <script src="{{ asset('royal-master/js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('royal-master/js/stellar.js') }}"></script>
        <script src="{{ asset('royal-master/js/custom.js') }}"></script>
    </body>
</html>