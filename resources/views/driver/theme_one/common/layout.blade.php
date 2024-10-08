<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ config('app.name') }}</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="robots" content="all,follow">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,700">
    <link rel="stylesheet"
          href="{{ asset('themes/prabin_dashboard/vendor/choices.js/public/assets/styles/choices.min.css') }}">
    <link rel="stylesheet" id="theme-stylesheet" href="{{ asset('themes/prabin_dashboard/css/style.default.css') }}">
    <link rel="stylesheet" href="{{ asset('themes/prabin_dashboard/css/custom.css') }}">
    <link rel="shortcut icon" href="{{ asset('images/favicon.png') }}">
    <style>
        .active_sidebar {
            color: #fff;
            border-left: 4px solid #3b25e6;
            background: #796AEE !important;
        }
    </style>
</head>
<body>
<div class="page">

    <audio src=""></audio>

    <header class="header z-index-50">
        <nav class="navbar py-3 px-0 shadow-sm text-white position-relative">
            <div class="search-box shadow-sm">
                <button class="dismiss d-flex align-items-center">
                    <svg class="svg-icon svg-icon-heavy">
                        <use xlink:href="#close-1"></use>
                    </svg>
                </button>
                <form id="searchForm" action="{{ route('driver.search.index') }}" role="search">
                    <input class="form-control shadow-0" type="text" name="q" placeholder="What are you looking for...">
                </form>
            </div>
            <div class="container-fluid w-100">
                <div class="navbar-holder d-flex align-items-center justify-content-between w-100">
                    <div class="navbar-header">
                        <a class="navbar-brand d-none d-sm-inline-block" href="{{ route('driver.index') }}">
                            <div class="brand-text d-none d-lg-inline-block">
                                <span>{{ config('app.name') }} </span><strong></strong></div>
                        </a>
                        <a class="menu-btn active" id="toggle-btn" href="#"><span></span><span></span><span></span></a>
                        {{ $time }}

                        <style>
                            .dropdown {
                                position: relative;
                                display: inline-block;
                            }

                            .dropdown-content {
                                display: none;
                                position: absolute;
                                background-color: #2f333e;
                                min-width: 160px;
                                box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
                                padding: 12px 16px;
                                z-index: 1;
                            }

                            .dropdown:hover .dropdown-content {
                                display: block;
                            }

                            .choose_timezone:hover{
                                text-decoration: underline;
                            }
                        </style>

                        <div class="dropdown">
                            <span style="border: 1px solid #ffffff;padding: 5px 10px;margin-left: 20px">{{ config('timezone.all')[session('timezone') ?? config('app.timezone')] }}</span>
                            <div class="dropdown-content">
                                <a class="choose_timezone" href="{{ route('super_admin.change.timezone','pacific') }}">PST</a><br>
                                <a class="choose_timezone" href="{{ route('super_admin.change.timezone','mountain') }}">MST</a><br>
                                <a class="choose_timezone" href="{{ route('super_admin.change.timezone','central') }}">CST</a><br>
                                <a class="choose_timezone" href="{{ route('super_admin.change.timezone','eastern') }}">EST</a><br>
                                <a class="choose_timezone" href="{{ route('super_admin.change.timezone','kathmandu') }}">Nepal</a>
                            </div>
                        </div>

                    </div>
                    <ul class="nav-menu list-unstyled d-flex flex-md-row align-items-md-center">
                        <li class="nav-item d-flex align-items-center"><a id="search" href="#">
                                <svg class="svg-icon svg-icon-xs svg-icon-heavy">
                                    <use xlink:href="#find-1"></use>
                                </svg>
                            </a></li>
                        <li class="nav-item dropdown"><a class="nav-link text-white" id="notifications" href="#"
                                                         data-bs-toggle="dropdown" aria-expanded="false">
                                <svg class="svg-icon svg-icon-xs svg-icon-heavy">
                                    <use xlink:href="#chart-1"></use>
                                </svg>
                                <span class="badge bg-red badge-corner fw-normal">12</span></a>
                            <ul class="dropdown-menu dropdown-menu-end mt-3 shadow-sm" aria-labelledby="notifications">
                                <li><a class="dropdown-item py-3" href="#">
                                        <div class="d-flex">
                                            <div class="icon icon-sm bg-blue">
                                                <svg class="svg-icon svg-icon-xs svg-icon-heavy">
                                                    <use xlink:href="#envelope-1"></use>
                                                </svg>
                                            </div>
                                            <div class="ms-3"><span
                                                        class="h6 d-block fw-normal mb-1 text-xs text-gray-600">You have 6 new messages </span>
                                                <small class="small text-gray-600">4 minutes ago</small>
                                            </div>
                                        </div>
                                    </a></li>
                                <li><a class="dropdown-item py-3" href="#">
                                        <div class="d-flex">
                                            <div class="icon icon-sm bg-green">
                                                <svg class="svg-icon svg-icon-xs svg-icon-heavy">
                                                    <use xlink:href="#chats-1"></use>
                                                </svg>
                                            </div>
                                            <div class="ms-3"><span
                                                        class="h6 d-block fw-normal mb-1 text-xs text-gray-600">New 2 WhatsApp messages</span>
                                                <small class="small text-gray-600">4 minutes ago</small>
                                            </div>
                                        </div>
                                    </a></li>
                                <li><a class="dropdown-item py-3" href="#">
                                        <div class="d-flex">
                                            <div class="icon icon-sm bg-orange">
                                                <svg class="svg-icon svg-icon-xs svg-icon-heavy">
                                                    <use xlink:href="#checked-window-1"></use>
                                                </svg>
                                            </div>
                                            <div class="ms-3"><span
                                                        class="h6 d-block fw-normal mb-1 text-xs text-gray-600">Server Rebooted</span>
                                                <small class="small text-gray-600">8 minutes ago</small>
                                            </div>
                                        </div>
                                    </a></li>
                                <li><a class="dropdown-item py-3" href="#">
                                        <div class="d-flex">
                                            <div class="icon icon-sm bg-green">
                                                <svg class="svg-icon svg-icon-xs svg-icon-heavy">
                                                    <use xlink:href="#chats-1"></use>
                                                </svg>
                                            </div>
                                            <div class="ms-3"><span
                                                        class="h6 d-block fw-normal mb-1 text-xs text-gray-600">New 2 WhatsApp messages</span>
                                                <small class="small text-gray-600">10 minutes ago</small>
                                            </div>
                                        </div>
                                    </a></li>
                                <li><a class="dropdown-item all-notifications text-center"
                                       href="{{ route('driver.notification.index') }}"> <strong
                                                class="text-xs text-gray-600">view all notifications </strong></a></li>
                            </ul>
                        </li>

                        <li class="nav-item dropdown"><a class="nav-link text-white" id="messages" rel="nofollow"
                                                         href="{{ route('driver.chat.index') }}">
                                <svg class="svg-icon svg-icon-xs svg-icon-heavy">
                                    <use xlink:href="#envelope-1"></use>
                                </svg>
                                <span class="badge bg-orange badge-corner fw-normal">10</span></a>
                        </li>

                        <li class="nav-item">
                            <form action="{{ route('driver.logout') }}" method="post" id="logout_form">
                                <button class="nav-link text-white" style="background: #2f333e;border: none;"
                                        type="submit">
                                    <span class="d-none d-sm-inline">Logout</span>
                                    <svg class="svg-icon svg-icon-xs svg-icon-heavy">
                                        <use xlink:href="#security-1"></use>
                                    </svg>
                                </button>
                                @csrf
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <div class="page-content d-flex align-items-stretch">
        <nav class="side-navbar z-index-40">
            <div class="sidebar-header d-flex align-items-center py-4 px-3">
                <a href="{{ route('driver.profile.index') }}">
                    <img class="avatar shadow-0 img-fluid rounded-circle"
                         src="{{ $auth->image('300_300') }}" alt="...">
                </a>
                <div class="ms-3 title">
                    <h1 class="h4 mb-2">{{ $auth->full_name }} ({{ $auth->unit_number }})</h1>
                    <p class="text-sm text-gray-500 fw-light mb-0 lh-1">Driver</p>
                </div>
            </div>
            <ul class="chat-list list-unstyled py-4">
                @if (View::hasSection('sidebar'))
                    @yield('sidebar')
                @else
                    @include($theme_path.'common.sidebars.sidebar')
                @endif
            </ul>
        </nav>
        <div class="content-inner w-100">

            <div class="bg-white">
                <div class="container-fluid">

                    @if (View::hasSection('breadcrumb'))
                        @yield('breadcrumb')
                    @else
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0 py-3">
                                <li class="breadcrumb-item"><a class="fw-light" href="{{ route('driver.index') }}">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item"><a class="fw-light"
                                                               href="{{ route($base_route.'index') }}">{{ $title ?? 'Title' }}</a>
                                </li>
                                <li class="breadcrumb-item active fw-light" aria-current="page">List</li>
                            </ol>
                        </nav>
                    @endif
                </div>
            </div>

            <style>
                .alert-wranning {
                    background-color: #faffcb;
                    color: #ffca14;
                    margin: 30px 30px 0 30px;
                    padding: 10px 15px;
                    border-radius: 5px;
                }

                .minimiz:hover {
                    color: #ffca14;
                    text-decoration: underline;
                }

                .minimiz {
                    float: right;
                    color: #ffca14;
                }
            </style>

            {{--@if(!Request::is('driver/chat/*'))
                @if($auth->status == 0)
                    <div class="alert-wranning">Please verify your email. <a href="javascript:void(0)"
                                                                             class="minimiz">X</a></div>
                @endif

                @if($auth->license_number == null)
                    <div class="alert-wranning">Please update your profile. <a href="" style="color: #ffca14;"><b
                                    style="text-decoration: underline">Here</b></a> <a href="javascript:void(0)"
                                                                                       class="minimiz">X</a></div>
                @endif
            @endif--}}

            @yield('content')

            @if (View::hasSection('footer'))
                @yield('footer')
            @else
                <footer class="position-absolute bottom-0 bg-darkBlue text-white text-center py-3 w-100 text-xs"
                        id="footer">
                    <div class="container-fluid">
                        <div class="row gy-2">
                            <div class="col-sm-6 text-sm-start">
                                <p class="mb-0">{{ config('app.name') }} &copy; {{ date('Y') }}</p>
                            </div>
                            <div class="col-sm-6 text-sm-end">
<!--                                <p class="mb-0">Develop by <a href="http://santoshdheke.com.np/" target="_blank"
                                                              class="text-white text-decoration-none">Santosh Dheke</a>
                                </p>-->
                            </div>
                        </div>
                    </div>
                </footer>
            @endif
        </div>
    </div>
</div>
<script src="{{ mix('/js/app.js') }}"></script>
<script src="{{ asset('themes/prabin_dashboard/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('themes/prabin_dashboard/vendor/chart.js/Chart.min.js') }}"></script>
<script src="{{ asset('themes/prabin_dashboard/vendor/just-validate/js/just-validate.min.js') }}"></script>
<script src="{{ asset('themes/prabin_dashboard/vendor/choices.js/public/assets/scripts/choices.min.js') }}"></script>
<script src="{{ asset('themes/prabin_dashboard/js/front.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"
        integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@if(session('success'))
    <script>
        Swal.fire(
            'Success',
            '{{ session('success') }}',
            'success'
        )
    </script>
@endif

<script>
    $(document).on('click', '.clickBtn', function () {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) = > {
            if(result.isConfirmed
    )
        {
            var id = $(this).data('id');
            $('#' + id).submit();

        }
    })
    });
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/3.0.5/socket.io.min.js"></script>

<script>
    var socket = io.connect('https://node.tms720.com/');
</script>

@stack('js')

<script>

    function injectSvgSprite(path) {

        var ajax = new XMLHttpRequest();
        ajax.open("GET", path, true);
        ajax.send();
        ajax.onload = function (e) {
            var div = document.createElement("div");
            div.className = 'd-none';
            div.innerHTML = ajax.responseText;
            document.body.insertBefore(div, document.body.childNodes[0]);
        }
    }

    injectSvgSprite('https://bootstraptemple.com/files/icons/orion-svg-sprite.svg');

    $('.minimiz').click(function () {
        $(this).parent().remove();
    });

</script>

<script>

    $(document).ready(function(){
        setInterval(function(){
            getLocation();
        },60000);
    });

    function getLocation() {
        if (navigator.geolocation) {
            var test = navigator.geolocation.getCurrentPosition(requestSend);
        }else{
            alert('location fail');
        }
    }

    function requestSend(position) {
        var lat = position.coords.latitude;
        var long = position.coords.longitude;

        {{--$.post("location/store",{--}}
        {{--    '_token': "{{ csrf_token() }}",--}}
        {{--    'lat': lat,--}}
        {{--    'long': long--}}
        {{--},function(){--}}

        {{--});--}}
    }
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js" integrity="sha512-T/tUfKSV1bihCnd+MxKD0Hm1uBBroVYBOYSk1knyvQ9VyZJpc/ALb4P0r6ubwVPSGB2GvjeoMAJJImBG12TiaQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" integrity="sha512-mSYUmp1HYZDFaVKK//63EcZq4iFWFjxSL+Z3T/aCt4IO9Cejm03q3NKKYN6pFQzY0SBOr8h+eCIAZHPXcpZaNw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<script>
    $('.datepicker').datepicker({
        format: 'mm/dd/yyyy'
    });
</script>

<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
<link href="{{ asset('css/bootstrap.css') }}" rel="stylesheet">
{{--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>--}}
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>

<script>
    $('#time').datetimepicker({
        format: 'HH:mm'
    });
</script>
</body>
</html>
