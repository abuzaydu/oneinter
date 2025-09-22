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
    <style>
    .car-item {
        display: flex;
        flex-direction: column;
        height: 100%;
    }

    .de-item {
        display: flex;
        flex-direction: column;
        height: 100%;
    }

    .de-item .d-info {
        flex-grow: 1;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .de-item .d-img img {
        height: 200px;
        width: 100%;
        object-fit: cover;
    }
    </style>
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
                            <a href=""><i class="fa fa-facebook fa-lg"></i></a>
                            <a href=""><i class="fa fa-twitter fa-lg"></i></a>
                            <a href=""><i class="fa fa-instagram fa-lg"></i></a>
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
        <div class="no-bottom no-top" id="content">
            <div id="top"></div>
            <section id="section-hero" aria-label="section" class="jarallax text-light">
                <img src="{{ asset('images/background/16.png') }}" class="jarallax-img" alt="">
                <div class="spacer-single sm-hide"></div>
                 <div class="spacer-double sm-hide"></div>
                <div class="container">
                    <div class="row">

                        <div class="col-lg-6">
                            <div class="de-images">
                                    <img class="di-small-2" src="{{ asset('images/misc/9853.jpg') }}" alt="">
                                    <img class="di-big img-fluid" src="{{ asset('images/misc/a-5.png') }}" alt="">
                                </div>
                        </div>

                        <div class="col-lg-5 offset-lg-1">
                            <!-- <h5>We Are ......</h5> -->
                            <div class="spacer-10"></div>
                            <h2>Car Rental Made Easy with <span class="id-color">One Inter Travel LTD</span></h2>
                            <!-- <h1>We are the <span class="id-color">leading</span> commercial and luxury cars rental in Tanzania</h1> -->
                            <p class="lead">We offer affordable and reliable car rentals with professional drivers for personal, group, and business trips across Dar es Salaam and other regions in Tanzania.</p>
                            <a class="btn-main" href="{{ route('client.cars') }}">Choose a Car</a>
                            <div class="spacer-single"></div>

                            <div class="row">
                                <div class="col-lg-4 wow fadeInRight mb30" data-wow-delay="1.1s">
                                    <div class="de_count transparent text-left">
                                        <h3><span>150</span>+</h3>
                                        <h5 class="id-color">Cars<br>Available</h5>
                                    </div>
                                </div>

                                <div class="col-lg-4 wow fadeInRight mb30" data-wow-delay="1.4s">
                                    <div class="de_count transparent text-left">
                                        <h3><span>48</span>k</h3>
                                        <h5 class="id-color">Happy<br>Customers</h5>
                                    </div>
                                </div>

                                <div class="col-lg-4 wow fadeInRight mb30" data-wow-delay="1.7s">
                                    <div class="de_count transparent text-left">
                                        <h3><span>15</span></h3>
                                        <h5 class="id-color">Year<br>Experiences</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </section>

            <section id="section-cars">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-lg-6 offset-lg-3 text-center">
                            <h2>Our Vehicle Fleet</h2>
                            <p>Turning your travel plans into reality with reliable, comfortable vehicles for unforgettable journeys across Tanzania</p>
                            <div class="spacer-20"></div>
                        </div>

                        <div id="items-carousel" class="owl-carousel wow fadeIn">

                            @forelse($favoriteCategories ?? [] as $category)
                            <div class="col-lg-12 car-item">
                                <div class="de-item mb30">
                                    <div class="d-img">
                                        <img src="{{ $category->picture ? asset($category->picture) : asset('images/cars-alt/default-car.png') }}" class="img-fluid" alt="{{ $category->name }}">
                                    </div>
                                    <div class="d-info">
                                                                                    <div class="d-text">
                                                <h4>{{ $category->name }}</h4>
                                                <div class="d-item_like">
                                                    <!-- <i class="fa fa-heart"></i><span>{{ rand(20, 100) }}</span> -->
                                        </div>
                                        <div class="d-atr-group">
                                                    @if($category->seats)
                                                    <!-- <span class="d-atr"><img src="{{ asset('images/icons/1-green.svg') }}" alt="">{{ $category->seats }} Seats</span> -->
                                                    @endif
                                                    <!-- <span class="d-atr"><img src="{{ asset('images/icons/3-green.svg') }}" alt="">4 Doors</span> -->
                                                    <!-- <span class="d-atr"><img src="{{ asset('images/icons/4-green.svg') }}" alt="">{{ $category->name }}</span> -->
                                                </div>
                                                <hr class="my-3">
                                                <div class="d-price">
                                                    <a class="btn-main w-100" href="{{ route('client.quick-booking', ['category' => $category->id]) }}">Rent Now</a>
                                                </div>
                                            </div>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <div class="col-lg-12">
                                <!-- <div class="de-item mb30">
                                    <div class="d-img">
                                        <img src="{{ asset('images/cars/jeep-renegade.jpg') }}" class="img-fluid" alt="">
                                    </div>
                                    <div class="d-info">
                                        <div class="d-text">
                                            <h4>Jeep Renegade</h4>
                                            <div class="d-item_like">
                                                <i class="fa fa-heart"></i><span>74</span>
                                            </div>
                                            <div class="d-atr-group">
                                                <span class="d-atr"><img src="images/icons/1-green.svg" alt="">5</span>
                                                <span class="d-atr"><img src="images/icons/2-green.svg" alt="">2</span>
                                                <span class="d-atr"><img src="images/icons/3-green.svg" alt="">4</span>
                                                <span class="d-atr"><img src="images/icons/4-green.svg" alt="">SUV</span>
                                            </div>
                                            <div class="d-price">
                                                Daily rate from <span>$265</span>
                                                <a class="btn-main" href="{{ route('client.quick-booking') }}">Rent Now</a>
                                            </div>
                                        </div>
                                    </div>
                                </div> -->
                            </div>
                            @endforelse

                        </div>

                    </div>
                </div>
                <div class="container">
                    <a class="btn-main" href="{{ route('client.cars') }}">See More</a>

                </div>

            </section>

            <!-- <section id="section-testimonials" class="no-top no-bottom">
                <div class="container-fluid">
                    <div class="row g-2 p-2 align-items-center">

                        <div class="col-md-4">
                            <div class="de-image-text">
                                <div class="d-text">
                                    <div class="d-quote id-color"><i class="fa fa-quote-right"></i></div>
                                    <h4>Excellent Service! Car Rent Service!</h4>
                                    <blockquote>
                                       I have been using Rentaly for my Car Rental needs for over 5 years now. I have never had any problems with their service. Their customer support is always responsive and helpful. I would recommend Rentaly to anyone looking for a reliable Car Rental provider.
                                       <span class="by">Stepanie Hutchkiss</span>
                                   </blockquote>
                                </div> 
                                <img src="images/testimonial/1.jpg" class="img-fluid" alt="">
                            </div>
                        </div>


                        <div class="col-md-4">
                            <div class="de-image-text">
                                <div class="d-text">
                                    <div class="d-quote id-color"><i class="fa fa-quote-right"></i></div>
                                    <h4>Excellent Service! Car Rent Service!</h4>
                                    <blockquote>
                                       We have been using Rentaly for our trips needs for several years now and have always been happy with their service. Their customer support is Excellent Service! and they are always available to help with any issues we have. Their prices are also very competitive.
                                       <span class="by">Jovan Reels</span>
                                   </blockquote>
                                </div>
                                <img src="images/testimonial/2.jpg" class="img-fluid" alt="">
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="de-image-text">
                                <div class="d-text">
                                    <div class="d-quote id-color"><i class="fa fa-quote-right"></i></div>
                                    <h4>Excellent Service! Car Rent Service!</h4>
                                    <blockquote>
                                       Endorsed by industry experts, Rentaly is the Car Rental solution you can trust. With years of experience in the field, we provide fast, reliable and secure Car Rental services.
                                       <span class="by">Kanesha Keyton</span>
                                   </blockquote>
                                </div>
                                <img src="images/testimonial/3.jpg" class="img-fluid" alt="">
                            </div>
                        </div>

                    </div>
                </div>
            </section> -->

            <section>
                <div class="container">
                    <div class="row">
                    <div class="col-lg-3">
                        <h2>Perform your duties with most comfortable cars</h2>
                        <div class="spacer-20"></div>
                    </div>
                    <div class="col-md-3">
                        <i class="fa bg-color fa-id-badge de-icon mb20"></i>
                        <div class="d-inner">
                            <h4>Professional Driver Services</h4>
                            <p>Enjoy a premium experience with our well-trained drivers, ensuring comfort, safety, and reliability every time you ride with us.</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <i class="fa bg-color fa-calendar de-icon mb20"></i>
                        <div class="d-inner">
                            <h4>Flexible Booking Options</h4>
                            <p>Book your ride when you need it — whether it’s a few hours, a full day, or long-term. We adapt to your schedule with ease and convenience.</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <i class="fa bg-color fa-dollar de-icon mb20"></i>
                        <div class="d-inner">
                            <h4>Premium Quality at Affordable Rates</h4>
                            <p>Ride in well-maintained, high-quality vehicles at prices that suit your budget — perfect balance between value and comfort.</p>
                    </div>
                    <!-- <div class="col-md-3">
                        <i class="fa fa-user-tie de-icon mb20"></i>
                        <h4>Professional Drivers Included</h4>
                        <p>All our rentals come with experienced, licensed drivers from our company, ensuring safe and comfortable journeys.</p>
                    </div> -->
                </div>
                </div>
            </section>

            <section id="section-img-with-tab" data-bgcolor="#f8f8f8">
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

                <div class="image-container col-md-6 pull-right" data-bgimage="url(images/background/5.jpg) center"></div>
            </section>

          

            <section id="section-call-to-action" class="bg-color text-light">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-8 offset-lg-2 text-center">
                            <h2>Call us for further information. Our customer Desk is here to help you anytime.</h2>
                            <div class="spacer-20"></div>
                            <a href="{{ route('client.contact') }}" class="btn-main btn-line">Contact Us</a>
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