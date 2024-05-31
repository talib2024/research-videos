<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin | Log in</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('backend/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="{{ asset('backend/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('backend/dist/css/adminlte.min.css') }}">
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
            <a href="#"><b>Admin</b> Login</a>
        </div>
        <!-- /.login-logo -->
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">Sign in to start your session</p>

                @if ($message = Session::get('message'))
                    <div class="alert alert-info">
                        {{ $message }}
                    </div>
                @endif

                <form action="{{ route('admin.login.post') }}" method="post">
                    @csrf
                      <span class="text-danger">{{ $errors->first('email') }}</span>
                    <div class="input-group mb-3">
                        <input type="email" name="email" class="form-control" placeholder="Email">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                      <span class="text-danger">{{ $errors->first('password') }}</span>
                    <div class="input-group mb-3">
                        <input type="password" name="password" class="form-control" placeholder="Password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="input-group mt-3">
                            <label>Captcha <b class="text-danger">*</b></label><span>&nbsp;</span>
                            <div class="captcha">
                                <span>{!! captcha_img() !!}</span>
                                <button type="button" class="btn btn-danger captchaButton" class="reload"
                                    id="reload">
                                    &#x21bb;
                                </button>
                            </div>
                        </div>
                            <span class="text-danger">{{ $errors->first('captcha') }}</span>
                        <div class="input-group mt-3">
                            <input id="captcha" type="text" class="form-control" placeholder="Enter Captcha"
                                name="captcha">

                        </div>
                        <div class="col-4 mt-3">
                            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                        </div>
                        <!-- /.col -->
                </form>

                {{-- <div class="social-auth-links text-center mb-3">
<p>- OR -</p>
<a href="#" class="btn btn-block btn-primary">
<i class="fab fa-facebook mr-2"></i> Sign in using Facebook
</a>
<a href="#" class="btn btn-block btn-danger">
<i class="fab fa-google-plus mr-2"></i> Sign in using Google+
</a>
</div> --}}
                <!-- /.social-auth-links -->

                <p class="mt-3">
                    <a href="#">I forgot my password</a>
                </p>
                {{-- <p class="mb-0">
<a href="register.html" class="text-center">Register a new membership</a>
</p> --}}
            </div>
            <!-- /.login-card-body -->
        </div>
    </div>
    <!-- /.login-box -->

    <!-- jQuery -->
    <script src="{{ asset('backend/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('backend/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('backend/dist/js/adminlte.min.js') }}"></script>
    <script type="text/javascript">
        $('#reload').click(function() {
            reloadCaptcha();
        });

        function reloadCaptcha() {
            $.ajax({
                type: 'GET',
                url: '{{ route('reload.captcha') }}',
                success: function(data) {
                    $(".captcha span").html(data.captcha);
                }
            });
        }
    </script>
</body>

</html>
