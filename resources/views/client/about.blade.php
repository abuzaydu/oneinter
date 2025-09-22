<!DOCTYPE html>
<html lang="zxx">

<head>
    <title>One-Inter Travel Limited</title>
    <link rel="icon" href="{{ asset('images/inter-logo.png') }}" type="image/gif" sizes="16x16">
    <meta content="text/html;charset=utf-8" http-equiv="Content-Type">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Rentaly - Multipurpose Vehicle Car Rental Website Template" name="description">
    <meta content="" name="keywords">
    <meta content="" name="author">
    <!-- CSS Files
    ================================================== -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" id="bootstrap">
    <link href="{{ asset('css/mdb.min.css') }}" rel="stylesheet" type="text/css" id="mdb">
    <link href="{{ asset('css/plugins.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/coloring.css') }}" rel="stylesheet" type="text/css">
    <!-- color scheme -->
    <link id="colors" href="{{ asset('css/colors/scheme-01.css') }}" rel="stylesheet" type="text/css">
</head>

<body>
    <div id="wrapper">
        
        <!-- page preloader begin -->
        <div id="de-preloader"></div>
        <!-- page preloader close -->

        <!-- header begin -->
        <header class="transparent scroll-light has-topbar">
            <div id="topbar" class="topbar-dark text-light">
                <div class="container">
                    <div class="topbar-left xs-hide">
                        <div class="topbar-widget">
                            <div class="topbar-widget"><a href="#"><i class="fa fa-phone"></i>+255 62 580 1496</a></div>
                            <div class="topbar-widget"><a href="#"><i class="fa fa-envelope"></i>info@oneintertravel.com</a></div>
                            <div class="topbar-widget"><a href="#"><i class="fa fa-clock-o"></i>Mon - Fri 08.00 - 18.00</a></div>
                        </div>
                    </div>
                
                    <div class="topbar-right">
                        <div class="social-icons">
                            <a href="#"><i class="fa fa-facebook fa-lg"></i></a>
                            <a href="#"><i class="fa fa-twitter fa-lg"></i></a>
                            <a href="#"><i class="fa fa-instagram fa-lg"></i></a>
                        </div>
                    </div>  
                    <div class="clearfix"></div>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="de-flex sm-pt10">
                            <div class="de-flex-col">
                                <div class="de-flex-col">
                                    <!-- logo begin -->
                                    <div id="logo">
                                        <a href="{{ route('client.home') }}">
                                            <img class="logo-1" src="{{ asset('images/inter-logo.png') }}" alt="" style="width: 121px; height: 65px;">
                                            <img class="logo-2" src="{{ asset('images/inter-logo.png') }}" alt="" style="width: 121px; height: 65px;">
                                        </a>
                                    </div>
                                    <!-- logo close -->
                                </div>
                            </div>
                            <div class="de-flex-col header-col-mid">
                                <ul id="mainmenu">
                                    <li><a class="menu-item" href="{{ route('client.home') }}">Home</a></li>
                                    <li><a class="menu-item" href="{{ route('client.about') }}">About Us</a></li>
                                    <li><a class="menu-item" href="{{ route('client.cars') }}">Our Fleet</a></li>
                                    <li><a class="menu-item" href="{{ route('client.contact') }}">Contact Us</a></li>
                                    <li><a class="menu-item" href="{{ route('client.quick-booking') }}">Booking</a></li>
                                </ul>
                            </div>
                            <div class="de-flex-col">
                                <div class="menu_side_area">
                                    <a href="{{ route('client.quick-booking') }}" class="btn-main">Book</a>
                                    <span id="menu-btn"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>
            <!-- header close -->
        <!-- content begin -->
        <div class="no-bottom no-top zebra" id="content">
            <div id="top"></div>
            
            <!-- section begin -->
            <section id="subheader" class="jarallax text-light">
                <img src="{{ asset('images/background/subheader.jpg') }}" class="jarallax-img" alt="">
                    <div class="center-y relative text-center">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-12 text-center">
									<h1>About Us</h1>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
            </section>
            <!-- section close -->

            <section>
                <div class="container">
                    <div class="row g-5">
                        <div class="col-lg-6 wow fadeInRight">
                            <h2>We offer customers a wide range of <span class="id-color">cars</span> for any different occasions.</h2>
                        </div>
                        <div class="col-lg-6 wow fadeInRight" data-wow-delay=".25s">
    At One Inter Travel Limited, we are committed to redefining the travel experience with a focus on comfort, reliability, and elegance. Based in Tanzania, we specialize in providing premium car rental services for both city and upcountry travel. Whether you're planning a business trip, a family journey, or a personalized tour, our mission is to ensure every moment of your travel is smooth, safe, and unforgettable. With a customer-first approach and a passion for excellence, we deliver service that goes beyond transportation — we deliver peace of mind.
</div>

                    </div>
                    <div class="spacer-double"></div>
                    <div class="row text-center">
                       
                        <div class="col-md-4 col-sm-6 mb-sm-30">
                            <div class="de_count wow fadeInUp" data-bgcolor="#f5f5f5">
                                <h3 class="timer" data-to="8745" data-speed="3000">0</h3>
                                Happy Customers
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-6 mb-sm-30">
                            <div class="de_count wow fadeInUp" data-bgcolor="#f5f5f5">
                                <h3 class="timer" data-to="235" data-speed="3000">0</h3>
                                Vehicles Fleet
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-6 mb-sm-30">
                            <div class="de_count wow fadeInUp" data-bgcolor="#f5f5f5">
                                <h3 class="timer" data-to="15" data-speed="3000">0</h3>
                                Years Experience
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- <section aria-label="section" class="jarallax text-light">
                <img src="{{ asset('images/background/8.jpg') }}" class="jarallax-img" alt="">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <h2>Board of Directors</h2>
                            <div class="spacer-20"></div>
                        </div>

                        <div class="col-lg-3 col-md-6 col-sm-6 mb30">
                            <div class="f-profile text-center">
                                <div class="fp-wrap f-invert">
                                    <div class="fpw-overlay">
                                        <div class="fpwo-wrap">
                                            <div class="fpwow-icons">
                                                <a href="#"><i class="fa fa-facebook fa-lg"></i></a>
                                                <a href="#"><i class="fa fa-twitter fa-lg"></i></a>
                                                <a href="#"><i class="fa fa-linkedin fa-lg"></i></a>
                                                <a href="#"><i class="fa fa-pinterest fa-lg"></i></a>
                                            </div>
                                        </div>
                                    </div>                                  
                                    <div class="fpw-overlay-btm"></div>
                                    <img src="{{ asset('images/team/1.jpg') }}" class="fp-image img-fluid" alt="">
                                </div>

                                <h4>Fynley Wilkinson</h4>
                                Chief Creative Officer
                            </div>
                        </div>
                        
                        <div class="col-lg-3 col-md-6 col-sm-6 mb30">
                            <div class="f-profile text-center">
                                <div class="fp-wrap f-invert">
                                    <div class="fpw-overlay">
                                        <div class="fpwo-wrap">
                                            <div class="fpwow-icons">
                                                <a href="#"><i class="fa fa-facebook fa-lg"></i></a>
                                                <a href="#"><i class="fa fa-twitter fa-lg"></i></a>
                                                <a href="#"><i class="fa fa-linkedin fa-lg"></i></a>
                                                <a href="#"><i class="fa fa-pinterest fa-lg"></i></a>
                                            </div>
                                        </div>
                                    </div>                                  
                                    <div class="fpw-overlay-btm"></div>
                                    <img src="{{ asset('images/team/2.jpg') }}" class="fp-image img-fluid" alt="">
                                </div>

                                <h4>Peter Welsh</h4>
                                Chief Technology Officer
                            </div>
                        </div>
                        
                        <div class="col-lg-3 col-md-6 col-sm-6 mb30">
                            <div class="f-profile text-center">
                                <div class="fp-wrap f-invert">
                                    <div class="fpw-overlay">
                                        <div class="fpwo-wrap">
                                            <div class="fpwow-icons">
                                                <a href="#"><i class="fa fa-facebook fa-lg"></i></a>
                                                <a href="#"><i class="fa fa-twitter fa-lg"></i></a>
                                                <a href="#"><i class="fa fa-linkedin fa-lg"></i></a>
                                                <a href="#"><i class="fa fa-pinterest fa-lg"></i></a>
                                            </div>
                                        </div>
                                    </div>                                  
                                    <div class="fpw-overlay-btm"></div>
                                    <img src="{{ asset('images/team/3.jpg') }}" class="fp-image img-fluid" alt="">
                                </div>

                                <h4>John Shepard</h4>
                                Chief Executive Officer
                            </div>
                        </div>
                        
                        <div class="col-lg-3 col-md-6 col-sm-6 mb30">
                            <div class="f-profile text-center">
                                <div class="fp-wrap f-invert">
                                    <div class="fpw-overlay">
                                        <div class="fpwo-wrap">
                                            <div class="fpwow-icons">
                                                <a href="#"><i class="fa fa-facebook fa-lg"></i></a>
                                                <a href="#"><i class="fa fa-twitter fa-lg"></i></a>
                                                <a href="#"><i class="fa fa-linkedin fa-lg"></i></a>
                                                <a href="#"><i class="fa fa-pinterest fa-lg"></i></a>
                                            </div>
                                        </div>
                                    </div>                                  
                                    <div class="fpw-overlay-btm"></div>
                                    <img src="{{ asset('images/team/4.jpg') }}" class="fp-image img-fluid" alt="">
                                </div>

                                <h4>Robyn Peel</h4>
                                Director of Finance
                            </div>
                        </div>

                    </div>
                </div>
            </section> -->

            <section aria-label="section">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-lg-6 offset-lg-3 text-center">
                            <!-- <h2>Features Hilight</h2> -->
                            <div class="spacer-20"></div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-lg-3">
                            <div class="box-icon s2 p-small mb20 wow fadeInRight" data-wow-delay=".5s">
                                <i class="fa bg-color fa-id-badge"></i>
                                <div class="d-inner">
                                    <h4>Professional Drivers Services</h4>
                                    Enjoy a premium experience with our well-trained drivers, ensuring comfort, safety, and reliability every time you ride with us.                                </div>
                            </div>
                            <div class="box-icon s2 p-small mb20 wow fadeInL fadeInRight" data-wow-delay=".75s">
                                <i class="fa bg-color fa-calendar"></i>
                                <div class="d-inner">
                                    <h4>Flexible Booking Options</h4>
                                    Book your ride when you need it — whether it’s a few hours, a full day, or long-term. We adapt to your schedule with ease and convenience.                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <img src="{{ asset('images/misc/car.png') }}" alt="" class="img-fluid wow fadeInUp">
                        </div>

                        <div class="col-lg-3">
                            <div class="box-icon s2 d-invert p-small mb20 wow fadeInL fadeInLeft" data-wow-delay="1s">
                                <i class="fa bg-color fa-dollar"></i>
                                <div class="d-inner">
                                    <h4>Premium Quality at Affordable Rates</h4>
                                    Ride in well-maintained, high-quality vehicles at prices that suit your budget — perfect balance between value and comfort.                                </div>
                            </div>
                            <div class="box-icon s2 d-invert p-small mb20 wow fadeInL fadeInLeft" data-wow-delay="1.25s">
                                <i class="fa bg-color fa-car"></i>
                                <div class="d-inner">
                                    <h4>Wide Range of Vehicle Choices</h4>
                                    Choose from a variety of cars to suit every occasion — from executive rides to everyday transport — all driven by our trusted professionals.                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section id="section-img-with-tab">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-lg-5 offset-lg-7">
                            
                            <h2>Only Quality For Clients</h2>
                            <div class="spacer-20"></div>
                            
                            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                              <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Luxury</button>
                              </li>
                              <li class="nav-item" role="presentation">
                                <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Comfort</button>
                              </li>
                              <li class="nav-item" role="presentation">
                                <button class="nav-link" id="pills-contact-tab" data-bs-toggle="pill" data-bs-target="#pills-contact" type="button" role="tab" aria-controls="pills-contact" aria-selected="false">Flexible Booking</button>
                              </li>
                            </ul>
                            <div class="tab-content" id="pills-tabContent">
                              <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab"><p>Indulge in unmatched comfort, elegance, and refinement. Every detail is designed to deliver a premium travel experience — where sophistication meets seamless service, and every journey feels first class.</p></div>
                              <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab"><p>Your comfort is our promise. From start to finish, we ensure every journey feels smooth, relaxing, and effortless — whether you're traveling for business or pleasure.</p></div>
                              <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab"><p>Luxury on your schedule — easily extend your trip or modify your reservation.</p></div>
                            </div>
                            
                        </div>
                    </div>
                </div>

                <div class="image-container col-md-6 pull-right" data-bgimage="url(../images/background/5.jpg) center"></div>
            </section>

            <section id="section-call-to-action" class="bg-color-2 pt60 pb60 text-light" style="background-color: #0273AA;">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-lg-8">
                            <h2 class="s2">Call us for further information. Our customer Desk is here to help you anytime.</h2>
                        </div>

                        <div class="col-lg-4 text-lg-center text-sm-center">
                            <div class="phone-num-big">
                                <i class="fa fa-phone"></i>
                                <span class="pnb-text">
                                    Call Us Now
                                </span>
                                <span class="pnb-num">
                                +255 62 580 1496
                                </span>
                            </div>
                            <a href="#" class="btn-main">Contact Us</a>
                        </div>
                    </div>
                </div>
            </section>
			
        </div>
        <!-- content close -->

        <a href="#" id="back-to-top"></a>
        
        <!-- footer begin -->
        @include('components.client-footer')
        <!-- footer close -->
        
    </div>


    <!-- Javascript Files
    ================================================== -->
    <script src="{{ asset('js/plugins.js') }}"></script>
    <script src="{{ asset('js/designesia.js') }}"></script>

</body>

</html>