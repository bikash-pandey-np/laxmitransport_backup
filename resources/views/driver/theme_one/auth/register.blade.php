
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ config('app.name') }}</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="robots" content="all,follow">
    <link rel="stylesheet" href="../../fonts.googleapis.com/css49c3.css?family=Poppins:300,400,700">
    <link rel="stylesheet" href="{{ asset("themes/prabin_dashboard/vendor/choices.js/public/assets/styles/choices.min.css") }}">
    <link rel="stylesheet" href="{{ asset("themes/prabin_dashboard/css/style.default.css") }}" id="theme-stylesheet">
    <link rel="stylesheet" href="{{ asset("themes/prabin_dashboard/css/custom.css") }}">
    <link rel="shortcut icon" href="{{ asset('images/favicon.png') }}">
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->
</head>
<body>
<div class="login-page">
    <div class="container d-flex align-items-center position-relative py-5">
        <div class="card shadow-sm w-100 rounded overflow-hidden bg-none">
            <div class="card-body p-0">
                <div class="row gx-0 align-items-stretch">
                    <div class="col-lg-6">
                        <div class="info d-flex justify-content-center flex-column p-4 h-100">
                            <div class="py-5">
                                <h1 class="display-6 fw-bold" STYLE="background:none;border: none;">{{ config('app.name') }}</h1>
                                <p class="fw-light mb-0">Driver Register</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 bg-white">
                        <div class="d-flex align-items-center px-4 px-lg-5 h-100">
                            <form class="register-form py-5 w-100" method="post" action="{{ route('driver.register') }}" novalidate="novalidate">
                                @csrf
                                <div class="input-material-group mb-3">
                                    <input class="input-material" id="first_name" type="text" name="first_name" required="" data-validate-field="registerUsername">
                                    @if($errors->has('first_name'))
                                        <div class="js-validate-error-label" style="color: #B81111">{{ $errors->first('first_name') }}</div>
                                    @else
                                        <label class="label-material" for="first_name">First Name</label>
                                    @endif
                                </div>
                                <div class="input-material-group mb-4">
                                    <input class="input-material" id="last_name" type="text" name="last_name" required="" data-validate-field="registerPassword">
                                    @if($errors->has('last_name'))
                                        <div class="js-validate-error-label" style="color: #B81111">{{ $errors->first('last_name') }}</div>
                                    @else
                                        <label class="label-material" for="last_name">Last Name</label>
                                    @endif
                                </div>
                                <div class="input-material-group mb-3">
                                    <input class="input-material" id="email" type="email" name="email" required="" data-validate-field="registerEmail">
                                    @if($errors->has('email'))
                                        <div class="js-validate-error-label" style="color: #B81111">{{ $errors->first('email') }}</div>
                                    @else
                                        <label class="label-material" for="email">Email</label>
                                    @endif
                                </div>
                                <div class="input-material-group mb-3">
                                    <input class="input-material" id="mobile_number" type="text" name="mobile_number" required="">
                                    @if($errors->has('mobile_number'))
                                        <div class="js-validate-error-label" style="color: #B81111">{{ $errors->first('mobile_number') }}</div>
                                    @else
                                        <label class="label-material" for="mobile_number">Mobile Number</label>
                                    @endif
                                </div>
                                <div class="input-material-group mb-4">
                                    <input class="input-material" id="password" type="password" name="password" required="" data-validate-field="registerPassword">
                                    @if($errors->has('password'))
                                        <div class="js-validate-error-label" style="color: #B81111">{{ $errors->first('password') }}</div>
                                    @else
                                        <label class="label-material" for="password">Password</label>
                                    @endif
                                </div>
                                <button class="btn btn-primary mb-3" id="login" type="submit">Register</button><br><small class="text-gray-500">Already have an account?  </small><a class="text-sm text-paleBlue" href="{{ route('driver.login_form') }}">Login</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="text-center position-absolute bottom-0 start-0 w-100 z-index-20">
{{--        <p class="text-white">Develop by <a class="external" href="http://santoshdheke.com.np/" target="_blank">Santosh Dheke</a>--}}
{{--        </p>--}}
    </div>
</div>
<script src="{{ asset('themes/prabin_dashboard/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('themes/prabin_dashboard/vendor/chart.js/Chart.min.js') }}"></script>
<script src="{{ asset('themes/prabin_dashboard/vendor/just-validate/js/just-validate.min.js') }}"></script>
<script src="{{ asset('themes/prabin_dashboard/vendor/choices.js/public/assets/scripts/choices.min.js') }}"></script>
<script src="{{ asset('themes/prabin_dashboard/js/front.js') }}"></script>
<script>
    function injectSvgSprite(path) {

        var ajax = new XMLHttpRequest();
        ajax.open("GET.html", path, true);
        ajax.send();
        ajax.onload = function(e) {
            var div = document.createElement("div");
            div.className = 'd-none';
            div.innerHTML = ajax.responseText;
            document.body.insertBefore(div, document.body.childNodes[0]);
        }
    }
    injectSvgSprite('../../bootstraptemple.com/files/icons/orion-svg-sprite.svg');


</script>
<link rel="stylesheet" href="../../use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
</body>

</html>
