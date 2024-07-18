<!-- plugin JS -->
<script src="{{ asset('site/plugin/pluginson3step.js') }}"></script>
<script src="{{ asset('site/plugin/bootstrap.min.js') }}"></script>
<script src='{{ asset('site/plugin/bootstrap-datepicker.min.js') }}'></script>
<script src="{{ asset('site/plugin/sticky.js') }}"></script>
<!-- slider revolution  -->
<script src="{{ asset('site/rs-plugin/js/jquery.themepunch.tools.min.js') }}"></script>
<script src="{{ asset('site/rs-plugin/js/jquery.themepunch.revolution.min.js') }}"></script>
<!-- on3step JS -->
<script src="{{ asset('site/js/on3step.js') }}"></script>
<script src="{{ asset('site/js/plugin-set.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>

@include('sweetalert::alert')
<script>
    document.getElementById('lang-icon').addEventListener('click', function(event) {
        event.preventDefault();
        var dropdown = document.querySelector('.language-dropdown');
        if (dropdown.style.display === 'block') {
            dropdown.style.display = 'none';
        } else {
            dropdown.style.display = 'block';
        }
    });

    // إغلاق القائمة عند النقر خارجها
    window.onclick = function(event) {
        if (!event.target.matches('#lang-icon')) {
            var dropdowns = document.getElementsByClassName("language-dropdown");
            var i;
            for (i = 0; i < dropdowns.length; i++) {
                var openDropdown = dropdowns[i];
                if (openDropdown.style.display === 'block') {
                    openDropdown.style.display = 'none';
                }
            }
        }
    };
</script>
@yield('script')