@extends($theme_path.'common.layout')

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0 py-3">
            <li class="breadcrumb-item"><a class="fw-light" href="{{ route('driver.index') }}">Dashboard</a>
            </li>
            <li class="breadcrumb-item active fw-light" aria-current="page">Show</li>
        </ol>
    </nav>
    @endsection

@section('content')

    <section class="pb-0" style="margin-bottom: 40px;">
        <div class="container-fluid">
            <div class="row gy-4">
                <!-- Client Profile -->
                <div class="col-lg-3">
                    <div class="card mb-0">
                        <style>
                            .nav-item{
                                width: 100%;
                                text-align: left;
                            }
                            .nav-item a:hover{
                                color: #999999;
                            }
                            .nav-item a{
                                padding: 5px;
                                font-size: 14px;
                                color: #000;
                            }
                        </style>
                        <div class="card-body text-center">
                            <div class="client-avatar mb-3"><img class="img-fluid img-fluid-h100 rounded-circle shadow-0" src="{{ $row->image('300_300') }}" alt="...">
                                <div class="status bg-green"></div>
                            </div>
                            <h3 class="fw-normal">{{ $row->first_name.' '.$row->last_name }}</h3>
                            <p class="text-sm text-gray-500 mb-1">Driver</p><br>
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
                                    <tr>
                                        <th>{{ ucfirst(str_replace('_',' ','first_name')) }}</th>
                                        <td>{{ $row->first_name }}</td>
                                    </tr>
                                    <tr>
                                        <th>{{ ucfirst(str_replace('_',' ','last_name')) }}</th>
                                        <td>{{ $row->last_name }}</td>
                                    </tr>
                                    <tr>
                                        <th>{{ ucfirst(str_replace('_',' ','email')) }}</th>
                                        <td>{{ $row->email }}</td>
                                    </tr>
                                    </tbody>
                                </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection