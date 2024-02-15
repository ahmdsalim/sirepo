@vite('resources/js/app.js')

<script src="{{ asset('assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
<script src="{{ asset('assets/compiled/js/app.js') }}"></script>
<script src="{{ asset('assets/static/js/components/dark.js') }}"></script>
{{-- <script src="{{ asset('assets/static/js/pages/horizontal-layout.js') }}"></script> --}}
{{-- <script src="{{ asset('assets/static/js/pages/dashboard.js') }}"></script> --}}
<script>
    document.addEventListener('DOMContentLoaded', () => {
        @if(session('success'))
            showSuccessToast("{{session('success')}}","{{asset('assets/static/icon/success.svg')}}")
        @endif
        @if(session('failed'))
            showErrorToast("{{session('failed')}}","{{asset('assets/static/icon/danger.svg')}}")
        @endif
    })
</script>
@stack('scripts')