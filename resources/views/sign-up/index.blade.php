<!DOCTYPE html>
<html dir="ltr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/images/favicon.png') }}">
    <title>{{ env('APP_NAME') }} - Login</title>
    <link href="{{ asset('assets/css/style.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/toastr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
</head>

<body>
    <div class="main-wrapper">
        <div class="preloader">
            <div class="lds-ripple">
                <div class="lds-pos"></div>
                <div class="lds-pos"></div>
            </div>
        </div>
        <div class="auth-wrapper d-flex no-block justify-content-center align-items-center position-relative">
            <div class="auth-box row">

                <div class="col-lg-9 col-md-9 bg-white">
                    <div class="p-3">
                        <div class="text-center">
                            {{-- <img src="{{ asset('assets/images/big/icon.png') }}" alt="wrapkit"> --}}
                        </div>
                        {{-- <h2 class="mt-3 text-center">Sign In</h2> --}}
                        <form class="mt-4" method="post" action="{{ route('sign-up.submit') }}">
                            @csrf
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="text-dark" >Full Name</label>
                                        <input class="form-control @if ($errors->has('name')) is-invalid @endif"  type="name" name="name" placeholder="Enter your name" required="required" value="{{ old('name') }}">
                                        <div class="invalid-feedback">{{ $errors->first('name') }}</div>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="text-dark" >Email</label>
                                        <input class="form-control @if ($errors->has('email')) is-invalid @endif" type="email"  name="email" placeholder="Enter your email" required="required" value="{{ old('email') }}">
                                        <div class="invalid-feedback">{{ $errors->first('email') }}</div>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="text-dark">Password</label>
                                        <input class="form-control @if ($errors->has('password')) is-invalid @endif"type="password" name="password" placeholder="Enter your password" required="required">
                                        <div class="invalid-feedback">{{ $errors->first('password') }}</div>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="text-dark">Confirm Password</label>
                                        <input class="form-control @if ($errors->has('confirm_password')) is-invalid @endif"type="password" name="confirm_password" placeholder="Confirm Password" required="required">
                                        <div class="invalid-feedback">{{ $errors->first('confirm_password') }}</div>
                                    </div>
                                </div>
                                <div class="col-lg-12 text-center">
                                    <button type="submit" class="btn btn-block btn-dark">Sign Up</button>
                                </div>
                            </div>
                        </form>
            
                    </div>        
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/toastr.min.js') }}"></script>
    <script>
        $(".preloader ").fadeOut();
    </script>

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
</body>

</html>