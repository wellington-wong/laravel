    <!-- Scripts -->
    <script src="https://app.{{ env('DOMAIN') }}{{ mix('/js/manifest.js') }}"></script>
    <script src="https://app.{{ env('DOMAIN') }}{{ mix('/js/vendor.js') }}"></script>
    <script src="https://app.{{ env('DOMAIN') }}{{ mix('/js/app.js') }}"></script>
    <script src="https://app.{{ env('DOMAIN') }}{{ mix('/js/all.js') }}"></script>
	<script src="https://js.stripe.com/v3/"></script>

    @yield('js')