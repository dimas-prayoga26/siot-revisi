<!DOCTYPE html>
<html lang="en">
    <head>

        <!-- Meta Data -->
        <meta charset="UTF-8">
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title> Sash – Bootstrap 5  Admin &amp; Dashboard Template </title>
        <meta name="Description" content="Bootstrap Responsive Admin Web Dashboard HTML5 Template">
        <meta name="Author" content="Spruko Technologies Private Limited">
        <meta name="keywords" content="admin dashboard,dashboard design htmlbootstrap admin template,html admin panel,admin dashboard html,admin panel html template,bootstrap dashboard,html admin template,html dashboard,html admin dashboard template,bootstrap dashboard template,dashboard html template,bootstrap admin panel,dashboard admin bootstrap,bootstrap admin dashboard">
        <meta name="csrf-token" content="{{ csrf_token() }}">
    
        <!-- Favicon -->
        <link rel="icon" href="{{ asset('logo/Bank.png') }}" type="image/x-icon">


    
        <!-- Choices JS -->
        <script src="{{ asset('assets/libs/choices.js/public/assets/scripts/choices.min.js') }}"></script>
    
        <!-- Main Theme Js -->
        <script src="{{ asset('assets/js/main.js') }}"></script>
    
        <!-- Bootstrap Css -->
        <link id="style" href="{{ asset('assets/libs/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" >
    
        <!-- Style Css -->
        <link href="{{ asset('assets/css/styles.min.css') }}" rel="stylesheet" >
    
        <!-- Icons Css -->
        <link href="{{ asset('assets/css/icons.css') }}" rel="stylesheet" >
    
        <!-- Node Waves Css -->
        <link href="{{ asset('assets/libs/node-waves/waves.min.css') }}" rel="stylesheet" >
    
        <!-- Simplebar Css -->
        <link href="{{ asset('assets/libs/simplebar/simplebar.min.css') }}" rel="stylesheet" >
    
        <!-- Color Picker Css -->
        <link rel="stylesheet" href="{{ asset('assets/libs/flatpickr/flatpickr.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/libs/@simonwep/pickr/themes/nano.min.css') }}">
    
        <!-- Choices Css -->
        <link rel="stylesheet" href="{{ asset('assets/libs/choices.js/public/assets/styles/choices.min.css') }}">
    
        <!-- Jsvector Css -->
        <link rel="stylesheet" href="{{ asset('assets/libs/jsvectormap/css/jsvectormap.min.css') }}">
        
        <!-- Swiper Css -->
        <link rel="stylesheet" href="{{ asset('assets/libs/swiper/swiper-bundle.min.css') }}">
        
        <!-- Grid Css -->
        <link rel="stylesheet" href="{{ asset('assets/libs/gridjs/theme/mermaid.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/libs/apexcharts/apexcharts.css') }}">

        <style>
            .slide-menu {
            display: none; /* Menyembunyikan submenu secara default */
        }

        .slide-menu.show {
            display: block; /* Menampilkan submenu ketika memiliki kelas 'show' */
        }

        </style>

        
    <!-- Node Waves Css -->
    <link href="{{ asset('assets/libs/node-waves/waves.min.css') }}" rel="stylesheet" />
    @yield('css')
    </head>
    <body>
        
        @include('layout.loader')
        {{-- @dd(Session()->all()); --}}


        <!-- page -->
        <div class="page">
            <!-- app-header -->
            <header class="app-header">
                <!-- main-header -->
                @include('layout.navbar')
                <!-- /main-header -->
            </header>
            <!-- /app-header -->

            <!-- main-sidebar -->
            @include('layout.sidebar')
            <!-- main-sidebar -->

            <!-- main-content -->
            <div class="main-content app-content">
                <!-- container -->
                <div class="container-fluid">

                    <!-- breadcrumb -->
                    @yield('breadcumb')
                    <!-- /breadcrumb -->

                    <!-- row -->
                    @yield('content')
                    <!-- row closed -->
                </div>
                <!-- Container closed -->
            </div>
            <!-- main-content closed -->

            <!-- Footer open -->
            @include('layout.footer')
            <!-- Footer closed -->

        </div>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <!-- Popper JS -->
        <script src="{{ asset('assets/libs/@popperjs/core/umd/popper.min.js') }}"></script>
        
        <!-- Bootstrap JS -->
        <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        
        <!-- Defaultmenu JS -->
        <script src="{{ asset('assets/js/defaultmenu.min.js') }}"></script>
        
        <!-- Node Waves JS-->
        <script src="{{ asset('assets/libs/node-waves/waves.min.js') }}"></script>
        
        <!-- Sticky JS -->
        <script src="{{ asset('assets/js/sticky.js') }}"></script>
        
        <!-- Simplebar JS -->
        <script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
        <script src="{{ asset('assets/js/simplebar.js') }}"></script>
        
        <!-- Color Picker JS -->
        <script src="{{ asset('assets/libs/@simonwep/pickr/pickr.es5.min.js') }}"></script>
        
        <!-- JSVector Maps JS -->
        <script src="{{ asset('assets/libs/jsvectormap/js/jsvectormap.min.js') }}"></script>
        
        <!-- JSVector Maps MapsJS -->
        <script src="{{ asset('assets/libs/jsvectormap/maps/world-merc.js') }}"></script>
        
        <!-- Apex Charts JS -->
        <script src="{{ asset('assets/libs/apexcharts/apexcharts.min.js') }}"></script>

       
    
        <!-- Chartjs Chart JS -->
        <script src="{{ asset('assets/libs/chart.js/chart.min.js') }}"></script>
        
        <!-- index -->
        {{-- <script src="{{ asset('assets/js/index.js') }}"></script> --}}
        
        
        <!-- Custom-Switcher JS -->
        {{-- <script src="{{ asset('assets/js/custom-switcher.min.js') }}"></script> --}}
        
        <!-- Custom JS -->
        {{-- <script src="{{ asset('assets/js/custom.js') }}"></script> --}}
        
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        @if(Session::has('success'))
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    let successMessage = "{{ Session::get('success') }}";

                    if (successMessage) {
                        Swal.fire({
                            title: 'Sukses!',
                            text: successMessage,
                            icon: 'success',
                            showConfirmButton: false,
                            timer: 1000,
                        });
                    }
                });
            </script>
        @endif

        <script>
            
            
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            
            let type = false;
            
            if('{{session()->has("success")}}' == true) type = "success";
            if('{{session()->has("error")}}' == true) type = "error";
            
            if(type === "success"){
                Swal.fire({
                    icon: 'success',
                    title: 'success!',
                    text: '{{ session('success') }}'
                });
                
            }else if(type === "error") {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: '{{ session('error') }}'
                });
            }
            
            function toast(message) {
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'error',
                    title: 'ERROR !',
                    text: message,
                    showConfirmButton: false,
                    timer: 2000
                });
            }
            
            function confirmLogout() {
                Swal.fire({
                    title: 'Logout',
                    text: 'Apakah Anda yakin ingin logout?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Logout!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Redirect ke route logout jika pengguna menekan tombol "Ya, Logout!"
                        window.location.href = '{{ route("logout") }}';
                    }
                });
            }
        </script>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                var currentUrl = window.location.href;
                var navLinks = document.querySelectorAll('.side-menu__item');

                navLinks.forEach(function(link) {
                    var linkUrl = link.getAttribute('href');

                    if (currentUrl.indexOf(linkUrl) !== -1) {
                        link.classList.add('active');
                        var parentSubMenu = link.closest('.slide-menu');
                        if (parentSubMenu) {
                            var parentMenu = parentSubMenu.parentElement.closest('.slide');
                            if (parentMenu) {
                                parentMenu.classList.add('active');
                                parentSubMenu.classList.add('show');
                            }
                        }
                    }
                });
            });
        </script>
        <script>
            function openSubMenus() {
                var currentUrl = window.location.href;
                var navLinks = document.querySelectorAll('.side-menu__item');

                navLinks.forEach(function(link) {
                    var linkUrl = link.getAttribute('href');

                    if (currentUrl.indexOf(linkUrl) !== -1) {
                        var parentMenu = link.closest('.has-sub');
                        while (parentMenu) {
                            var subMenu = parentMenu.querySelector('.slide-menu');
                            if (subMenu) {
                                subMenu.classList.add('show');
                            }
                            parentMenu = parentMenu.parentElement.closest('.has-sub');
                        }
                    }
                });
            }
            document.addEventListener("DOMContentLoaded", function() {
                openSubMenus(); 
            });
        </script>
        @yield('script')
    </body>
</html>