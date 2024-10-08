@extends($theme_path.'common.layout')

@section('content')

    <section class="pb-0" style="margin-bottom: 40px;">
        <div class="container-fluid">
            <div class="row gy-4">
                <!-- Client Profile -->
                <div class="col-lg-3">
                    <div class="card mb-0">
                            <style>
                                .nav-items{
                                    width: 100%;
                                    text-align: left;
                                }
                                .nav-items a:hover{
                                    color: #999999;
                                }
                                .nav-items a{
                                    padding: 5px;
                                    font-size: 14px;
                                    color: #000;
                                }
                            </style>
                            <div class="card-body text-center">
                                <div class="client-avatar mb-3"><img class="img-fluid img-fluid-h100 rounded-circle shadow-0" src="{{ $auth->image('300_300') }}" alt="...">
                                    <div class="status bg-green"></div>
                                </div>
                                <h3 class="fw-normal">{{ $auth->first_name.' '.$auth->last_name }}</h3>
                                <p class="text-sm text-gray-500 mb-1">Superadmin</p><br>
                                <ul class="nav">
                                    <li class="nav-items nav-item"><a href="{{ route('super_admin.profile.edit') }}">Profile Update</a></li>
                                    <li class="nav-items nav-item"><a href="{{ route('super_admin.profile.picture.edit') }}">Change Profile Picture</a></li>
                                    <li class="nav-items nav-item"><a href="{{ route('super_admin.change.password') }}">Change Password</a></li>
                                </ul>
                            </div>
                    </div>
                </div>
                <!-- Total Overdue             -->
                <div class="col-lg-9">
                    @yield('profile')
                </div>
            </div>
        </div>
    </section>

@endsection