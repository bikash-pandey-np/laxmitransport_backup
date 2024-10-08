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
                            {{--                            <button class="nav-link" id="nav-home-tab-two" data-bs-toggle="tab"--}}
                            {{--                                    data-bs-target="#nav-home-two" type="button" role="tab" aria-controls="nav-home"--}}
                            {{--                                    aria-selected="true">Locations--}}
                            {{--                            </button>--}}
                            @if(isset($row->workLocation->pickup_date))
                                <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab"
                                        data-bs-target="#nav-profile" type="button" role="tab"
                                        aria-controls="nav-profile" aria-selected="false">Picked up detail
                                </button>
                            @endif
                            @if(isset($row->workLocation->drop_date))
                                <button class="nav-link" id="nav-contact-tab" data-bs-toggle="tab"
                                        data-bs-target="#nav-contact" type="button" role="tab"
                                        aria-controls="nav-contact" aria-selected="false">Delivery detail
                                </button>
                            @endif
                            <button class="nav-link" id="nav-bidding-tab" data-bs-toggle="tab"
                                    data-bs-target="#nav-bidding" type="button" role="tab" aria-controls="nav-bidding"
                                    aria-selected="true">Appliers
                            </button>
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
                                        <tr>
                                            <th>Status</th>
                                            <td>{{ str_replace("_"," ",$row->status) }}</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="nav-bidding" role="tabpanel"
                             aria-labelledby="nav-bidding-tab">
                            <div class="card mb-0">
                                <div class="card-body d-flex flex-column">
                                    <table class="table">
                                        <tbody>
                                        <tr>
                                            <th>User Type</th>
                                            <th>User</th>
                                            <th>Location</th>
                                            <th>Amount</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                        @if(isset($row->loadBoardUsers) && count($row->loadBoardUsers)>0)
                                            @foreach($row->loadBoardUsers as $user)
                                                @if($user->status !== 'reject')
                                                <tr>
                                                    <td>{{ $user->user_type }}</td>
                                                    <td>{{ $user->user->unit_number ?? "" }}</td>
                                                    <td>{{ $user->user->available_city ?? "" }}</td>
                                                    <td>$ {{ $user->amount }}</td>
                                                    <td>{{ $user->status }}</td>
                                                    <td>
                                                        @if($user->table_type == $row->table && $user->table_id == $row->table_id)
                                                            <a href="javascript:void(0)"
                                                               class="btn btn-info">Selected</a>
                                                        @endif

                                                        @if($row->table == null && $row->table_id == null)
                                                            <a href="{{ route('super_admin.loadboard.approve',$user->id) }}"
                                                               class="btn btn-info">Approve</a>
                                                            <a href="{{ route('super_admin.loadboard.reject',$user->id) }}"
                                                               class="btn btn-danger">Reject</a>
                                                        @endif
                                                    </td>
                                                </tr>
                                                @endif
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
                                            <th colspan="2">Shipper | Pick up Address</th>
                                            <th colspan="2">Consignee | Drop Off Address</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <th>Shipper Name</th>
                                            <th>Address</th>
                                            <th>Consignee Name</th>
                                            <th>Address</th>
                                        </tr>

                                        </tbody>
                                    </table>

                                    <div id="map"></div>

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
                                            <th>Address</th>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <th>Date time</th>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <th>{{ ucfirst(str_replace('_',' ','note')) }}</th>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <th>Proof Image</th>
                                            <td>

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
                                            <th>Address</th>
                                            <td>{{ ($row->workLocation->drop_house_number ?? "")." ".($row->workLocation->drop_street_name ?? "")." ".($row->workLocation->drop_city_state_zipcode ?? "") }}</td>
                                        </tr>
                                        <tr>
                                            <th>Date time</th>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <th>{{ ucfirst(str_replace('_',' ','note')) }}</th>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <th>Proof Image</th>
                                            <td>

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

<style>
    #map {
        height: 600px;
        /* The height is 400 pixels */
        width: 100%;
        /* The width is the width of the web page */
    }
</style>
@push('js')
    {{--    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC7uDoY3ml4KLPr6xoWGc5Fy-bwjQowi4E&callback=initMap" async defer></script>--}}

    {{--{{ dd($row->driver->driver_last_location_lat,$row->driver->driver_last_location_long) }}--}}
    {{--    <script>--}}
    {{--        function initMap() {--}}
    {{--            const uluru = { lat: {{ $row->driver->driver_last_location_lat }}, lng: {{ $row->driver->driver_last_location_long }} };--}}
    {{--            const map = new google.maps.Map(document.getElementById("map"), {--}}
    {{--                zoom: 16,--}}
    {{--                center: uluru,--}}
    {{--            });--}}
    {{--            const marker = new google.maps.Marker({--}}
    {{--                position: uluru,--}}
    {{--                map: map,--}}
    {{--            });--}}
    {{--        }--}}

    {{--        // window.initMap = initMap;--}}
    {{--    </script>--}}

    <script
        src="https://maps.googleapis.com/maps/api/js?key={{ env("GOOGLE_MAP_API_KEY") ?? "" }}&callback=initMap&v=weekly"
        defer
    ></script>

    <script>

        // Initialize and add the map
        function initMap() {
            // The location of Uluru
            const uluru = {lat: -25.344, lng: 131.031};
            // The map, centered at Uluru
            const map = new google.maps.Map(document.getElementById("map"), {
                zoom: 4,
                center: uluru,
            });
            // The marker, positioned at Uluru
            const marker = new google.maps.Marker({
                position: uluru,
                map: map,
            });
        }

        window.initMap = initMap;

    </script>

@endpush
