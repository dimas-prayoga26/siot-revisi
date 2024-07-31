<style>
    .side-menu__item {
        white-space: normal; /* Membuat teks membungkus */
        word-wrap: break-word; /* Memastikan teks panjang dipotong dan dibungkus ke baris berikutnya */
    }
    
    .side-menu__item .side-menu__label {
        display: block; /* Memastikan label mendapatkan lebar penuh */
        max-width: 200px; /* Sesuaikan lebar maksimum sesuai kebutuhan Anda */
        word-break: break-word; /* Memastikan kata panjang dibungkus */
    }
    </style>
    
    
    

<!-- Start::app-sidebar -->
<aside class="app-sidebar sticky" id="sidebar">

    <!-- Start::main-sidebar-header -->
    <div class="main-sidebar-header">
        <a href="index.html" class="header-logo">
            <img src="{{ asset('logo/Bank.png') }}" alt="logo" class="desktop-logo" >
            <img src="{{ asset('logo/Bank.png') }}" alt="logo" class="toggle-logo" height="36" width="36">
            <img src="{{ asset('logo/Bank.png') }}" alt="logo" class="desktop-dark" >
            <img src="{{ asset('logo/Bank.png') }}" alt="logo" class="toggle-dark" height="36" width="36">
            <img src="{{ asset('logo/Bank.png') }}" alt="logo" class="desktop-white" >
            <img src="{{ asset('logo/Bank.png') }}" alt="logo" class="toggle-white" height="36" width="36">
        </a>
    </div>
    <!-- End::main-sidebar-header -->

    <!-- Start::main-sidebar -->
    <div class="main-sidebar" id="sidebar-scroll">

        <!-- Start::nav -->
        <nav class="main-menu-container nav nav-pills flex-column sub-open">
            <div class="slide-left" id="slide-left">
                <svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24" viewBox="0 0 24 24"> <path d="M13.293 6.293 7.586 12l5.707 5.707 1.414-1.414L10.414 12l4.293-4.293z"></path> </svg>
            </div>
            <ul class="main-menu">
                <!-- Start::slide__category -->
                <li class="slide__category"><span class="category-name">Main</span></li>
                <!-- End::slide__category -->

                <!-- Start::slide -->
                <li class="slide">
                    <a href="{{ route('dashboard') }}" class="side-menu__item">
                        <i class="fe fe-home side-menu__icon"></i>
                        <span class="side-menu__label">Dashboard</span>
                    </a>
                </li>
                <!-- End::slide -->

                <!-- Start::slide__category -->
                <li class="slide__category"><span class="category-name">Lokasi</span></li>
                <!-- End::slide__category -->

                <!-- Start::slide -->
                <li class="slide">
                    <a href="{{ route('mapsIot') }}" class="side-menu__item">
                        <i class="las la-map-marked-alt side-menu__icon"></i>
                        <span class="side-menu__label">Lokasi Alat</span>
                    </a>
                </li>
                <!-- End::slide -->

                <!-- Start::slide__category -->
                <li class="slide__category"><span class="category-name">Manajemen Akun & Alat</span></li>
                <!-- End::slide__category -->

                <!-- Start::slide -->
                <li class="slide has-sub">
                    <a href="javascript:void(0);" class="side-menu__item">
                        <i class="las la-layer-group side-menu__icon"></i>
                        <span class="side-menu__label">Data Akun</span>
                        <i class="fe fe-chevron-right side-menu__angle"></i>
                    </a>
                    <ul class="slide-menu child1">
                        <li class="slide side-menu__label1">
                            <a href="javascript:void(0)">Pages</a>
                        </li>
                        <li class="slide has-sub">
                            <a href="javascript:void(0);" class="side-menu__item">Pengelolaan Data Akun
                                <i class="fe fe-chevron-right side-menu__angle"></i></a>
                            <ul class="slide-menu child2">
                                <!-- Kondisi untuk menyembunyikan menu Admin (RT) jika pengguna adalah superadmin -->
                                @if(auth()->user()->hasRole('superadmin'))
                                <li class="slide">
                                    <a href="{{ url('data_akun/admin') }}" class="side-menu__item">Admin (RT)</a>
                                </li>
                                @else
                                <li class="slide">
                                    <a href="{{ url('data_akun/petugas') }}" class="side-menu__item">Petugas Sampah</a>
                                </li>
                                <li class="slide">
                                    <a href="{{ url('data_akun/masyarakat') }}" class="side-menu__item">Masyarakat</a>
                                </li>
                                @endif
                            </ul>
                        </li>
                    </ul>
                </li>
                
                

                <li class="slide has-sub">
                    <a href="javascript:void(0);" class="side-menu__item">
                        <i class="las la-cogs side-menu__icon"></i>
                        <span class="side-menu__label">Data Kepemilikan Alat</span>
                        <i class="fe fe-chevron-right side-menu__angle"></i>
                    </a>
                    <ul class="slide-menu child1">
                        <li class="slide side-menu__label1">
                            <a href="javascript:void(0)">Pages</a>
                        </li>
                        <li class="slide has-sub">
                            <a href="javascript:void(0);" class="side-menu__item">Pengelolaan Data Alat
                                <i class="fe fe-chevron-right side-menu__angle"></i></a>
                            <ul class="slide-menu child2">
                                <li class="slide">
                                    <a href="{{ url('data/trash-bin') }}" class="side-menu__item">Alat Ukur Volume Sampah</a>
                                </li>
                                <li class="slide">
                                    <a href="{{ url('data/weight-scale') }}" class="side-menu__item" >Alat Ukur Berat Sampah</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <!-- End::slide -->

                <!-- Start::slide__category -->
                <li class="slide__category"><span class="category-name">Menu lain</span></li>
                <!-- End::slide__category -->

                <li class="slide has-sub">
                    <a href="javascript:void(0);" class="side-menu__item">
                        <i class="las la-balance-scale side-menu__icon"></i>
                        <span class="side-menu__label">Data Berat Sampah</span>
                        <i class="fe fe-chevron-right side-menu__angle"></i>
                    </a>
                    <ul class="slide-menu child1">
                        <li class="slide side-menu__label1">
                            <a href="javascript:void(0)">Pages</a>
                        </li>
                        <li class="slide has-sub">
                            <a href="javascript:void(0);" class="side-menu__item">Filter Data Berat Sampah
                                <i class="fe fe-chevron-right side-menu__angle"></i></a>
                            <ul class="slide-menu child2">
                                <li class="slide">
                                    <a href="{{ route('trash-data-by-type.index') }}" class="side-menu__item">Sampah Berdasarkan Tipe</a>
                                </li>
                                <li class="slide">
                                    <a href="{{ route('trash-data-all.index') }}" class="side-menu__item">Sampah Keseluruhan</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>                
                
                
                {{-- <!-- Start::slide -->
                <li class="slide">
                    <a href="{{ route('trash-data.index') }}" class="side-menu__item">
                        <i class="las la-balance-scale side-menu__icon"></i>
                        <span class="side-menu__label">Data Berat Sampah</span>
                    </a>
                </li>
                <!-- End::slide --> --}}

                <!-- Start::slide -->
                <li class="slide">
                    <a href="{{ route('dueses.index') }}" class="side-menu__item">
                        <i class="las la-money-bill-wave side-menu__icon"></i>
                        <span class="side-menu__label">Data Tagihan</span>
                    </a>
                </li>
                <!-- End::slide -->

                <!-- Start::slide -->
                <li class="slide">
                    <a href="{{ route('expenses.index') }}" class="side-menu__item">
                        <i class="las la-clipboard side-menu__icon"></i>
                        <span class="side-menu__label">Data Pengeluaran</span>
                    </a>
                </li>
                <!-- End::slide -->

                <!-- Start::slide -->
                <li class="slide">
                    <a href="{{ route('feedback.index') }}" class="side-menu__item">
                        <i class="las la-smile side-menu__icon"></i>
                        <span class="side-menu__label">Data Komplen</span>
                    </a>
                </li>
                <!-- End::slide -->

                <!-- Start::slide -->
                <li class="slide">
                    <a href="{{ route('schedule.index') }}" class="side-menu__item">
                        <i class="las la-calendar side-menu__icon"></i>
                        <span class="side-menu__label">Data Jadwal Pengangkutan</span>
                    </a>
                </li>
                <!-- End::slide -->

                {{-- <!-- Start::slide -->
                <li class="slide has-sub">
                    <a href="javascript:void(0);" class="side-menu__item">
                        <i class="bx bx-receipt side-menu__icon"></i>
                        <span class="side-menu__label">Data General</span>
                        <i class="fe fe-chevron-right side-menu__angle"></i>
                    </a>
                    <ul class="slide-menu child1">
                        <li class="slide">
                            <a href="floating_labels.html" class="side-menu__item">Data tempat sampah</a>
                        </li>
                        <li class="slide">
                            <a href="floating_labels.html" class="side-menu__item">Data type sampah</a>
                        </li>
                        <li class="slide">
                            <a href="floating_labels.html" class="side-menu__item">Data feed back</a>
                        </li>
                        <li class="slide">
                            <a href="floating_labels.html" class="side-menu__item">Data schedule</a>
                        </li>
                    </ul>
                </li>
                <!-- End::slide --> --}}

                

                <!-- Start::slide__category -->
                <li class="slide__category"><span class="category-name">Pengaturan</span></li>
                <!-- End::slide__category -->

                <!-- Start::slide -->
                <li class="slide">
                    <a href="{{ route('meta-dueses-nominal.index') }}" class="side-menu__item">
                        <i class="las la-cog side-menu__icon"></i>
                        <span class="side-menu__label">Data Nominal Tagihan</span>
                    </a>
                </li>
                <!-- End::slide -->

                <!-- Start::slide -->
                <li class="slide">
                    <a href="{{ route('pengaturan-tanggal-mingguan.index') }}" class="side-menu__item">
                        <i class="las la-calendar-week side-menu__icon"></i>
                        <span class="side-menu__label">Data Tanggal Mingguan</span>
                    </a>
                </li>
                <!-- End::slide -->

                {{-- <!-- Start::slide -->
                <li class="slide">
                    <a href="#" class="side-menu__item">
                        <i class="las la-calendar-week side-menu__icon"></i>
                        <span class="side-menu__label">Data Tanggal Mingguan</span>
                    </a>
                </li>
                <!-- End::slide --> --}}

                <!-- Start::slide__category -->
                {{-- <li class="slide__category"><span class="category-name">Document</span></li>
                <!-- End::slide__category -->

                <!-- Start::slide -->
                <li class="slide">
                    <a href="#" class="side-menu__item">
                        <i class="las la-file-alt side-menu__icon"></i>
                        <span class="side-menu__label">Data Laporan</span>
                    </a>
                </li>
                <!-- End::slide --> --}}
            </ul>
            <div class="slide-right" id="slide-right"><svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24" viewBox="0 0 24 24"> <path d="M10.707 17.707 16.414 12l-5.707-5.707-1.414 1.414L13.586 12l-4.293 4.293z"></path> </svg></div>
        </nav>
        <!-- End::nav -->

    </div>
    <!-- End::main-sidebar -->

</aside>
<!-- End::app-sidebar -->