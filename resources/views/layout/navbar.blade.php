<!-- Start::main-header-container -->
<div class="main-header-container container-fluid">

    <!-- Start::header-content-left -->
    <div class="header-content-left">

        <!-- Start::header-element -->
        <div class="header-element">
            <div class="horizontal-logo">
                <a href="index.html" class="header-logo">
                    <img src="{{ asset('assets/images/brand-logos/desktop-logo.png') }}" alt="logo" class="desktop-logo">
                    <img src="{{ asset('assets/images/brand-logos/toggle-logo.png') }}" alt="logo" class="toggle-logo">
                    <img src="{{ asset('assets/images/brand-logos/desktop-dark.png') }}" alt="logo" class="desktop-dark">
                    <img src="{{ asset('assets/images/brand-logos/toggle-dark.png') }}" alt="logo" class="toggle-dark">
                    <img src="{{ asset('assets/images/brand-logos/desktop-white.png') }}" alt="logo" class="desktop-white">
                    <img src="{{ asset('assets/images/brand-logos/toggle-white.png') }}" alt="logo" class="toggle-white">
                </a>
            </div>
        </div>
        <!-- End::header-element -->

        <!-- Start::header-element -->
        <div class="header-element">
            <!-- Start::header-link -->
            <a aria-label="Hide Sidebar" class="sidemenu-toggle header-link animated-arrow hor-toggle horizontal-navtoggle" data-bs-toggle="sidebar" href="javascript:void(0);"><span></span></a>
            <!-- End::header-link -->
        </div>
        <!-- End::header-element -->

        <!-- Start::header-element -->
        <div class="main-header-center  d-none d-lg-block header-link">
            <input type="text" class="form-control" id="typehead" placeholder="Search for results..."
                autocomplete="off">
            <button type="button"  aria-label="button" class="btn pe-1"><i class="fe fe-search" aria-hidden="true"></i></button>
            <div id="headersearch" class="header-search">
                <div class="p-3">
                    <div class="">
                        <p class="fw-semibold text-muted mb-2 fs-13">Recent Searches</p>
                        <div class="ps-0">
                            <a  href="javascript:void(0)" class="search-tags"><i class="fe fe-search me-2"></i>People<span></span></a>
                            <a  href="javascript:void(0)" class="search-tags"><i class="fe fe-search me-2"></i>Pages<span></span></a>
                            <a  href="javascript:void(0)" class="search-tags"><i class="fe fe-search me-2"></i>Articles<span></span></a>
                        </div>
                    </div>
                     <div class="mt-3">
                        <p class="fw-semibold text-muted mb-3 fs-13">Apps and pages</p>
                        <ul class="ps-0">
                            <li class="p-1 d-flex align-items-center text-muted mb-3 search-app">
                                <a class="d-inline-flex align-items-center" href="full-calendar.html"><i class="fe fe-calendar me-2 fs-14 bg-primary-transparent p-2 rounded-circle"></i><span>Calendar</span></a>
                            </li>
                            <li class="p-1 d-flex align-items-center text-muted mb-3 search-app">
                                <a class="d-inline-flex align-items-center" href="mail.html"><i class="fe fe-mail me-2 fs-14 bg-primary-transparent p-2 rounded-circle"></i><span>Mail</span></a>
                            </li>
                            <li class="p-1 d-flex align-items-center text-muted mb-3 search-app">
                                <a class="d-inline-flex align-items-center" href="buttons.html"><i class="fe fe-globe me-2 fs-14 bg-primary-transparent p-2 rounded-circle"></i><span>Buttons</span></a>
                            </li>
                        </ul>
                    </div>
                    <div class="mt-3">
                       <p class="fw-semibold text-muted mb-2 fs-13">Links</p>
                       <ul class="ps-0 list-unstyled mb-0">
                            <li class="p-1 align-items-center text-muted mb-1 search-app">
                                    <a href="javascript:void(0)" class="text-primary"><u>http://spruko/spruko.com</u></a>
                            </li>
                            <li class="p-1 align-items-center text-muted mb-0 pb-0 search-app">
                                    <a href="javascript:void(0)" class="text-primary"><u>http://spruko/spruko.com</u></a>
                            </li>
                        </ul>
                   </div>
                </div>
                <div class="py-3 border-top px-0">
                    <div class="text-center">
                        <a href="javascript:void(0)" class="text-primary text-decoration-underline fs-15">View all</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- End::header-element -->

    </div>
    <!-- End::header-content-left -->

    <!-- Start::header-content-right -->
    <div class="header-content-right">

        <!-- Start::header-element -->
        <div class="header-element header-search d-lg-none d-block">
            <!-- Start::header-link -->
            <a aria-label="anchor" href="javascript:void(0);" class="header-link" data-bs-toggle="modal" data-bs-target="#searchModal">
                <i class="fe fe-search header-link-icon"></i>
            </a>
            <!-- End::header-link -->
        </div>
        <!-- End::header-element -->

        <!-- Start::header-element -->
        <div class="header-element header-theme-mode">
            <!-- Start::header-link|layout-setting -->
            <a aria-label="anchor" href="javascript:void(0);" class="header-link layout-setting">
                <span class="light-layout">
                    <!-- Start::header-link-icon -->
                <i class="fe fe-moon header-link-icon"></i>
                    <!-- End::header-link-icon -->
                </span>
                <span class="dark-layout">
                    <!-- Start::header-link-icon -->
                <i class="fe fe-sun header-link-icon"></i>
                    <!-- End::header-link-icon -->
                </span>
            </a>
            <!-- End::header-link|layout-setting -->
        </div>
        <!-- End::header-element -->

        <!-- Start::header-element -->
        <div class="header-element notifications-dropdown">
            <!-- Start::header-link|dropdown-toggle -->
            <a aria-label="anchor" href="javascript:void(0);" class="header-link dropdown-toggle" data-bs-toggle="dropdown" data-bs-auto-close="outside" id="messageDropdown" aria-expanded="false">
                <i class="fe fe-bell header-link-icon"></i>
                <span class="w-9 h-9 p-0 bg-success rounded-pill header-icon-badge pulse pulse-success" id="notification-icon-badge"></span>
            </a>
            <!-- End::header-link|dropdown-toggle -->
            <!-- Start::main-header-dropdown -->
            <div class="main-header-dropdown dropdown-menu dropdown-menu-end" data-popper-placement="none">
                <div class="p-3">
                    <div class="d-flex align-items-center justify-content-between">
                        <p class="mb-0 fs-17 fw-semibold">Notifications</p>
                        <span class="badge bg-secondary-transparent" id="notifiation-data">5 Unread</span>
                    </div>
                </div>
                <div class="dropdown-divider"></div>
                <ul class="list-unstyled mb-0" id="header-notification-scroll">
                    <li class="dropdown-item">
                        <div class="d-flex align-items-start">
                             <div class="pe-2">
                                 <span class="avatar avatar-md bg-primary avatar-rounded"><i class="fe fe-mail fs-18"></i></span>
                             </div>
                             <div class="flex-grow-1 d-flex align-items-center my-auto">
                                <div>
                                    <p class="mb-0 fw-semibold"><a href="notifications.html">New Application received</a></p>
                                    <span class="text-muted fw-normal fs-12 header-notification-text">3 days ago</span>
                                </div>
                                <div class="ms-auto my-auto">
                                    <a aria-label="anchor" href="javascript:void(0);" class="min-w-fit-content text-muted me-1 dropdown-item-close1"><i class="ti ti-x fs-16"></i></a>
                                </div>
                             </div>
                        </div>
                    </li>
                    <li class="dropdown-item">
                        <div class="d-flex align-items-start">
                             <div class="pe-2">
                                 <span class="avatar avatar-md bg-secondary avatar-rounded"><i class="fe fe-check-circle fs-18"></i></span>
                             </div>
                             <div class="flex-grow-1 d-flex align-items-center my-auto">
                                <div>
                                    <p class="mb-0 fw-semibold"><a href="notifications.html">Project has been approved</a></p>
                                    <span class="text-muted fw-normal fs-12 header-notification-text">2 hours ago</span>
                                </div>
                                <div class="ms-auto my-auto">
                                    <a aria-label="anchor" href="javascript:void(0);" class="min-w-fit-content text-muted me-1 dropdown-item-close1"><i class="ti ti-x fs-16"></i></a>
                                </div>
                             </div>
                        </div>
                    </li>
                    <li class="dropdown-item">
                        <div class="d-flex align-items-start">
                             <div class="pe-2">
                                 <span class="avatar avatar-md bg-success avatar-rounded"><i class="fe fe-shopping-cart fs-18"></i></span>
                             </div>
                             <div class="flex-grow-1 d-flex align-items-center my-auto">
                                <div>
                                    <p class="mb-0 fw-semibold"><a href="notifications.html">Your Product Delivered</a></p>
                                    <span class="text-muted fw-normal fs-12 header-notification-text">30 min ago</span>
                                </div>
                                <div class="ms-auto my-auto">
                                    <a aria-label="anchor" href="javascript:void(0);" class="min-w-fit-content text-muted me-1 dropdown-item-close1"><i class="ti ti-x fs-16"></i></a>
                                </div>
                             </div>
                        </div>
                    </li>
                    <li class="dropdown-item">
                        <div class="d-flex align-items-start">
                             <div class="pe-2">
                                 <span class="avatar avatar-md bg-pink avatar-rounded"><i class="fe fe-shopping-cart fs-18"></i></span>
                             </div>
                             <div class="flex-grow-1 d-flex align-items-center my-auto">
                                <div>
                                    <p class="mb-0 fw-semibold"><a href="notifications.html">Friend Requests</a></p>
                                    <span class="text-muted fw-normal fs-12 header-notification-text">10 min ago</span>
                                </div>
                                <div class="ms-auto my-auto">
                                    <a aria-label="anchor" href="javascript:void(0);" class="min-w-fit-content text-muted me-1 dropdown-item-close1"><i class="ti ti-x fs-16"></i></a>
                                </div>
                             </div>
                        </div>
                    </li>
                </ul>
                <div class="p-3 empty-header-item1 border-top text-center">
                    <a href="notifications.html" class="">View All Notifications</a>
                </div>
                <div class="p-5 empty-item1 d-none">
                    <div class="text-center">
                        <span class="avatar avatar-xl avatar-rounded bg-secondary-transparent">
                            <i class="ri-notification-off-line fs-2"></i>
                        </span>
                        <h6 class="fw-semibold mt-3">No New Notifications</h6>
                    </div>
                </div>
            </div>
            <!-- End::main-header-dropdown -->
        </div>
        <!-- End::header-element -->

        <!-- Start::header-element -->
        <div class="header-element message-dropdown">
            <!-- Start::header-link|dropdown-toggle -->
            <a aria-label="anchor" href="javascript:void(0);" class="header-link dropdown-toggle" data-bs-toggle="dropdown" data-bs-auto-close="outside" id="messageDropdown2" aria-expanded="false">
                <i class="fe fe-message-square header-link-icon"></i>
                <span class="w-9 h-9 p-0 bg-danger rounded-pill header-icon-badge pulse pulse-danger" id="message-icon-badge"></span>
            </a>
            <!-- End::header-link|dropdown-toggle -->
            <!-- Start::main-header-dropdown -->
            <div class="main-header-dropdown dropdown-menu dropdown-menu-end" data-popper-placement="none">
                <div class="p-3">
                    <div class="d-flex align-items-center justify-content-between">
                        <p class="mb-0 fs-17 fw-semibold">Messages</p>
                        <span class="badge bg-secondary-transparent" id="message-data">5 Unread</span>
                    </div>
                </div>
                <div class="dropdown-divider"></div>
                <ul class="list-unstyled mb-0" id="header-message-scroll">
                    <li class="dropdown-item">
                        <div class="d-flex align-items-start">
                             <div class="pe-2">
                                <img src="../assets/images/faces/1.jpg" alt="img" class="avatar avatar-md avatar-rounded">
                             </div>
                             <div class="w-100">
                                <div class="flex-grow-1 d-flex align-items-centermy-auto">
                                    <div>
                                        <h6 class="mb-0 fw-semibold fs-14"><a href="chat.html">Peter Theil</a></h6>
                                    </div>
                                    <div class="ms-auto text-end">
                                        <p class="text-muted mb-0">
                                            6:45am
                                        </p>
                                    </div>
                                 </div>
                                 <div class="flex-grow-1 d-flex align-items-centermy-auto">
                                    <div>
                                        <span class="text-muted fw-normal fs-12">Commented on file Guest list....</span>
                                    </div>
                                    <div class="ms-auto text-end">
                                        <a aria-label="anchor" href="javascript:void(0);" class="min-w-fit-content text-muted me-1 dropdown-item-close2"><i class="ti ti-x fs-16"></i></a>
                                    </div>
                                 </div>
                             </div>
                        </div>
                    </li>
                    <li class="dropdown-item">
                        <div class="d-flex align-items-start">
                             <div class="pe-2">
                                <img src="../assets/images/faces/15.jpg" alt="img" class="avatar avatar-md avatar-rounded">
                             </div>
                             <div class="w-100">
                                <div class="flex-grow-1 d-flex align-items-centermy-auto">
                                    <div>
                                        <h6 class="mb-0 fw-semibold fs-14"><a href="chat.html">Abagael Luth</a></h6>
                                    </div>
                                    <div class="ms-auto text-end">
                                        <p class="text-muted mb-0">10:35am</p>
                                    </div>
                                 </div>
                                 <div class="flex-grow-1 d-flex align-items-centermy-auto">
                                    <div>
                                        <span class="text-muted fw-normal fs-12">New Meetup Started......</span>
                                    </div>
                                    <div class="ms-auto text-end">
                                        <a aria-label="anchor" href="javascript:void(0);" class="min-w-fit-content text-muted me-1 dropdown-item-close2"><i class="ti ti-x fs-16"></i></a>
                                    </div>
                                 </div>
                             </div>
                        </div>
                    </li>
                    <li class="dropdown-item">
                        <div class="d-flex align-items-start">
                             <div class="pe-2">
                                <img src="../assets/images/faces/12.jpg" alt="img" class="avatar avatar-md avatar-rounded">
                             </div>
                             <div class="w-100">
                                <div class="flex-grow-1 d-flex align-items-centermy-auto">
                                    <div>
                                        <h6 class="mb-0 fw-semibold fs-14"><a href="chat.html">Brizid Dawson</a></h6>
                                    </div>
                                    <div class="ms-auto text-end">
                                        <p class="text-muted mb-0">02:17am</p>
                                    </div>
                                 </div>
                                 <div class="flex-grow-1 d-flex align-items-centermy-auto">
                                    <div>
                                        <span class="text-muted fw-normal fs-12">Brizid is in the Warehouse...</span>
                                    </div>
                                    <div class="ms-auto text-end">
                                        <a aria-label="anchor" href="javascript:void(0);" class="min-w-fit-content text-muted me-1 dropdown-item-close2"><i class="ti ti-x fs-16"></i></a>
                                    </div>
                                 </div>
                             </div>
                        </div>
                    </li>
                    <li class="dropdown-item">
                        <div class="d-flex align-items-start">
                             <div class="pe-2">
                                <img src="../assets/images/faces/4.jpg" alt="img" class="avatar avatar-md avatar-rounded">
                             </div>
                             <div class="w-100">
                                <div class="flex-grow-1 d-flex align-items-centermy-auto">
                                    <div>
                                        <h6 class="mb-0 fw-semibold fs-14"><a href="chat.html">Shannon Shaw</a></h6>
                                    </div>
                                    <div class="ms-auto text-end">
                                        <p class="text-muted mb-0">7:55pm</p>
                                    </div>
                                 </div>
                                 <div class="flex-grow-1 d-flex align-items-centermy-auto">
                                    <div>
                                        <span class="text-muted fw-normal fs-12">New Product Realease......</span>
                                    </div>
                                    <div class="ms-auto text-end">
                                        <a aria-label="anchor" href="javascript:void(0);" class="min-w-fit-content text-muted me-1 dropdown-item-close2"><i class="ti ti-x fs-16"></i></a>
                                    </div>
                                 </div>
                             </div>
                        </div>
                    </li>
                    <li class="dropdown-item">
                        <div class="d-flex align-items-start">
                             <div class="pe-2">
                                <img src="../assets/images/faces/3.jpg" alt="img" class="avatar avatar-md avatar-rounded">
                             </div>
                             <div class="w-100">
                                <div class="flex-grow-1 d-flex align-items-centermy-auto">
                                    <div>
                                        <h6 class="mb-0 fw-semibold fs-14"><a href="chat.html">Cherry Blossom</a></h6>
                                    </div>
                                    <div class="ms-auto text-end">
                                        <p class="text-muted mb-0">7:55pm</p>
                                    </div>
                                 </div>
                                 <div class="flex-grow-1 d-flex align-items-centermy-auto">
                                    <div>
                                        <span class="text-muted fw-normal fs-12">You have appointment on......</span>
                                    </div>
                                    <div class="ms-auto text-end">
                                        <a aria-label="anchor" href="javascript:void(0);" class="min-w-fit-content text-muted me-1 dropdown-item-close2"><i class="ti ti-x fs-16"></i></a>
                                    </div>
                                 </div>
                             </div>
                        </div>
                    </li>
                </ul>
                <div class="p-3 empty-header-item2 border-top text-center">
                    <a href="chat.html" class="">View All Messages</a>
                </div>
                <div class="p-5 empty-item2 d-none">
                    <div class="text-center">
                        <span class="avatar avatar-xl avatar-rounded bg-danger-transparent">
                            <i class="ri-message-2-line fs-2"></i>
                        </span>
                        <h6 class="fw-semibold mt-3">No New Messages</h6>
                    </div>
                </div>
            </div>
            <!-- End::main-header-dropdown -->
        </div>
        <!-- End::header-element -->

        <!-- Start::header-element -->
        <div class="header-element header-fullscreen">
            <!-- Start::header-link -->
            <a aria-label="anchor" onclick="openFullscreen();" href="#" class="header-link">
                <i class="fe fe-minimize full-screen-open header-link-icon"></i>
                <i class="fe fe-minimize-2 full-screen-close header-link-icon d-none"></i>
            </a>
            <!-- End::header-link -->
        </div>
        <!-- End::header-element -->

        <!-- Start::header-element -->
        <div class="header-element main-profile-user">
            <!-- Start::header-link|dropdown-toggle -->
            @php
                $imagePath = 'public/' . (Auth::user()->userData->image ?? '');
                $defaultImage = asset('assets/images/faces/5.jpg');
            @endphp
            <a href="#" class="header-link dropdown-toggle" id="mainHeaderProfile" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
                <div class="d-flex align-items-center">
                    <div class="me-xxl-2 me-0">
                        @if(Storage::exists($imagePath))
                            <img src="{{ Storage::url(Auth::user()->userData->image) }}" alt="img" width="32" height="32" class="rounded-circle">
                        @else
                            <img src="{{ $defaultImage }}" alt="img" width="32" height="32" class="rounded-circle">
                        @endif
                    </div>
                    <div class="d-xxl-block d-none my-auto">
                        <h6 class="fw-semibold mb-0 lh-1 fs-14">{{ Auth::user()->userData->name ?? '' }}</h6>
                        <span class="op-7 fw-normal d-block fs-11 text-muted">{{ Auth::user()->getRoleNames()->implode(', ') ?? 'Role Tidak Ditemukan' }}</span>
                    </div>
                </div>
            </a>
            {{-- {{ Storage::url(Auth::user()->userData->image) }} --}}
            <!-- End::header-link|dropdown-toggle -->
            <ul class="main-header-dropdown dropdown-menu pt-0 header-profile-dropdown dropdown-menu-end" aria-labelledby="mainHeaderProfile">
                <li class="drop-heading d-xxl-none d-block">
                     <div class="text-center">
                        <h5 class="text-dark mb-0 fs-14 fw-semibold">{{ Auth::user()->userData->name ?? '' }}</h5>
                        <small class="text-muted">{{ Auth::user()->getRoleNames()->implode(', ') ?? 'Role Tidak Ditemukan' }}</small>
                    </div>
                </li>
                <li class="dropdown-item"><a class="d-flex w-100" href="{{ route('profile') }}"><i class="fe fe-user fs-18 me-2 text-primary"></i>Profile</a></li>
                {{-- <li class="dropdown-item"><a class="d-flex w-100" href="mail.html"><i class="fe fe-mail fs-18 me-2 text-primary"></i>Inbox <span class="badge bg-danger ms-auto">25</span></a></li> --}}
                <li class="dropdown-item"><a class="d-flex w-100" href="#" onclick="confirmLogout()"><i class="fe fe-info fs-18 me-2 text-primary"></i>Log Out</a></li>
            </ul>
        </div>
        <!-- End::header-element -->

    </div>
    <!-- End::header-content-right -->

</div>
<!-- End::main-header-container -->