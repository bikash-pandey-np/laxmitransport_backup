
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
                                <p class="fw-light mb-0">Carrier Register</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 bg-white">
                        <div class="d-flex align-items-center px-4 px-lg-5 h-100">
                            <form class="register-form py-5 w-100" method="post" action="{{ route('carrier.register') }}" novalidate="novalidate">
                                @csrf
                                <div class="input-material-group mb-3">
                                    <input class="input-material" id="name" type="text" name="name" required="" data-validate-field="registerUsername">
                                    @if($errors->has('name'))
                                        <div class="js-validate-error-label" style="color: #B81111">{{ $errors->first('name') }}</div>
                                    @else
                                        <label class="label-material" for="name">Name</label>
                                    @endif
                                </div>
                                <div class="input-material-group mb-3">
                                    <input class="input-material" id="business_address" type="text" name="business_address" required="" data-validate-field="registerUserbusiness_address">
                                    @if($errors->has('business_address'))
                                        <div class="js-validate-error-label" style="color: #B81111">{{ $errors->first('business_address') }}</div>
                                    @else
                                        <label class="label-material" for="business_address">Business Address</label>
                                    @endif
                                </div>
                                <div class="input-material-group mb-3">
                                    <input class="input-material" id="city_st_zip" type="text" name="city_st_zip" required="" data-validate-field="registerUsercity_st_zip">
                                    @if($errors->has('city_st_zip'))
                                        <div class="js-validate-error-label" style="color: #B81111">{{ $errors->first('city_st_zip') }}</div>
                                    @else
                                        <label class="label-material" for="city_st_zip">City St Zip</label>
                                    @endif
                                </div>
                                <div class="input-material-group mb-3">
                                    <input class="input-material" id="phone_number" type="text" name="phone_number" required="" data-validate-field="registerUserphone_number">
                                    @if($errors->has('phone_number'))
                                        <div class="js-validate-error-label" style="color: #B81111">{{ $errors->first('phone_number') }}</div>
                                    @else
                                        <label class="label-material" for="phone_number">Phone Number</label>
                                    @endif
                                </div>
                                <div class="input-material-group mb-3">
                                    <input class="input-material" id="ext" type="text" name="ext" required="" data-validate-field="registerUserext">
                                    @if($errors->has('ext'))
                                        <div class="js-validate-error-label" style="color: #B81111">{{ $errors->first('ext') }}</div>
                                    @else
                                        <label class="label-material" for="ext">ext</label>
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
                                    <input class="input-material" id="usdot" type="text" name="usdot" required="" data-validate-field="registerUserusdot">
                                    @if($errors->has('usdot'))
                                        <div class="js-validate-error-label" style="color: #B81111">{{ $errors->first('usdot') }}</div>
                                    @else
                                        <label class="label-material" for="usdot">usdot</label>
                                    @endif
                                </div>
                                <div class="input-material-group mb-3">
                                    <input class="input-material" id="broker_mc" type="text" name="broker_mc" required="" data-validate-field="registerUserbroker_mc">
                                    @if($errors->has('broker_mc'))
                                        <div class="js-validate-error-label" style="color: #B81111">{{ $errors->first('broker_mc') }}</div>
                                    @else
                                        <label class="label-material" for="broker_mc">Broker Mc</label>
                                    @endif
                                </div>
                                <div class="input-material-group mb-3">
                                    <input class="input-material" id="dispatch_name" type="text" name="dispatch_name" required="">
                                    @if($errors->has('dispatch_name'))
                                        <div class="js-validate-error-label" style="color: #B81111">{{ $errors->first('dispatch_name') }}</div>
                                    @else
                                        <label class="label-material" for="dispatch_name">Dispatch Name</label>
                                    @endif
                                </div>
                                <div class="input-material-group mb-3">
                                    <input class="input-material" id="dispatch_phone_number" type="text" name="dispatch_phone_number" required="">
                                    @if($errors->has('dispatch_phone_number'))
                                        <div class="js-validate-error-label" style="color: #B81111">{{ $errors->first('dispatch_phone_number') }}</div>
                                    @else
                                        <label class="label-material" for="dispatch_phone_number">Dispatch Phone Number</label>
                                    @endif
                                </div>
                                <div class="input-material-group mb-3">
                                    <input class="input-material" id="dispatch_email" type="text" name="dispatch_email" required="">
                                    @if($errors->has('dispatch_email'))
                                        <div class="js-validate-error-label" style="color: #B81111">{{ $errors->first('dispatch_email') }}</div>
                                    @else
                                        <label class="label-material" for="dispatch_email">Dispatch Email</label>
                                    @endif
                                </div>
                                <div class="input-material-group mb-3">
                                    <input class="input-material" id="insurance_name" type="text" name="insurance_name" required="">
                                    @if($errors->has('insurance_name'))
                                        <div class="js-validate-error-label" style="color: #B81111">{{ $errors->first('insurance_name') }}</div>
                                    @else
                                        <label class="label-material" for="insurance_name">Insurance Name</label>
                                    @endif
                                </div>
                                <div class="input-material-group mb-3">
                                    <input class="input-material" id="policy_number" type="text" name="policy_number" required="">
                                    @if($errors->has('policy_number'))
                                        <div class="js-validate-error-label" style="color: #B81111">{{ $errors->first('policy_number') }}</div>
                                    @else
                                        <label class="label-material" for="policy_number">Policy Number</label>
                                    @endif
                                </div>
                                <div class="input-material-group mb-3">
                                    <input class="input-material" id="policy_effective_date" type="text" name="policy_effective_date" required="">
                                    @if($errors->has('policy_effective_date'))
                                        <div class="js-validate-error-label" style="color: #B81111">{{ $errors->first('policy_effective_date') }}</div>
                                    @else
                                        <label class="label-material" for="policy_effective_date">Policy Effective Date</label>
                                    @endif
                                </div>
                                <div class="input-material-group mb-3">
                                    <input class="input-material" id="policy_expire_date" type="text" name="policy_expire_date" required="">
                                    @if($errors->has('policy_expire_date'))
                                        <div class="js-validate-error-label" style="color: #B81111">{{ $errors->first('policy_expire_date') }}</div>
                                    @else
                                        <label class="label-material" for="policy_expire_date">Policy Expire Date</label>
                                    @endif
                                </div>
                                <div class="input-material-group mb-3">
                                    <input class="input-material" id="coi" type="text" name="coi" required="">
                                    @if($errors->has('coi'))
                                        <div class="js-validate-error-label" style="color: #B81111">{{ $errors->first('coi') }}</div>
                                    @else
                                        <label class="label-material" for="coi">Policy Expire Date</label>
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
                                <button class="btn btn-primary mb-3" id="login" type="submit">Register</button><br><small class="text-gray-500">Already have an account?  </small><a class="text-sm text-paleBlue" href="{{ route('carrier.login_form') }}">Login</a>
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
