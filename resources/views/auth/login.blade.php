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

<body>
    <!-- Loader -->
    <div id="loader" >
        <img src="{{ asset('assets/images/media/loader.svg') }}" alt="">
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
                    <form action="{{ route('procces.login') }}" method="post">
                        @csrf
                        <div class="card custom-card">
                            <div class="card-body p-5">
                                <p class="h5 fw-semibold mb-2 text-center">Sign In</p>
                                <div class="row gy-3">
                                    <div class="col-xl-12">
                                        <label for="signin-username" class="form-label text-default">Email</label>
                                        <input type="text" class="form-control form-control-lg" id="signin-username" name="email" placeholder="Email" required>
                                    </div>
                                    <div class="col-xl-12 mb-2">
                                        <label for="signin-password" class="form-label text-default d-block">Password<a href="{{ route('forgot-password') }}" class="float-end text-danger">Forget password ?</a></label>
                                        <div class="input-group">
                                            <input type="password" class="form-control form-control-lg" id="signin-password" name="password" placeholder="password" required>
                                            <button class="btn btn-light" type="button" onclick="togglePasswordVisibility()" id="button-addon2">
                                                <i id="eye-icon" class="ri-eye-off-line align-middle"></i>
                                            </button>
                                        </div>
                                        {{-- <div class="mt-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                                                <label class="form-check-label text-muted fw-normal" for="defaultCheck1">
                                                    Remember password ?
                                                </label>
                                            </div>
                                        </div> --}}
                                    </div>
                                    <div class="col-xl-12 d-grid mt-2">
                                        <button class="btn btn-lg btn-primary">Sign In</button>
                                        {{-- <a href="index.html" class=""></a> --}}
                                    </div>
                                </div>
                                {{-- <div class="text-center my-3 authentication-barrier">
                                    <span>OR</span>
                                </div>
                                <div class="btn-list text-center">
                                    <button type="button" aria-label="button" class="btn btn-icon btn-primary-transparent">
                                        <i class="ri-google-fill"></i>
                                    </button>
                                </div> --}}
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


     <!-- Custom-Switcher JS -->
    {{-- <script src="{{ asset('assets/js/custom-switcher.min.js') }}"></script> --}}
        <!-- JQUERY JS -->
    <script src="https://code.jquery.com/jquery-3.7.1.slim.js" integrity="sha256-UgvvN8vBkgO0luPSUl2s8TIlOSYRoGFAX4jlCIm9Adc=" crossorigin="anonymous"></script>
    <!-- Bootstrap JS -->
    <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- <!-- Show Password JS -->
    <script src="{{ asset('') }}../assets/js/show-password.js"></script> --}}

    <script>
        $(document).ready(function () {
            let type = false;
            if('{{session()->has("success")}}' == true) type = "success";
            if('{{session()->has("error")}}' == true) type = "error";

            if(type === "success"){
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: '{{ session('success') }}'
                });

            }else if(type === "error") {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: '{{ session('error') }}'
                });
            }
        });

        function togglePasswordVisibility() {
        var passwordInput = document.getElementById('signin-password');
        var eyeIcon = document.getElementById('eye-icon');

        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            eyeIcon.className = 'ri-eye-line align-middle';
        } else {
            passwordInput.type = 'password';
            eyeIcon.className = 'ri-eye-off-line align-middle';
        }
    }
    </script>

</body>

</html>