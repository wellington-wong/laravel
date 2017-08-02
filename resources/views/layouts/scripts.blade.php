    <!-- Scripts -->
    <script src="https://app.{{ env('DOMAIN') }}{{ mix('/js/manifest.js') }}"></script>
    <script src="https://app.{{ env('DOMAIN') }}{{ mix('/js/vendor.js') }}"></script>
    <script src="https://app.{{ env('DOMAIN') }}{{ mix('/js/app.js') }}"></script>
    <script src="https://app.{{ env('DOMAIN') }}{{ mix('/js/all.js') }}"></script>

    @yield('js')