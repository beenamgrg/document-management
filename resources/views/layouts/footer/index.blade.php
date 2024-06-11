<footer class="footer text-center text-muted">
    All Rights Reserved <b>{{ env('APP_NAME') }}</b>.
</footer>

<script src="{{ asset('assets/js/jquery.min.js') }}"></script>
<script src="{{ asset('assets/js/popper.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/js/app-style-switcher.js') }}"></script>
<script src="{{ asset('assets/js/feather.min.js') }}"></script>
<script src="{{ asset('assets/js/perfect-scrollbar.jquery.min.js') }}"></script>
<script src="{{ asset('assets/js/sidebarmenu.js') }}"></script>
<script src="{{ asset('assets/js/custom.min.js') }}"></script>
<script src="{{ asset('assets/js/d3.min.js') }}"></script>
<script src="{{ asset('assets/js/c3.min.js') }}"></script>
<script src="{{ asset('assets/js/chartist.min.js') }}"></script>
<script src="{{ asset('assets/js/chartist-plugin-tooltip.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery-jvectormap-2.0.2.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery-jvectormap-world-mill-en.js') }}"></script>
<script src="{{ asset('assets/js/dashboard1.min.js') }}"></script>

<script src="{{ asset('assets/js/prism.js') }}"></script>
<script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/js/sparkline.js') }}"></script>
<script src="{{ asset('assets/js/datatable-basic.init.js') }}"></script>

<script src="{{ asset('assets/js/toastr.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
    <script>
        $(document).ready(function() {
            toastr.options = {
                "closeButton": true,
                "debug": false,
                "newestOnTop": true,
                "progressBar": true,
                "positionClass": "toast-top-right",
                "preventDuplicates": true,
                "onclick": null,
                "showDuration": "300",
                "hideDuration": "1000",
                "timeOut": "10000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            }

            // Display an info toast with no title
            @if(Session::has('success'))
            toastr["success"]('<?= Session::get('success') ?>', "Success");
            @endif

            @if(Session::has('info'))
            toastr["info"]('<?= Session::get('info') ?>', "Info");
            @endif

            @if(Session::has('warning'))
            toastr["warning"]('<?= Session::get('warning') ?>', "Warning");
            @endif

            @if(Session::has('error'))
            @foreach (Session::get('error') as $message)
            toastr["error"]('<?= $message ?>', "Error");
            @endforeach
            @endif
        });
    </script>
@stack('js')
