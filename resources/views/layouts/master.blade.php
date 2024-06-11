<!DOCTYPE html>
<html dir="ltr" lang="en">

@include('layouts.header.index')

<body>
	<div class="preloader">
		<div class="lds-ripple">
			<div class="lds-pos"></div>
			<div class="lds-pos"></div>
		</div>
	</div>

	<div id="main-wrapper" data-theme="light" data-layout="vertical" >

		@include('layouts.header.search-bar')

		{{-- @include('layouts.header.nav-bar') --}}

		<div class="page-wrapper">
			@yield('content')
		</div>
	</div>


	@include('layouts.footer.index')

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
			toastr["error"]('<?= Session::get('error') ?>', "Error");
			@endif
		});
	</script>

</body>

</html>