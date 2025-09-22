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
									<h1>Our Fleet</h1>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
            </section>
            <!-- section close -->

            <section id="section-cars">
                <div class="container">
                    <div class="row">
                        <!-- <div class="col-lg-3">
                            <div class="item_filter_group">
                                <h4>Vehicle Category</h4>
                                <div class="de_form">
                                    @foreach($categories as $category)
                                    <div class="de_checkbox">
                                        <input id="category_{{ $category->id }}" 
                                               name="category_filter" 
                                               type="checkbox" 
                                               value="{{ $category->id }}"
                                               class="category-filter">
                                        <label for="category_{{ $category->id }}">{{ $category->name }}</label>
                                    </div>
                                    @endforeach
                                  </div>
                            </div>
                        </div> -->

                        <div>
                            <div class="row" id="cars-container">
                                @forelse($categories as $category)
                                <div class="col-xl-4 col-lg-6 car-item" data-category="{{ $category->id }}">
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
                                                @if($category->description)
                                                <div class="d-description">
                                                    <p>{{ Str::limit($category->description, 100) }}</p>
                                                </div>
                                                @endif
                                                <div class="d-price">
                                                    @if($category->daily_rate)
                                                    Daily rate from <span>Tsh {{ number_format($category->daily_rate) }}</span>
                                                    @else
                                                    <span>Price on request</span>
                                                    @endif
                                                    <a class="btn-main" href="{{ route('client.quick-booking', ['category' => $category->id]) }}">Rent Now</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @empty
                                <div class="col-12">
                                    <div class="alert alert-info">
                                        No car categories available at the moment. Please check back later.
                                    </div>
                                </div>
                                @endforelse
                            </div>
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
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const categoryFilters = document.querySelectorAll('.category-filter');
            const carItems = document.querySelectorAll('.car-item');
            
            function filterCars() {
                const selectedCategories = Array.from(categoryFilters)
                    .filter(checkbox => checkbox.checked)
                    .map(checkbox => checkbox.value);
                
                carItems.forEach(car => {
                    if (selectedCategories.length === 0 || selectedCategories.includes(car.dataset.category)) {
                        car.style.display = '';
                    } else {
                        car.style.display = 'none';
                    }
                });
            }
            
            categoryFilters.forEach(filter => {
                filter.addEventListener('change', filterCars);
            });
        });
    </script>
</body>

</html>