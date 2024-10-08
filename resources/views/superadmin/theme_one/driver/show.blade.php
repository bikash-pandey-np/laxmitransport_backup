@extends($theme_path.'common.layout')

@section('content')

    <section class="pb-0" style="margin-bottom: 40px;">
        <div class="container-fluid">
            <div class="row gy-4">
                <!-- Client Profile -->
                <div class="col-lg-3">
                    <div class="card mb-0">
                        <style>
                            .nav-item {
                                width: 100%;
                                text-align: left;
                            }

                            .nav-item a:hover {
                                color: #999999;
                            }

                            .nav-item a {
                                padding: 5px;
                                font-size: 14px;
                                color: #000;
                            }
                        </style>
                        <div class="card-body text-center">
                            <div class="client-avatar mb-3"><img
                                        class="img-fluid img-fluid-h100 rounded-circle shadow-0"
                                        src="{{ $row->image('300_300') }}" alt="...">
                                <div class="status bg-green"></div>
                            </div>
                            <h3 class="fw-normal">{{ $row->first_name.' '.$row->last_name }}</h3>
                            <p class="text-sm text-gray-500 mb-1">Driver</p><br>
                            {{--<ul class="nav">
                                <li class="nav-item"><a href="{{ route('super_admin.profile.edit') }}">Profile Update</a></li>
                                <li class="nav-item"><a href="{{ route('super_admin.profile.picture.edit') }}">Change Profile Picture</a></li>
                                <li class="nav-item"><a href="{{ route('super_admin.change.password') }}">Change Password</a></li>
                            </ul>--}}
                        </div>
                    </div>
                </div>
                <!-- Total Overdue             -->
                <div class="col-lg-9">
                    <div class="card mb-0">
                        <div class="card-body d-flex flex-column">
                            <h3>{{ $row->first_name.' '.$row->last_name }}</h3>
                            <table class="table">
                                <tbody>
                                @foreach(config('form.driver') as $key => $value)
                                    @continue(in_array($key,['city','state','zip']))
                                    <tr>
                                        <th>{{ ucfirst(str_replace('_',' ',$key)) }}</th>
                                        <td>{{ $row->{$key} }}</td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <th>{{ ucfirst(str_replace('_',' ','account_status')) }}</th>
                                    <td>{{ $row->account_status }}</td>
                                </tr>
                                @if($row->account_status == 'deactive')
                                    <tr>
                                        <th>{{ ucfirst(str_replace('_',' ','deactive_reason')) }}</th>
                                        <td>{{ $row->deactive_reason }}</td>
                                    </tr>
                                @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
