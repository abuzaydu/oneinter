<!DOCTYPE html>
<html lang="en">

<head>
    <title>@yield('title', 'One-Inter Travel Limited')</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="Dasho Bootstrap admin template made using bootstrap 5 and it has huge amount of ready made feature, UI components, pages which completely fulfills any dashboard needs." />
    <meta name="keywords" content="admin templates, bootstrap admin templates, bootstrap 5, dashboard, dashboard templets, sass admin templets, html admin templates, responsive, bootstrap admin templates free download,premium bootstrap admin templates, Elite Able, Dasho bootstrap admin template">
    <meta name="author" content="Phoenixcoded" />
    <link rel="icon" href="{{ asset('assets/images/favicon.svg') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('assets/fonts/fontawesome/css/fontawesome-all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/animation/css/animate.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/prism/css/prism.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/notification/css/notification.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    @stack('styles')
</head>

<body>
    <!-- [ Pre-loader ] start -->
    <div class="loader-bg">
        <div class="loader-track">
            <div class="loader-fill"></div>
        </div>
    </div>
    <!-- [ Pre-loader ] End -->
    @include('admin.partials.sidebar')
    @include('admin.partials.header')
    <div class="pcoded-main-container">
        <div class="pcoded-wrapper">
            <div class="pcoded-content">
                <div class="pcoded-inner-content">
                    <div class="main-body">
                        <div class="page-wrapper">
                            @yield('content')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('admin.partials.footer')
    @stack('scripts')
</body>

</html>