@extends($theme_path.'common.layout')

@section('content')

    <section class="pb-0" style="margin-bottom: 40px;">
        <div class="container-fluid">
            <div class="row gy-4">
                <!-- Total Overdue             -->
                <div class="col-lg-12">
                    <nav>
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab"
                                    data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home"
                                    aria-selected="true">Basic detail
                            </button>
                            <button class="nav-link" id="nav-home-tab-two" data-bs-toggle="tab"
                                    data-bs-target="#nav-home-two" type="button" role="tab" aria-controls="nav-home"
                                    aria-selected="true">Locations
                            </button>
                            <button class="nav-link" id="nav-home-tab-two" data-bs-toggle="tab"
                                    data-bs-target="#biding" type="button" role="tab" aria-controls="nav-home"
                                    aria-selected="true">Bids
                            </button>
                            @if($row->status == 'delivery' || $row->status == 'picked_up' || ($row->status == 'on_site' && $row->admin_status_approved == 0))
                                <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab"
                                        data-bs-target="#nav-profile" type="button" role="tab"
                                        aria-controls="nav-profile" aria-selected="false">Picked up detail
                                </button>
                            @endif
                            @if($row->status == 'delivery' || ($row->status == 'picked_up' && $row->admin_status_approved == 0))
                                <button class="nav-link" id="nav-contact-tab" data-bs-toggle="tab"
                                        data-bs-target="#nav-contact" type="button" role="tab"
                                        aria-controls="nav-contact" aria-selected="false">Delivery detail
                                </button>
                            @endif
                        </div>
                    </nav>
                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="nav-home" role="tabpanel"
                             aria-labelledby="nav-home-tab">
                            <div class="card mb-0">
                                <div class="card-body d-flex flex-column">
                                    <h3>{{ $row->first_name.' '.$row->last_name }}</h3>
                                    <table class="table">
                                        <tbody>
                                        @php($darr = config('form.work'))
                                        @if(isset($darr) && is_array($darr) && count($darr) > 0)
                                            @foreach($darr as $key => $value)
                                                <tr>
                                                    <th>{{ ucfirst(str_replace('_',' ',$key)) }}</th>
                                                    <td>{{ $row->{$key} }}</td>
                                                </tr>
                                            @endforeach
                                        @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="nav-home-two" role="tabpanel" aria-labelledby="nav-home-tab-two">
                            <div class="card mb-0">
                                <div class="card-body d-flex flex-column">
                                    <h3>{{ $row->first_name.' '.$row->last_name }}</h3>
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th>Picked up Address</th>
                                            <th>Drip Address</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($row->workLocations as $location)
                                            <tr>
                                                <td>{{ $location->picked_up_address }}</td>
                                                <td>{{ $location->drip_address }}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="biding" role="tabpanel" aria-labelledby="nav-home-tab-two">
                            <div class="card mb-0">
                                <div class="card-body d-flex flex-column">
                                    <h3>{{ $row->first_name.' '.$row->last_name }}</h3>
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th>Driver</th>
                                            <th>Amount</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($row->bidingUsers as $location)
                                            <tr>
                                                <td>{{ $location->picked_up_address }}</td>
                                                <td>{{ $location->drip_address }}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                            <div class="card mb-0">
                                <div class="card-body d-flex flex-column">
                                    <h3>{{ $row->first_name.' '.$row->last_name }}</h3>
                                    <table class="table">
                                        <tbody>
                                        <tr>
                                            <th>{{ ucfirst(str_replace('_',' ','date_time')) }}</th>
                                            <td>{{ format_server_to_local($row->pickup_date_time) }}</td>
                                        </tr>
                                        <tr>
                                            <th>{{ ucfirst(str_replace('_',' ','city')) }}</th>
                                            <td>{{ $row->pickup_city }}</td>
                                        </tr>
                                        <tr>
                                            <th>{{ ucfirst(str_replace('_',' ','state')) }}</th>
                                            <td>{{ $row->pickup_state }}</td>
                                        </tr>
                                        <tr>
                                            <th>{{ ucfirst(str_replace('_',' ','zip_code')) }}</th>
                                            <td>{{ $row->pickup_zip_code }}</td>
                                        </tr>
                                        <tr>
                                            <th>{{ ucfirst(str_replace('_',' ','note')) }}</th>
                                            <td>{{ $row->picked_up_note }}</td>
                                        </tr>
                                        <tr>
                                            <th>Proof Image</th>
                                            <td>
                                                @php($images = $row->images()->where('status_type','picked_up')->get())
                                                @if(isset($images) && count($images)>0)
                                                    @foreach($images as $image)
                                                        <img src="{{ $image->image("300_300") }}" style="height: 100px"
                                                             alt="">
                                                    @endforeach
                                                @endif
                                            </td>
                                        <tr>
                                            <th></th>
                                            @if($row->status == 'on_site' && $row->admin_status_approved == 0)
                                                <td>
                                                    <a href="{{ route($base_route.'approve',$row) }}">
                                                        <button title="Edit {{ $title ?? '' }}" class="btn btn-success">
                                                            Approve
                                                        </button>
                                                    </a>
                                                    <a href="{{ route($base_route.'reject',$row) }}">
                                                        <button title="Edit {{ $title ?? '' }}" class="btn btn-danger">
                                                            Reject
                                                        </button>
                                                    </a>
                                                </td>
                                            @endif
                                        </tr>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
                            <div class="card mb-0">
                                <div class="card-body d-flex flex-column">
                                    <h3>{{ $row->first_name.' '.$row->last_name }}</h3>
                                    <table class="table">
                                        <tbody>
                                        <tr>
                                            <th>{{ ucfirst(str_replace('_',' ','date_time')) }}</th>
                                            <td>{{ format_server_to_local($row->delivery_date_time) }}</td>
                                        </tr>
                                        <tr>
                                            <th>{{ ucfirst(str_replace('_',' ','city')) }}</th>
                                            <td>{{ $row->delivery_city }}</td>
                                        </tr>
                                        <tr>
                                            <th>{{ ucfirst(str_replace('_',' ','state')) }}</th>
                                            <td>{{ $row->delivery_state }}</td>
                                        </tr>
                                        <tr>
                                            <th>{{ ucfirst(str_replace('_',' ','zip_code')) }}</th>
                                            <td>{{ $row->delivery_zip_code }}</td>
                                        </tr>
                                        <tr>
                                            <th>{{ ucfirst(str_replace('_',' ','note')) }}</th>
                                            <td>{{ $row->delivery_note }}</td>
                                        </tr>
                                        <tr>
                                            <th>Proof Image</th>
                                            <td>
                                                @php($images = $row->images()->where('status_type','delivery')->get())
                                                @if(isset($images) && count($images)>0)
                                                    @foreach($images as $image)
                                                        <img src="{{ $image->image("300_300") }}" style="height: 100px"
                                                             alt="">
                                                    @endforeach
                                                @endif
                                            </td>
                                        </tr>
                                        @if($row->status == 'picked_up' && $row->admin_status_approved == 0)
                                            <tr>
                                                <th></th>
                                                <td>
                                                    <a href="{{ route($base_route.'approve',$row) }}">
                                                        <button title="Edit {{ $title ?? '' }}" class="btn btn-success">
                                                            Approve
                                                        </button>
                                                    </a>
                                                    <a href="{{ route($base_route.'reject',$row) }}">
                                                        <button title="Edit {{ $title ?? '' }}" class="btn btn-danger">
                                                            Reject
                                                        </button>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
