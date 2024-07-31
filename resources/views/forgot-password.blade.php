<!DOCTYPE html>
<html lang="en" dir="ltr" data-nav-layout="vertical" data-theme-mode="light" data-header-styles="light" data-menu-styles="light" data-toggled="close">

<head>

    <!-- Meta Data -->
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title> Forgot Password </title>
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

<body>

    <!-- Loader -->
    <div id="loader" >
        <img src="../assets/images/media/loader.svg" alt="">
    </div>
    <!-- Loader -->

    <div class="autentication-bg">

        <div class="container-lg">
            <div class="row justify-content-center authentication authentication-basic align-items-center h-100">
                <div class="col-xxl-4 col-xl-5 col-lg-5 col-md-6 col-sm-8 col-12">
                    <div class="my-4 d-flex justify-content-center">
                        <a href="index.html">
                            <img src="../assets/images/brand-logos/desktop-white.png" alt="logo">
                        </a>
                    </div>
                    <div class="card custom-card">
                        <div class="card-body p-5">
                            <p class="h5 fw-semibold mb-2 text-center">Forgot Password</p>
                            <div class="row gy-3">
                                <div class="col-xl-12">
                                    <label for="reset-password" class="form-label text-default">Email</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control form-control-lg" id="reset-password" placeholder="Email">
                                    </div>
                                </div>
                                <div class="col-xl-12 d-grid mt-2">
                                    <a href="#" class="btn btn-lg btn-primary">Submit</a>
                                </div>
                            </div>
                            <div class="text-center">
                                <p class="text-muted mt-3">Back to home ? <a href="index.html" class="text-primary">Click Here</a></p>
                            </div>
                            {{-- <div class="text-center my-3 authentication-barrier">
                                <span>OR</span>
                            </div>
                            <div class="btn-list text-center">
                                <button type="button" aria-label="button" class="btn btn-icon btn-primary-transparent">
                                    <i class="ri-facebook-fill"></i>
                                </button>
                                <button type="button" aria-label="button" class="btn btn-icon btn-primary-transparent">
                                    <i class="ri-google-fill"></i>
                                </button>
                                <button type="button" aria-label="button" class="btn btn-icon btn-primary-transparent">
                                    <i class="ri-twitter-fill"></i>
                                </button>
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    {{-- <!-- Custom-Switcher JS -->
    <script src="{{ asset('assets/js/custom-switcher.min.js') }}"></script> --}}

    <!-- Bootstrap JS -->
    <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Show Password JS -->
    <script src="{{ asset('assets/js/show-password.js') }}"></script>

</body>

</html>