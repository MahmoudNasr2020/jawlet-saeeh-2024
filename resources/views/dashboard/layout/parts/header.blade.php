<div class="navbar-custom">
    <div class="topbar container-fluid">
        <div class="d-flex align-items-center gap-1">

            <!-- Topbar Brand Logo -->
            <div class="logo-topbar">
                <!-- Logo light -->
                <a href="/" class="logo-light">
                                <span class="logo-lg">
                                    <img src="{{ asset('dashboard/assets/images/logo.png') }}" alt="logo">
                                </span>
                    <span class="logo-sm">
                                    <img src="{{ asset('dashboard/assets/images/logo-sm.png') }}" alt="small logo">
                                </span>
                </a>

                <!-- Logo Dark -->
                <a href="/" class="logo-dark">
                                <span class="logo-lg">
                                    <img src="{{ asset('dashboard/assets/images/logo-dark.png') }}" alt="dark logo">
                                </span>
                    <span class="logo-sm">
                                    <img src="{{ asset('dashboard/assets/images/logo-sm.png') }}" alt="small logo">
                                </span>
                </a>
            </div>

            <!-- Sidebar Menu Toggle Button -->
            <button class="button-toggle-menu">
                <i class="ri-menu-line"></i>
            </button>

            <!-- Horizontal Menu Toggle Button -->
            <button class="navbar-toggle" data-bs-toggle="collapse" data-bs-target="#topnav-menu-content">
                <div class="lines">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </button>

            <!-- Topbar Search Form -->
            <div class="app-search d-none d-lg-block">
                <form>
                    <div class="input-group">
                        <input type="search" class="form-control" placeholder="Search...">
                        <span class="ri-search-line search-icon text-muted"></span>
                    </div>
                </form>
            </div>
        </div>

        <ul class="topbar-menu d-flex align-items-center gap-3">
            <li class="dropdown d-lg-none">
                <a class="nav-link dropdown-toggle arrow-none" data-bs-toggle="dropdown" href="#" role="button"
                   aria-haspopup="false" aria-expanded="false">
                    <i class="ri-search-line fs-22"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-animated dropdown-lg p-0">
                    <form class="p-3">
                        <input type="search" class="form-control" placeholder="Search ..."
                               aria-label="Recipient's username">
                    </form>
                </div>
            </li>


            <li class="dropdown notification-list">
                <a class=""  href="/" role="button"
                   aria-haspopup="false" aria-expanded="false">
                    <i class="ri-global-fill fs-22"></i>
                </a>

            </li>

            <li class="dropdown notification-list">
                <a class="nav-link dropdown-toggle arrow-none" data-bs-toggle="dropdown" href="#" role="button"
                   aria-haspopup="false" aria-expanded="false">
                    <i class="ri-notification-3-line fs-22"></i>
                    @php
                        $notification = \App\Models\RentalCarReservation::where('is_viewed',0)->count();
                    @endphp
                    @if($notification > 0)
                        <span class="noti-icon-badge badge text-bg-pink">{{ $notification  }}</span>
                    @endif

                </a>
                <div class="dropdown-menu dropdown-menu-end dropdown-menu-animated dropdown-lg py-0">
                    <div class="p-2 border-top-0 border-start-0 border-end-0 border-dashed border">
                        <div class="row align-items-center">
                            <div class="col">
                                <h6 class="m-0 fs-16 fw-semibold">الاشعارات</h6>
                            </div>

                        </div>
                    </div>

                    <div style="max-height: 300px;" data-simplebar class="notify-items">

                        @foreach(\App\Models\RentalCarReservation::where('is_viewed',0)->get() as $notification)
                            <!-- item-->
                            <a href="{{ route('dashboard.rental-car-reservations-show',$notification->id) }}" class="dropdown-item notify-item">
                                <div class="notify-icon bg-primary-subtle">
                                    <i class="mdi mdi-comment-account-outline text-primary"></i>
                                </div>
                                <p class="notify-details" style="white-space: normal;">
                                    {{ $notification->user->first_name . ' ' .$notification->user->last_name }}
                                    قام بحجز السيارة
                                    {{ $notification->rentalCar->name }}
                                    <small class="noti-time">{{ $notification->created_at->diffForHumans() }}</small>
                                </p>
                            </a>
                        @endforeach

                    </div>

                </div>
            </li>

            <li class="d-none d-sm-inline-block">
                <a class="nav-link" data-bs-toggle="offcanvas" href="#theme-settings-offcanvas">
                    <i class="ri-settings-3-line fs-22"></i>
                </a>
            </li>

            <li class="d-none d-sm-inline-block">
                <div class="nav-link" id="light-dark-mode">
                    <i class="ri-moon-line fs-22"></i>
                </div>
            </li>

            <li class="dropdown">
                <a class="nav-link dropdown-toggle arrow-none nav-user" data-bs-toggle="dropdown" href="#" role="button"
                   aria-haspopup="false" aria-expanded="false">
                                <span class="account-user-avatar">
                                    <img src="{{ \Illuminate\Support\Facades\Auth::guard('admin')->user()->image }}" alt="user-image" width="32" class="rounded-circle">
                                </span>
                    <span class="d-lg-block d-none">
                                    <h5 class="my-0 fw-normal">{{ \Illuminate\Support\Facades\Auth::guard('admin')->user()->name }} <i
                                            class="ri-arrow-down-s-line d-none d-sm-inline-block align-middle"></i></h5>
                                </span>
                </a>
                <div class="dropdown-menu dropdown-menu-end dropdown-menu-animated profile-dropdown">
                    <!-- item-->
                    <div class=" dropdown-header noti-title">
                        <h6 class="text-overflow m-0">اهلا بك !</h6>
                    </div>

                    <!-- item-->
                    <a href="{{ route('dashboard.profile.index') }}" class="dropdown-item">
                        <i class="ri-account-circle-line fs-18 align-middle me-1"></i>
                        <span>حسابي</span>
                    </a>

                    <!-- item-->
                    <a href="{{ route('dashboard.setting.index') }}" class="dropdown-item">
                        <i class="ri-settings-4-line fs-18 align-middle me-1"></i>
                        <span>الاعدادات</span>
                    </a>


                    <!-- item-->
                    <form id="logout-form" action="{{ route('dashboard.logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>

                    <a href="#" class="dropdown-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="ri-logout-box-line fs-18 align-middle me-1"></i>
                        <span>تسجيل الخروج</span>
                    </a>

                </div>
            </li>
        </ul>
    </div>
</div>
