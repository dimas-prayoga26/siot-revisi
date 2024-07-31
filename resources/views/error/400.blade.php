<!DOCTYPE html>
<html lang="en" dir="ltr" data-nav-layout="vertical" data-theme-mode="light" data-header-styles="light" data-menu-styles="light" data-toggled="close">

<head>

    <!-- Meta Data -->
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Login</title>
    <meta name="Description" content="Bootstrap Responsive Admin Web Dashboard HTML5 Template">
    <meta name="Author" content="Spruko Technologies Private Limited">
	<meta name="keywords" content="admin dashboard,dashboard design htmlbootstrap admin template,html admin panel,admin dashboard html,admin panel html template,bootstrap dashboard,html admin template,html dashboard,html admin dashboard template,bootstrap dashboard template,dashboard html template,bootstrap admin panel,dashboard admin bootstrap,bootstrap admin dashboard">

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('assets/images/brand-logos/favicon.ico') }}" type="image/x-icon">

    <!-- Main Theme Js -->
    <script src="{{ asset('assets/js/authentication-main.js') }}"></script>

    <!-- Bootstrap Css -->
    <link id="style" href="{{ asset('assets/libs/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" >

    <!-- Style Css -->
    <link href="{{ asset('assets/css/styles.min.css') }}" rel="stylesheet" >

    <!-- Icons Css -->
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" >


</head>

<body class="bg-white">

    @include('layout.loader')

    <div class="row authentication coming-soon mx-0 justify-content-center">

        <div class="col-xxl-8 col-xl-8 col-lg-8 col-12">
            <div class="authentication-cover text-fixed-white">
                <div class="aunthentication-cover-content text-center py-5 px-sm-5 px-0">
                    <div class="row justify-content-center align-items-center h-100">
                        <div class="col-xxl-6 col-xl-8 col-lg-8 col-md-12 col-sm-12 col-12">
                            <h1 class="display-1 text-fixed-white">4<span class="text-center custom-emoji"><svg xmlns="http://www.w3.org/2000/svg" height="140" width="140" enable-background="new 0 0 24 24" viewBox="0 0 24 24">
                                        <path fill="#c4bffd" d="M9,21.48047c-0.55214,0.00014-0.99986-0.44734-1-0.99948c0-0.00017,0-0.00035,0-0.00052V10c0-0.55229,0.44771-1,1-1s1,0.44771,1,1v10.48047c0.00014,0.55214-0.44734,0.99986-0.99948,1C9.00035,21.48047,9.00017,21.48047,9,21.48047z M15,21.48047c-0.55214,0.00014-0.99986-0.44734-1-0.99948c0-0.00017,0-0.00035,0-0.00052V10c0-0.55229,0.44771-1,1-1s1,0.44771,1,1v10.48047c0.00014,0.55214-0.44734,0.99986-0.99948,1C15.00035,21.48047,15.00017,21.48047,15,21.48047z"/>
                                        <path fill="#a69ffd" d="M15.40137,21.39392C19.24707,20.00067,22,16.32666,22,12c0-5.52283-4.47717-10-10-10S2,6.47717,2,12c0,4.32678,2.75323,8.00085,6.59912,9.39404C8.24725,21.23926,8.00006,20.89001,8,20.48102c0-0.00018,0-0.00037,0-0.00055V10c0-0.55231,0.44769-1,1-1s1,0.44769,1,1v10.48047c0.00012,0.55212-0.44733,0.99988-0.99945,1c-0.00018,0-0.00037,0-0.00055,0c-0.13025,0-0.25305-0.02875-0.36719-0.07404C9.6864,21.78375,10.81665,22,12,22c1.18353,0,2.3139-0.21631,3.36761-0.59375c-0.11407,0.04535-0.23688,0.07422-0.36707,0.07422c-0.00018,0-0.00037,0-0.00055,0c-0.55212,0.00012-0.99988-0.44733-1-0.99945c0-0.00018,0-0.00037,0-0.00055V10c0-0.55231,0.44769-1,1-1s1,0.44769,1,1v10.48047C16.00006,20.88947,15.75311,21.23901,15.40137,21.39392z"/>
                                        <rect width="4" height="2" x="10" y="14" fill="#6c5ffc"/>
                                        <path fill="#6c5ffc" d="M16,11h-2c-0.55229,0-1-0.44771-1-1s0.44771-1,1-1h2c0.55228,0,1,0.44771,1,1S16.55228,11,16,11z M10,11H8c-0.55228,0-1-0.44771-1-1s0.44772-1,1-1h2c0.55229,0,1,0.44771,1,1S10.55229,11,10,11z"/>
                                    </svg></span>0
                            </h1>
                            <div class="m-4">
                                <span class="fs-20 fw-semibold">
                                        OOPS! Page not found
                                </span>
                                <p class="fs-16">Sorry, an error has occured, Requested page not found!</p>
                            </div>
                            <div class="text-center">
                                <a class="btn btn-secondary d-inline-flex gap-1" href="{{ route('login') }}"> <i class="ri-arrow-left-line my-auto "></i> Back to Home </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

<!-- Bootstrap JS -->
<script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

</body>

</html>