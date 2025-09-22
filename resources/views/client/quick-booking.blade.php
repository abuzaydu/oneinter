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
    <meta name="csrf-token" content="{{ csrf_token() }}">
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

<body onload="initialize()">
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
        <div class="no-bottom no-top" id="content">
            <div id="top"></div>
            
            <!-- section begin -->
            <section id="subheader" class="jarallax text-light">
                <img src="{{ asset('images/background/subheader.jpg') }}" class="jarallax-img" alt="">
                    <div class="center-y relative text-center">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-12 text-center">
									<h1>Quick Booking</h1>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
            </section>
            <!-- section close -->

            <section id="section-hero" aria-label="section" class="no-top" data-bgcolor="#121212">
                <div class="container">
                    <div class="row align-items-center">

                        <div class="col-lg-12 mt-80 sm-mt-0">
                            <div class="spacer-single sm-hide"></div>
                            <div id="booking_form_wrap" class="padding40 rounded-5 shadow-soft" data-bgcolor="#ffffff">
                                

                                <form name="contactForm" id='booking_form' class="form-s2 row g-4 on-submit-hide" method="post" action="{{ route('client.store-booking') }}">
                                    @csrf
                                    <div class="col-lg-6 d-light">
                                        <h4>Booking a Car</h4>
                                        <select name='category_id' id="vehicle_type" class="form-control @error('category_id') is-invalid @enderror">
                                            <option value="">Select a Car</option>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}" 
                                                        data-src="{{ $category->picture ? asset($category->picture) : asset('images/cars-alt/default-car.png') }}"
                                                        {{ (old('category_id', $selectedCategory) == $category->id) ? 'selected' : '' }}>
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('category_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror

                                        <div class="row g-4">
                                            <div class="col-lg-12">
                                                <h5>Car Color (Optional)</h5>
                                                <select name="color" id="car_color" class="form-control @error('color') is-invalid @enderror">
                                                    <option value="">Select Color (Optional)</option>
                                                </select>
                                                @error('color')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="col-lg-12">
                                                <h5>Pick Up Location</h5>
                                                <input type="text" name="pickup_location" id="pickup_location" 
                                                       class="form-control @error('pickup_location') is-invalid @enderror" 
                                                       value="{{ old('pickup_location') }}" required>
                                                @error('pickup_location')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="col-lg-12">
                                                <h5>Destination</h5>
                                                <select name="destination" id="destination" class="form-control @error('destination') is-invalid @enderror" required>
                                                    <option value="">Select Destination</option>
                                                    <option value="within the city" {{ old('destination') == 'within the city' ? 'selected' : '' }}>Within the City (Dar es Salaam)</option>
                                                    <option value="out of the city" {{ old('destination') == 'out of the city' ? 'selected' : '' }}>Out of the City</option>
                                                </select>
                                                @error('destination')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="col-lg-12" id="region-container" style="display: none;">
                                                <h5>Region</h5>
                                                <input type="text" name="region" id="region" class="form-control @error('region') is-invalid @enderror" value="{{ old('region') }}">
                                                @error('region')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="col-lg-6">
                                                <h5>Pick Up Date & Time</h5>
                                                <div class="row g-2">
                                                    <div class="col-8">
                                                        <input type="date" id="pickup_date" name="pickup_date" 
                                                               class="form-control @error('pickup_date') is-invalid @enderror"
                                                               value="{{ old('pickup_date') }}" 
                                                               min="{{ date('Y-m-d') }}" required>
                                                    </div>
                                                    <div class="col-4">
                                                        <select name="pickup_time" id="pickup_time" class="form-control" required>
                                                            <option value="">Time</option>
                                                            @for($hour = 0; $hour < 24; $hour++)
                                                                @for($minute = 0; $minute < 60; $minute += 30)
                                                                    @php
                                                                        $time = sprintf('%02d:%02d', $hour, $minute);
                                                                        $display_time = date('g:i A', strtotime($time));
                                                                    @endphp
                                                                    <option value="{{ $time }}" {{ old('pickup_time') == $time ? 'selected' : '' }}>
                                                                        {{ $display_time }}
                                                                    </option>
                                                                @endfor
                                                            @endfor
                                                        </select>
                                                    </div>
                                                </div>
                                                @error('pickup_date')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="col-lg-6">
                                                <h5>Return Date & Time</h5>
                                                <div class="row g-2">
                                                    <div class="col-8">
                                                        <input type="date" id="return_date" name="return_date" 
                                                               class="form-control @error('return_date') is-invalid @enderror"
                                                               value="{{ old('return_date') }}" 
                                                               min="{{ date('Y-m-d') }}" required>
                                                    </div>
                                                    <div class="col-4">
                                                        <select name="return_time" id="return_time" class="form-control" required>
                                                            <option value="">Time</option>
                                                            @for($hour = 0; $hour < 24; $hour++)
                                                                @for($minute = 0; $minute < 60; $minute += 30)
                                                                    @php
                                                                        $time = sprintf('%02d:%02d', $hour, $minute);
                                                                        $display_time = date('g:i A', strtotime($time));
                                                                    @endphp
                                                                    <option value="{{ $time }}" {{ old('return_time') == $time ? 'selected' : '' }}>
                                                                        {{ $display_time }}
                                                                    </option>
                                                                @endfor
                                                            @endfor
                                                        </select>
                                                    </div>
                                                </div>
                                                @error('return_date')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <!-- customer details -->
                                    <div class="col-lg-6">
                                        <h4>Enter Your Details</h4>
                                        <div class="row g-4">
                                            <div class="col-lg-12">
                                                <div class="field-set">
                                                    <input type="text" name="customer_name" id="customer_name" 
                                                           class="form-control @error('customer_name') is-invalid @enderror" 
                                                           placeholder="Your Name" value="{{ old('customer_name') }}" required>
                                                    @error('customer_name')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="field-set">
                                                    <input type="email" name="customer_email" id="customer_email" 
                                                           class="form-control @error('customer_email') is-invalid @enderror" 
                                                           placeholder="Your Email (Optional)" value="{{ old('customer_email') }}">
                                                    @error('customer_email')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="field-set">
                                                    <input type="text" name="customer_phone" id="customer_phone" 
                                                           class="form-control @error('customer_phone') is-invalid @enderror" 
                                                           placeholder="Your Phone" value="{{ old('customer_phone') }}" required>
                                                    @error('customer_phone')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-lg-12">
                                                <div class="field-set">
                                                    <input type="text" name="organization" id="organization" 
                                                           class="form-control @error('organization') is-invalid @enderror" 
                                                           placeholder="Organization (Optional)" value="{{ old('organization') }}">
                                                    @error('organization')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-lg-6">
                                                <div class="field-set">
                                                    <select name="id_type" id="id_type" class="form-control @error('id_type') is-invalid @enderror" required>
                                                        <option value="">Select ID Type</option>
                                                        <option value="nida" {{ old('id_type') == 'nida' ? 'selected' : '' }}>NIDA</option>
                                                        <option value="passport" {{ old('id_type') == 'passport' ? 'selected' : '' }}>Passport</option>
                                                    </select>
                                                    @error('id_type')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-lg-6">
                                                <div class="field-set">
                                                    <input type="text" name="id_number" id="id_number" 
                                                           class="form-control @error('id_number') is-invalid @enderror" 
                                                           placeholder="ID Number" value="{{ old('id_number') }}" required>
                                                    @error('id_number')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-lg-12">
                                                <div class="field-set">
                                                    <textarea name="special_requests" id="special_requests" 
                                                              class="form-control @error('special_requests') is-invalid @enderror" 
                                                              placeholder="Do you have any special requests?">{{ old('special_requests') }}</textarea>
                                                    @error('special_requests')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-12">
                                        <p id='submit'>
                                            <input type='submit' id='send_message' value='Submit Booking' class="btn-main btn-fullwidth">
                                        </p>
                                    </div>
                                </form>

                                @if(session('success'))
                                    <div class="alert alert-success mt-3">
                                        {{ session('success') }}
                                        </div>
                                @endif

                                @if(session('error'))
                                    <div class="alert alert-danger mt-3">
                                        {{ session('error') }}
                                    </div>
                                @endif
                            </div>

                            <div id="success_message" class="bg-color text-light rounded-5">
                                <div class="p-5 text-center">
                                    <h3 class="mb-2">Congratulations! Your booking has been sent successfully. We will contact you shortly.</h3>
                                    <p>Refresh this page if you want to booking again.</p>
                                    <a class="btn-main bg-dark" href="">Reload this page</a>
                                </div>
                            </div>
                        </div>
                        
                    </div>

                    <div class="spacer-double"></div>

                    <div class="row text-light">
                        <div class="col-lg-12">
                            <div class="container-timeline">
                                <ul>
                                    <li>
                                        <h4>Choose a vehicle</h4>
                                        <p>Unlock unparalleled adventures and memorable journeys with our vast fleet of vehicles tailored to suit every need, taste, and destination.</p>
                                    </li>
                                    <li>
                                        <h4>Pick location &amp; date</h4>
                                        <p>Pick your ideal location and date, and let us take you on a journey filled with convenience, flexibility, and unforgettable experiences.</p>
                                    </li>
                                    <li>
                                        <h4>Make a booking</h4>
                                        <p>Secure your reservation with ease, unlocking a world of possibilities and embarking on your next adventure with confidence.</p>
                                    </li>
                                    <li>
                                        <h4>Sit back &amp; relax</h4>
                                        <p>Hassle-free convenience as we take care of every detail, allowing you to unwind and embrace a journey filled comfort.</p>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section aria-label="section" class="pt40 pb40 text-light">
                <div class="wow fadeInRight d-flex">
                  <div class="de-marquee-list s2">
                    <div class="d-item">
                      @foreach($categories as $category)
                        <span class="d-item-txt">{{ $category->name }}</span>
                        <span class="d-item-display">
                          <i class="d-item-dot"></i>
                        </span>
                      @endforeach
                     </div>
                  </div>

                  <!-- <div class="de-marquee-list s2">
                    <div class="d-item">
                      <span class="d-item-txt">SUV</span>
                      <span class="d-item-display">
                        <i class="d-item-dot"></i>
                      </span>
                      <span class="d-item-txt">Hatchback</span>
                      <span class="d-item-display">
                        <i class="d-item-dot"></i>
                      </span>
                      <span class="d-item-txt">Crossover</span>
                      <span class="d-item-display">
                        <i class="d-item-dot"></i>
                      </span>
                      <span class="d-item-txt">Convertible</span>
                      <span class="d-item-display">
                        <i class="d-item-dot"></i>
                      </span>
                      <span class="d-item-txt">Sedan</span>
                      <span class="d-item-display">
                        <i class="d-item-dot"></i>
                      </span>
                      <span class="d-item-txt">Sports Car</span>
                      <span class="d-item-display">
                        <i class="d-item-dot"></i>
                      </span>
                      <span class="d-item-txt">Coupe</span>
                      <span class="d-item-display">
                        <i class="d-item-dot"></i>
                      </span>
                      <span class="d-item-txt">Minivan</span>
                      <span class="d-item-display">
                        <i class="d-item-dot"></i>
                      </span>
                      <span class="d-item-txt">Station Wagon</span>
                      <span class="d-item-display">
                        <i class="d-item-dot"></i>
                      </span>
                      <span class="d-item-txt">Truck</span>
                      <span class="d-item-display">
                        <i class="d-item-dot"></i>
                      </span>
                      <span class="d-item-txt">Minivans</span>
                      <span class="d-item-display">
                        <i class="d-item-dot"></i>
                      </span>
                      <span class="d-item-txt">Exotic Cars</span>
                      <span class="d-item-display">
                        <i class="d-item-dot"></i>
                      </span>
                     </div>
                  </div> -->
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
        document.addEventListener('DOMContentLoaded', function () {
            var destination = document.getElementById('destination');
            var regionContainer = document.getElementById('region-container');
            var vehicleType = document.getElementById('vehicle_type');
            var carColor = document.getElementById('car_color');
            var pickupDate = document.getElementById('pickup_date');
            var pickupTime = document.getElementById('pickup_time');
            var returnDate = document.getElementById('return_date');
            var returnTime = document.getElementById('return_time');

            function toggleRegion() {
                if (destination.value === 'out of the city') {
                    regionContainer.style.display = 'block';
                } else {
                    regionContainer.style.display = 'none';
                }
            }

            function loadAvailableColors() {
                var categoryId = vehicleType.value;
                
                if (!categoryId) {
                    carColor.innerHTML = '<option value="">Select Color (Optional)</option>';
                    return;
                }

                carColor.innerHTML = '<option value="">Loading colors...</option>';
                carColor.disabled = true;

                fetch('/client/get-available-colors?category_id=' + categoryId)
                    .then(response => response.json())
                    .then(data => {
                        carColor.innerHTML = '<option value="">Select Color (Optional)</option>';
                        
                        if (data.colors && data.colors.length > 0) {
                            data.colors.forEach(color => {
                                var option = document.createElement('option');
                                option.value = color;
                                option.textContent = color;
                                carColor.appendChild(option);
                            });
                        } else {
                            var option = document.createElement('option');
                            option.value = '';
                            option.textContent = 'No specific colors available';
                            carColor.appendChild(option);
                        }
                        
                        carColor.disabled = false;
                    })
                    .catch(error => {
                        console.error('Error loading colors:', error);
                        carColor.innerHTML = '<option value="">Error loading colors</option>';
                        carColor.disabled = false;
                    });
            }

            // Set minimum return date based on pickup date
            function updateReturnDateMin() {
                if (pickupDate.value) {
                    returnDate.min = pickupDate.value;
                    // If return date is before pickup date, reset it
                    if (returnDate.value && returnDate.value < pickupDate.value) {
                        returnDate.value = pickupDate.value;
                    }
                }
            }

            // Set minimum return time based on pickup date and time
            function updateReturnTimeMin() {
                if (pickupDate.value && returnDate.value && pickupTime.value) {
                    if (pickupDate.value === returnDate.value) {
                        // Same day - return time must be after pickup time
                        var pickupDateTime = new Date(pickupDate.value + 'T' + pickupTime.value);
                        var returnDateTime = new Date(returnDate.value + 'T' + returnTime.value);
                        
                        if (returnDateTime <= pickupDateTime) {
                            returnTime.value = '';
                        }
                    }
                }
            }

            destination.addEventListener('change', toggleRegion);
            pickupDate.addEventListener('change', updateReturnDateMin);
            pickupTime.addEventListener('change', updateReturnTimeMin);
            returnDate.addEventListener('change', updateReturnTimeMin);
            
            // Simple polling approach to detect changes
            var lastValue = vehicleType.value;
            setInterval(function() {
                if (vehicleType.value !== lastValue) {
                    lastValue = vehicleType.value;
                    loadAvailableColors();
                }
            }, 100);
            
            // Direct change event listener (backup)
            vehicleType.addEventListener('change', function() {
                loadAvailableColors();
            });
            
            // Initialize
            toggleRegion();
            if (vehicleType.value) {
                // Trigger color loading immediately for pre-selected category
                setTimeout(function() {
                    loadAvailableColors();
                }, 100);
            }
        });
    </script>

</body>

</html>