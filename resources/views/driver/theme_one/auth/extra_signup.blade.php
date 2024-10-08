
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
                                <p class="fw-light mb-0">Driver Registration Complete</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 bg-white">
                        <div class="d-flex align-items-center px-4 px-lg-5 h-100">
                            <form class="register-form py-5 w-100" method="post" action="{{ route('driver.extra_signup.post') }}" novalidate="novalidate">
                                @csrf
                                <div class="input-material-group mb-3">
                                    <input class="input-material" id="address_one" type="text" name="address_one">
                                    @if($errors->has('address_one'))
                                        <div class="js-validate-error-label" style="color: #B81111">{{ $errors->first('address_one') }}</div>
                                    @else
                                        <label class="label-material" for="address_one">Address</label>
                                    @endif
                                </div>
                                <div class="input-material-group mb-4">
                                    <input class="input-material" id="city" type="text" name="city">
                                    @if($errors->has('city'))
                                        <div class="js-validate-error-label" style="color: #B81111">{{ $errors->first('city') }}</div>
                                    @else
                                        <label class="label-material" for="city">City</label>
                                    @endif
                                </div>
                                <div class="input-material-group mb-3">
                                    <input class="input-material" id="state" type="text" name="state">
                                    @if($errors->has('state'))
                                        <div class="js-validate-error-label" style="color: #B81111">{{ $errors->first('state') }}</div>
                                    @else
                                        <label class="label-material" for="state">State</label>
                                    @endif
                                </div>
                                <div class="input-material-group mb-3">
                                    <input class="input-material datepicker" id="date_of_birth" type="text" name="date_of_birth">
                                    @if($errors->has('date_of_birth'))
                                        <div class="js-validate-error-label" style="color: #B81111">{{ $errors->first('date_of_birth') }}</div>
                                    @else
                                        <label class="label-material" for="date_of_birth">Date Of Birth</label>
                                    @endif
                                </div>
                                <div class="input-material-group mb-3">
                                    <input class="input-material" id="emergency_contact" type="text" name="emergency_contact">
                                    @if($errors->has('emergency_contact'))
                                        <div class="js-validate-error-label" style="color: #B81111">{{ $errors->first('emergency_contact') }}</div>
                                    @else
                                        <label class="label-material" for="emergency_contact">Emergency contact</label>
                                    @endif
                                </div>
                                <div class="input-material-group mb-3">
                                    <input class="input-material" id="license_number" type="text" name="license_number">
                                    @if($errors->has('license_number'))
                                        <div class="js-validate-error-label" style="color: #B81111">{{ $errors->first('license_number') }}</div>
                                    @else
                                        <label class="label-material" for="license_number">License number</label>
                                    @endif
                                </div>
                                <div class="input-material-group mb-3">
                                    <input class="input-material" id="license_state" type="text" name="license_state">
                                    @if($errors->has('license_state'))
                                        <div class="js-validate-error-label" style="color: #B81111">{{ $errors->first('license_state') }}</div>
                                    @else
                                        <label class="label-material" for="license_state">License state</label>
                                    @endif
                                </div>
                                <div class="input-material-group mb-3">
                                    <input class="input-material" id="social_security_number" type="text" name="social_security_number">
                                    @if($errors->has('social_security_number'))
                                        <div class="js-validate-error-label" style="color: #B81111">{{ $errors->first('social_security_number') }}</div>
                                    @else
                                        <label class="label-material" for="social_security_number">Social security number</label>
                                    @endif
                                </div>
                                <div class="input-material-group mb-3">
                                    <input class="input-material" id="license_class" type="text" name="license_class">
                                    @if($errors->has('license_class'))
                                        <div class="js-validate-error-label" style="color: #B81111">{{ $errors->first('license_class') }}</div>
                                    @else
                                        <label class="label-material" for="license_class">Licence class</label>
                                    @endif
                                </div>
                                <div class="input-material-group mb-3">
                                    <input class="input-material" id="billed_mileage_type" type="text" name="billed_mileage_type">
                                    @if($errors->has('billed_mileage_type'))
                                        <div class="js-validate-error-label" style="color: #B81111">{{ $errors->first('billed_mileage_type') }}</div>
                                    @else
                                        <label class="label-material" for="billed_mileage_type">odometer mileage type</label>
                                    @endif
                                </div>
                                <button class="btn btn-primary mb-3" id="login" type="submit">Submit</button><br><small class="text-gray-500">Do you want to Logout?  </small>
                                <a class="text-sm text-paleBlue" id="logout_button" href="javascript:void(0)" style="border: none;background: #ffffff;" onclick="$('#logout').submit()">Logout</a>
                            </form>
                            <form action="{{ route('driver.logout') }}" id="logout" method="post">
                                @csrf
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
<script>
    var form = document.getElementById("logout");

    document.getElementById("logout_button").addEventListener("click", function () {
        form.submit();
    });
</script>

@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"
            integrity="sha512-T/tUfKSV1bihCnd+MxKD0Hm1uBBroVYBOYSk1knyvQ9VyZJpc/ALb4P0r6ubwVPSGB2GvjeoMAJJImBG12TiaQ=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css"
          integrity="sha512-mSYUmp1HYZDFaVKK//63EcZq4iFWFjxSL+Z3T/aCt4IO9Cejm03q3NKKYN6pFQzY0SBOr8h+eCIAZHPXcpZaNw=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <script>
        $('.datepicker').datepicker({
            format: 'mm/dd/yyyy'
        });
    </script>
@endpush

</body>

</html>
