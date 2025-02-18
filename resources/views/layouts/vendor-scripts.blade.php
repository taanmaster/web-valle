<!-- JAVASCRIPT -->
<script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/plugins/simplebar/simplebar.min.js') }}"></script>
<script src="{{ asset('assets/js/feather.min.js') }}"></script>

@yield('script')

<script src="{{ asset('assets/js/app.js')}}"></script>

@stack('scripts')
