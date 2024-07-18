<!-- Vendor js -->
<script src="{{ asset('dashboard/assets/js/vendor.min.js') }}"></script>

<!-- Daterangepicker js -->
<script src="{{ asset('dashboard/assets/vendor/daterangepicker/moment.min.js') }}"></script>
<script src="{{ asset('dashboard/assets/vendor/daterangepicker/daterangepicker.js') }}"></script>

<!-- Apex Charts js -->
<script src="{{ asset('dashboard/assets/vendor/apexcharts/apexcharts.min.js') }}"></script>

<!-- Vector Map js -->
<script src="{{ asset('dashboard/assets/vendor/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.min.js') }}"></script>
<script src="{{ asset('dashboard/assets/vendor/admin-resources/jquery.vectormap/maps/jquery-jvectormap-world-mill-en.js') }}"></script>

<!-- Dashboard App js -->
<script src="{{ asset('dashboard/assets/js/pages/dashboard.js') }}"></script>


<!-- App js -->
<script src="{{ asset('dashboard/assets/js/app.min.js') }}"></script>

@include('sweetalert::alert')

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>

<script>
    $(document).ready(function() {

        $('.nav-link.dropdown-toggle').click(function() {
            $.ajax({
                url: '{{ route('dashboard.rental-car-reservations.mark-as-viewed-reservations') }}',
                type: 'POST',
                success: function(response) {
                    $('.noti-icon-badge').text('0'); // تصفير العداد
                    // يمكنك هنا إضافة أي رد فعل آخر بناءً على الرد، مثل تغيير لون الأيقونة
                },
                error: function(error) {
                    console.log(error); // تسجيل الخطأ في حال وجوده
                }
            });
        });

/*
        let lastNotificationId = 0; // يتم تحديث هذا المعرف بمعرف الإشعار الأخير الذي تم جلبه

        function fetchNewNotifications() {
            $.ajax({
                url: '',
                type: 'GET',
                data:{'lastId':lastNotificationId},
                success: function(response) {
                    if (response.notifications.length > 0) {
                        $('.noti-icon-badge').text(response.notifications.length); // تحديث العداد بعدد الإشعارات الجديدة

                        lastNotificationId = response.notifications[0].id;
                        // بناء HTML للإشعارات الجديدة وإضافتها إلى القائمة
                        let newNotificationsHtml = '';
                        response.notifications.forEach(function(notification) {
                            newNotificationsHtml += `<a href="/dashboard/rental-car-reservations/${notification.id}" class="dropdown-item notify-item" style="z-index: 99999">
                        <div class="notify-icon bg-primary-subtle">
                            <i class="mdi mdi-comment-account-outline text-primary"></i>
                        </div>
                        <p class="notify-details" style="white-space: break-spaces;">${notification.user.first_name} ${notification.user.last_name} قام بحجز السيارة ${notification.rental_car.name} <small class="noti-time">${notification.created_at_human}</small></p>
                    </a>`; });

                        $('.notify-items').prepend(newNotificationsHtml); // إضافة الإشعارات الجديدة في بداية القائمة
                    }
                },
                error: function(error) {
                    console.log(error); // تسجيل الخطأ في حال وجوده
                }
            });
        }

// تشغيل الدالة كل 10 ثواني


        setInterval(fetchNewNotifications, 10000); // Call the function every 10 seconds*/


    });
</script>


@yield('script')
