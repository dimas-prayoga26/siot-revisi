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
                            <h1 class="display-1 text-fixed-white">5<span class="text-center custom-emoji"><svg xmlns="http://www.w3.org/2000/svg" height="140" width="140" data-name="Layer 1" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10" fill="#a2a1ff"></circle><circle cx="15" cy="10" r="1" fill="#6563ff"></circle><circle cx="9" cy="10" r="1" fill="#6563ff"></circle><path fill="#6563ff" d="M11.499,17.05957a1,1,0,0,1-.87109-1.48926A5.02491,5.02491,0,0,1,15,13a1,1,0,0,1,0,2,3.02357,3.02357,0,0,0-2.62793,1.54883A.99968.99968,0,0,1,11.499,17.05957Z"></path></svg></span>0
                            </h1>
                            <div class="m-4">
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