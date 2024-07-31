<!DOCTYPE html>
<html lang="en" dir="ltr" data-nav-layout="vertical" data-theme-mode="light" data-header-styles="light" data-menu-styles="light" data-toggled="close">

<head>

    <!-- Meta Data -->
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title> Sash – Bootstrap 5  Admin &amp; Dashboard Template </title>
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
                        <a href="{{ route('login') }}">
                            <img src="{{ asset('logo/Bank.png') }}" alt="logo">
                        </a>
                    </div>
                    <form action="{{ route('password.update') }}" method="POST">
                        @csrf
                        <div class="card custom-card">
                            <div class="card-body p-5">
                                <p class="h5 fw-semibold mb-2 text-center">Reset Password</p>
                                <p class="mb-4 text-muted op-7 fw-normal text-center">{{ $name }}</p>
                                <div class="row gy-3">
                                    <div class="col-xl-12">
                                        <input type="hidden" name="token" value="{{ $token }}">
                                        <input type="hidden" name="email" value="{{ $email }}">
                                        <label for="reset-newpassword" class="form-label text-default">New Password</label>
                                        <div class="input-group">
                                            <input type="password" class="form-control form-control-lg" id="reset-newpassword" name="password" placeholder="New password" value="{{ old('password') }}" required>
                                            <button aria-label="Toggle password visibility" class="btn btn-light" type="button" onclick="togglePassword('reset-newpassword', this)" id="button-addon21"><i class="ri-eye-off-line align-middle"></i></button>
                                        </div>                                        
                                    </div>
                                    <div class="col-xl-12 mb-2">
                                        <label for="reset-confirmpassword" class="form-label text-default">Confirm Password</label>
                                        <div class="input-group">
                                            <input type="password" class="form-control form-control-lg" id="reset-confirmpassword" name="password_confirmation" placeholder="Confirm password" value="{{ old('password_confirmation') }}" required>
                                            <button aria-label="Toggle password visibility" class="btn btn-light" type="button" onclick="togglePassword('reset-confirmpassword', this)" id="button-addon22"><i class="ri-eye-off-line align-middle"></i></button>
                                        </div>                                        
                                    </div>
                                    <div class="col-xl-12 d-grid mt-2">
                                        <button type="submit" class="btn btn-lg btn-primary">Reset Password</button>
                                    </div>
                                </div>
                                <div class="text-center">
                                    <p class="text-muted mt-3">Already have an account? <a href="{{ route('login') }}" class="text-primary">Sign In</a></p>
                                </div>
                            </div>
                        </div>
                    </form>                    
                </div>
            </div>
        </div>
    </div>


    {{-- <!-- Custom-Switcher JS -->
    <script src="../assets/js/custom-switcher.min.js"></script> --}}

    <!-- Bootstrap JS -->
    <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    {{-- <!-- Show Password JS -->
    <script src="../assets/js/show-password.js"></script> --}}

    <script>
        function togglePassword(inputId, button) {
        var input = document.getElementById(inputId);
        if (input.type === "password") {
            input.type = "text";
            button.innerHTML = '<i class="ri-eye-line align-middle"></i>';
        } else {
            input.type = "password";
            button.innerHTML = '<i class="ri-eye-off-line align-middle"></i>';
        }
    }
    </script>

</body>

</html>