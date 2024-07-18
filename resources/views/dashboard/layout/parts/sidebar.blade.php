<div class="leftside-menu">

    <!-- Brand Logo Light -->
    <a href="/" class="logo logo-light">
                    <span class="logo-lg">
                       <img src="http://127.0.0.1:8000/dashboard/assets/images/logo2.png" alt="logo" style="
    width: 149px;
    height: 122px;
">
                    </span>
        <span class="logo-sm">
                        <img src="{{ asset('dashboard/assets/images/logo-sm.png') }}" alt="small logo">
                    </span>
    </a>

    <!-- Brand Logo Dark -->
    <a href="/" class="logo logo-dark">
                    <span class="logo-lg">
                        <img src="{{ asset('dashboard/assets/images/logo-dark.png') }}" alt="dark logo">
                    </span>
        <span class="logo-sm">
                        <img src="{{ asset('dashboard/assets/images/logo-sm.png') }}" alt="small logo">
                    </span>
    </a>

    <!-- Sidebar -left -->
    <div class="h-100" id="leftside-menu-container" data-simplebar>
        <!--- Sidemenu -->
        <ul class="side-nav">

            <li class="side-nav-title">لوحة التحكم</li>

            <li class="side-nav-item">
                <a href="/" class="side-nav-link">
                    <i class="ri-home-3-line"></i>
                   {{-- <span class="badge bg-success float-end">9+</span>--}}
                    <span> الرئيسية </span>
                </a>
            </li>

            <li class="side-nav-item">
                <a href="{{ route('dashboard.about.index') }}" class="side-nav-link">
                    <i class="ri-plane-line"></i>
                    <span> عن جولة سائح </span>
                </a>
            </li>


            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#sidebarSlider" aria-expanded="false" aria-controls="sidebarSlider" class="side-nav-link">
                    <i class="ri-slideshow-2-line"></i>
                    <span> البانرات </span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="sidebarSlider">
                    <ul class="side-nav-second-level">
                        <li>
                            <a href="{{ route('dashboard.sliders.index') }}">عرض االبانرات</a>
                        </li>
                        <li>
                            <a href="{{ route('dashboard.sliders.create') }}">اضافة بانر جديد</a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#sidebarServices" aria-expanded="false" aria-controls="sidebarServices" class="side-nav-link">
                    <i class="ri-customer-service-2-fill"></i>
                    <span> الخدمات </span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="sidebarServices">
                    <ul class="side-nav-second-level">
                        <li>
                            <a href="{{ route('dashboard.services.index') }}">عرض الخدمات</a>
                        </li>
                        <li>
                            <a href="{{ route('dashboard.services.create') }}">اضافة خدمة جديدة</a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#sidebarPat" aria-expanded="false" aria-controls="sidebarPat" class="side-nav-link">
                    <i class="ri-user-follow-line"></i>
                    <span> الشركاء </span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="sidebarPat">
                    <ul class="side-nav-second-level">
                        <li>
                            <a href="{{ route('dashboard.partners.index') }}">عرض الشركاء</a>
                        </li>
                        <li>
                            <a href="{{ route('dashboard.partners.create') }}">اضافة شريك جديد</a>
                        </li>
                    </ul>
                </div>
            </li>


            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#sidebarMultiLevel" aria-expanded="false" aria-controls="sidebarMultiLevel" class="side-nav-link">
                    <i class="ri-car-fill"></i>
                    <span> تاجير السيارات </span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="sidebarMultiLevel">
                    <ul class="side-nav-second-level">
                        <li class="side-nav-item">
                            <a data-bs-toggle="collapse" href="#sidebarSecondLevel" aria-expanded="false" aria-controls="sidebarSecondLevel">
                                <span>ماركات السيارات </span>
                                <span class="menu-arrow"></span>
                            </a>
                            <div class="collapse" id="sidebarSecondLevel">
                                <ul class="side-nav-third-level">
                                    <li>
                                        <a href="{{ route('dashboard.rental-car-departments.index') }}">عرض الماركات</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('dashboard.rental-car-departments.create') }}">اضاقة ماركة جديدة</a>
                                    </li>
                                </ul>
                            </div>
                        </li>

                        <li class="side-nav-item">
                            <a data-bs-toggle="collapse" href="#sidebarCarLevel" aria-expanded="false" aria-controls="sidebarCarLevel">
                                <span>السيارات </span>
                                <span class="menu-arrow"></span>
                            </a>
                            <div class="collapse" id="sidebarCarLevel">
                                <ul class="side-nav-third-level">
                                    <li>
                                        <a href="{{ route('dashboard.rental-cars.index') }}">عرض السيارات</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('dashboard.rental-cars.create') }}">اضاقة سيارة جديدة</a>
                                    </li>
                                </ul>
                            </div>
                        </li>

                        <li class="side-nav-item">
                            <a data-bs-toggle="collapse" href="#sidebarResLevel" aria-expanded="false" aria-controls="sidebarResLevel">
                                <span>الحجوزات </span>
                                <span class="menu-arrow"></span>
                            </a>
                            <div class="collapse" id="sidebarResLevel">
                                <ul class="side-nav-third-level">
                                    <li class="side-nav-item">
                                        <a href="{{ route('dashboard.rental-car-reservations.expected_reservations') }}" class="side-nav-link">
                                            <span class="badge bg-success float-end">{{ \App\Models\RentalCarReservation::where('status','0')->count() }}+</span>
                                            <span> الحجوزات المعلقة </span>
                                        </a>
                                    </li>

                                    <li>
                                        <a href="{{ route('dashboard.rental-car-reservations.current_reservations') }}">الحجوزات الحالية</a>
                                    </li>

                                    <li>
                                        <a href="{{ route('dashboard.rental-car-reservations.upcoming_reservations') }}">الحجوزات المقبلة</a>
                                    </li>

                                    <li>
                                        <a href="{{ route('dashboard.rental-car-reservations.expired_reservations') }}">الحجوزات المنتهية</a>
                                    </li>
                                </ul>
                            </div>
                        </li>

                        <li class="side-nav-item">
                            <a data-bs-toggle="collapse" href="#sidebarCityLevel" aria-expanded="false" aria-controls="sidebarCityLevel">
                                <span>المدن </span>
                                <span class="menu-arrow"></span>
                            </a>
                            <div class="collapse" id="sidebarCityLevel">
                                <ul class="side-nav-third-level">
                                    <li>
                                        <a href="{{ route('dashboard.rental-car-cities.index') }}">عرض المدن</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('dashboard.rental-car-cities.create') }}">اضاقة مدينة جديدة</a>
                                    </li>
                                </ul>
                            </div>
                        </li>

                    </ul>
                </div>
            </li>

            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#hotelMultiLevel" aria-expanded="{{ request()->segment(3) == 'rooms' ? 'true' : 'false' }}" aria-controls="hotelMultiLevel" class="side-nav-link">
                    <i class="ri-hotel-fill"></i>
                    <span> الفنادق </span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse {{ request()->segment(3) == 'rooms' ? 'show' : '' }}" id="hotelMultiLevel">
                    <ul class="side-nav-second-level">

                        <li class="side-nav-item">
                            <a href="{{ route('dashboard.hotels.overview') }}"
                               aria-expanded="{{ request()->segment(3) == 'hotels-overview' ? 'true' : 'false' }}"
                               aria-controls="hotelSecondLevel">
                                <span>نظرة عامة </span>
                            </a>
                        </li>

                        <li class="side-nav-item">
                            <a data-bs-toggle="collapse" href="#hotelSecondLevel" aria-expanded="{{ request()->segment(3) == 'rooms' ? 'true' : 'false' }}" aria-controls="hotelSecondLevel">
                                <span>الفنادق </span>
                                <span class="menu-arrow"></span>
                            </a>
                            <div class="collapse {{ request()->segment(3) == 'rooms' ? 'show' : '' }}" id="hotelSecondLevel">
                                <ul class="side-nav-third-level">
                                    <li>
                                        <a href="{{ route('dashboard.hotels.index') }}">عرض الفنادق</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('dashboard.hotels.create') }}">إضافة فندق جديد</a>
                                    </li>
                                </ul>
                            </div>
                        </li>

                        <li class="side-nav-item">
                            <a data-bs-toggle="collapse" href="#roomSecondLevel" aria-expanded="{{ request()->segment(3) == 'rooms' ? 'true' : 'false' }}" aria-controls="roomSecondLevel">
                                <span>الغرف </span>
                                <span class="menu-arrow"></span>
                            </a>
                            <div class="collapse {{ request()->segment(3) == 'rooms' ? 'show' : '' }}" id="roomSecondLevel">
                                <ul class="side-nav-third-level">
                                    <li>
                                        <a href="{{ route('dashboard.hotels.rooms.index') }}">عرض الغرف</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('dashboard.hotels.rooms.available_rooms') }}">الغرف المتاحة</a>
                                    </li>
                                </ul>
                            </div>
                        </li>


                     <li class="side-nav-item">
                            <a data-bs-toggle="collapse" href="#CouponSecondLevel"
                               aria-expanded="{{ request()->segment(3) == 'hotel-coupons' ? 'true' : 'false' }}" aria-controls="CouponSecondLevel">
                                <span>الكوبونات </span>
                                <span class="menu-arrow"></span>
                            </a>
                            <div class="collapse {{ request()->segment(3) == 'hotel-coupons' ? 'show' : '' }}" id="CouponSecondLevel">
                                <ul class="side-nav-third-level">
                                    <li>
                                        <a href="{{ route('dashboard.hotel-coupons.index') }}">عرض الكوبونات</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('dashboard.hotel-coupons.create') }}">اضافة كوبون</a>
                                    </li>
                                </ul>
                            </div>
                        </li>


                        <li class="side-nav-item">
                            <a data-bs-toggle="collapse" href="#sidebarHotLevel" aria-expanded="false" aria-controls="sidebarHotLevel">
                                <span>الحجوزات </span>
                                <span class="menu-arrow"></span>
                            </a>
                            <div class="collapse" id="sidebarHotLevel">
                                <ul class="side-nav-third-level">

                                    <li class="side-nav-item">
                                        <a href="{{ route('dashboard.hotels-reservations.expected_reservations') }}" class="side-nav-link">
                                            <span class="badge bg-success float-end">{{ \App\Models\HotelReservation::where('status','0')->where('is_canceled','0')->count() }}+</span>
                                            <span> الحجوزات المعلقة </span>
                                        </a>
                                    </li>

                                    <li>
                                        <a href="{{ route('dashboard.hotels-reservations.current_reservations') }}">الحجوزات الحالية</a>
                                    </li>

                                    <li>
                                        <a href="{{ route('dashboard.hotels-reservations.upcoming_reservations') }}">الحجوزات المقبلة</a>
                                    </li>

                                    <li>
                                        <a href="{{ route('dashboard.hotels-reservations.expired_reservations') }}">الحجوزات المنتهية</a>
                                    </li>

                                    <li>
                                        <a href="{{ route('dashboard.hotels-reservations.canceled_reservations') }}">الحجوزات الملغية</a>
                                    </li>
                                </ul>
                            </div>
                        </li>

                    </ul>
                </div>
            </li>

            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#sidebarRes" aria-expanded="false" aria-controls="sidebarRes" class="side-nav-link">
                    <i class="ri-restaurant-line"></i>
                    <span> المطاعم </span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="sidebarRes">
                    <ul class="side-nav-second-level"> 
                      <li>
                            <a href="{{ route('dashboard.restaurant-registrations.index') }}">عرض استمارات المطاعم</a>
                        </li>
                        <li>
                            <a href="{{ route('dashboard.restaurants.index') }}">عرض المطاعم</a>
                        </li>
                        <li>
                            <a href="{{ route('dashboard.restaurants.create') }}">اضافة مطعم جديد</a>
                        </li>
                    </ul>
                </div>
            </li>


            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#flightMultiLevel" aria-expanded="false" aria-controls="hotelMultiLevel" class="side-nav-link">
                    <i class="ri-flight-takeoff-line"></i>
                    <span> حجوزات الطيران </span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="flightMultiLevel">
                    <ul class="side-nav-second-level">

                        <li class="side-nav-item">
                            <a href="{{ route('dashboard.flight.overview') }}"
                               aria-expanded="{{ request()->segment(3) == 'flight-overview' ? 'true' : 'false' }}"
                               aria-controls="hotelSecondLevel">
                                <span>نظرة عامة </span>
                            </a>
                        </li>

                        <li class="side-nav-item">
                            <a data-bs-toggle="collapse" href="#sidebarFlightLevel" aria-expanded="false" aria-controls="sidebarFlightLevel">
                                <span>الحجوزات </span>
                                <span class="menu-arrow"></span>
                            </a>
                            <div class="collapse" id="sidebarFlightLevel">
                                <ul class="side-nav-third-level">

                                    <li class="side-nav-item">
                                        <a href="{{ route('dashboard.flight-reservations.expected_reservations') }}" class="side-nav-link">
                                            <span class="badge bg-success float-end">{{ \App\Models\FlightReservation::where('status','0')->where('is_canceled','0')->count() }}+</span>
                                            <span> الحجوزات المعلقة </span>
                                        </a>
                                    </li>

                                    <li>
                                        <a href="{{ route('dashboard.flight-reservations.current_reservations') }}">الحجوزات الحالية</a>
                                    </li>

                                    <li>
                                        <a href="{{ route('dashboard.flight-reservations.upcoming_reservations') }}">الحجوزات المقبلة</a>
                                    </li>

                                    <li>
                                        <a href="{{ route('dashboard.flight-reservations.expired_reservations') }}">الحجوزات المنتهية</a>
                                    </li>

                                    <li>
                                        <a href="{{ route('dashboard.flight-reservations.canceled_reservations') }}">الحجوزات الملغية</a>
                                    </li>
                                </ul>
                            </div>
                        </li>

                    </ul>
                </div>
            </li>


            <li class="side-nav-item">
                <a href="{{ route('dashboard.profile.index') }}" class="side-nav-link">
                    <i class="ri-file-user-line"></i>
                    {{-- <span class="badge bg-success float-end">9+</span>--}}
                    <span> حسابي </span>
                </a>
            </li>

            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#sidebarSet" aria-expanded="false" aria-controls="sidebarSet" class="side-nav-link">
                    <i class="ri-settings-5-line"></i>
                    <span> الاعدادات </span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="sidebarSet">
                    <ul class="side-nav-second-level">
                        <li>
                            <a href="{{ route('dashboard.setting.index') }}">اعدادت الموقع</a>
                        </li>
                        <li>
                            <a href="{{ route('dashboard.moyasar-payment-setting.index') }}">اعدادت بوابة الدفع</a>
                        </li>
                    </ul>
                </div>
            </li>

        </ul>
        <!--- End Sidemenu -->

        <div class="clearfix"></div>
    </div>
</div>
