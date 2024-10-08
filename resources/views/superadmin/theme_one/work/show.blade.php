@extends($theme_path.'common.layout')

@section('content')

    <section class="pb-0" style="margin-bottom: 40px;">
        <div class="container-fluid">
            <div class="row gy-4">
                <!-- Total Overdue             -->
                <div class="col-lg-12">
                    <nav>
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            <button class="nav-link{{ session('type')?"":" active" }}" id="nav-home-tab"
                                    data-bs-toggle="tab"
                                    data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home"
                                    aria-selected="true">Basic detail
                            </button>
<!--                            <button class="nav-link" id="nav-home-tab-two" data-bs-toggle="tab"
                                    data-bs-target="#nav-home-two" type="button" role="tab" aria-controls="nav-home"
                                    aria-selected="true">Locations
                            </button>-->
                            @if(isset($row->workLocation->pickup_date))
                                <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab"
                                        data-bs-target="#nav-profile" type="button" role="tab"
                                        aria-controls="nav-profile" aria-selected="false">Pick up detail
                                </button>
                            @endif
                            @if(isset($row->workLocation->drop_date))
                                <button class="nav-link" id="nav-contact-tab" data-bs-toggle="tab"
                                        data-bs-target="#nav-contact" type="button" role="tab"
                                        aria-controls="nav-contact" aria-selected="false">Delivery detail
                                </button>
                            @endif
                            <button class="nav-link{{ session('type')?" active":"" }}" id="nav-work-track-tab"
                                    data-bs-toggle="tab"
                                    data-bs-target="#nav-work-track" type="button" role="tab"
                                    aria-controls="nav-work-track" aria-selected="false">Work Tracking
                            </button>
                        </div>
                    </nav>

                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade{{ session('type')?"":" show active" }}" id="nav-home" role="tabpanel"
                             aria-labelledby="nav-home-tab">
                            <div class="card mb-0">
                                <div class="card-body d-flex flex-column">
                                    <h3>{{ $row->first_name.' '.$row->last_name }}</h3>
                                    <table class="table">
                                        <tbody>
                                        @foreach(config('form.work') as $key => $value)
                                            <tr>
                                                <th>{{ ucfirst(str_replace('_',' ',$key)) }}</th>
                                                <td>{{ $row->{$key} }}</td>
                                            </tr>
                                        @endforeach
                                        <tr>
                                            <th>Status</th>
                                            <td>{{ str_replace("_"," ",$row->status) }}</td>
                                        </tr>
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
                                        @foreach($row->workLocations as $location)
                                            <tr>
                                                <td>{{ $location->company_name ?? "" }}</td>
                                                <td>{{ ($location->pickup_house_number ?? "")." ".($location->pickup_street_name ?? "")." ".($location->pickup_city_state_zipcode ?? "") }}</td>
                                                <td>{{ ($location->drop_house_number ?? "")." ".($location->drop_street_name ?? "")." ".($location->drop_city_state_zipcode ?? "") }}</td>
                                                <td>{{ $location->consignee_name ?? "" }}</td>
                                            </tr>
                                        @endforeach
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
                                            <td>{{ ($row->workLocation->pickup_house_number ?? "")." ".($row->workLocation->pickup_street_name ?? "")." ".($row->workLocation->pickup_city_state_zipcode ?? "") }}</td>
                                        </tr>
                                        <tr>
                                            <th>Date time</th>
                                            <td>{{ (($row->workLocation->pickup_date ?? "") . " ". format_server_to_local($row->workLocation->pickup_time ?? "")) ?? "" }}</td>
                                        </tr>
                                        <tr>
                                            <th>{{ ucfirst(str_replace('_',' ','note')) }}</th>
                                            <td>{{ $row->workLocation->pickup_note }}</td>
                                        </tr>
                                        <tr>
                                            <th>Proof Image</th>
                                            <td>
                                                @php($images = $row->workLocation->images()->where('status_type','Loaded At Shipper')->get())
                                                @if(isset($images) && count($images)>0)
                                                    @foreach($images as $image)
                                                        <a href="{{ $image->image("upload") }}" target="_blank"><img
                                                                src="{{ $image->image("300_300") }}"
                                                                style="height: 100px" alt=""></a>
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
                                            <th>Address</th>
                                            <td>{{ ($row->workLocation->drop_house_number ?? "")." ".($row->workLocation->drop_street_name ?? "")." ".($row->workLocation->drop_city_state_zipcode ?? "") }}</td>
                                        </tr>
                                        <tr>
                                            <th>Date time</th>
                                            <td>{{ ($row->workLocation->drop_date . " ". format_server_to_local($row->workLocation->drop_time)) ?? "" }}</td>
                                        </tr>
                                        <tr>
                                            <th>{{ ucfirst(str_replace('_',' ','note')) }}</th>
                                            <td>{{ $row->workLocation->pickup_note }}</td>
                                        </tr>
                                        <tr>
                                            <th>POD signed by</th>
                                            <td>{{ str_replace("_"," ",$row->delivery_pod_signed_by) }}</td>
                                        </tr>
                                        <tr>
                                            <th>Proof Image</th>
                                            <td>

                                                @php($images = $row->workLocation->images()->where('status_type','Unloaded')->get())
                                                @if(isset($images) && count($images)>0)
                                                    @foreach($images as $image)
                                                        <a href="{{ $image->image("upload") }}" target="_blank"><img
                                                                src="{{ $image->image("300_300") }}"
                                                                style="height: 100px" alt=""></a>
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
                        <div class="tab-pane fade{{ session('type')?" show active":"" }}" id="nav-work-track"
                             role="tabpanel" aria-labelledby="nav-work-track-tab">
                            <div class="card mb-0">
                                <div class="card-body d-flex flex-column">
                                    <div>
                                        <h3>Work Track</h3>
                                        <a href="javascript:void(0)" class="btn btn-sm btn-primary" style="float: right"
                                           id="addNewModal">Create New</a>
                                        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                                             aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document"
                                                 style="margin-top: 200px!important;max-width: 800px;">
                                                <form action="{{ route('super_admin.work_tracking.store') }}"
                                                      method="post">
                                                    @csrf
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Wrok Tracking
                                                                Add Data</h5>
                                                        </div>
                                                        <input type="hidden" name="work_id" value="{{ $row->id }}">
                                                        <div class="modal-body">
                                                            <div class="form-group">
                                                                <label for="">Location</label>
                                                                <input type="text" name="location" class="form-control"
                                                                       placeholder="Enter Address">
                                                            </div>
                                                            <br>
                                                            <div class="form-group">
                                                                <label for="">Date</label>
                                                                <input type="date" name="date" class="form-control"
                                                                       placeholder="Enter Date">
                                                            </div>
                                                            <br>
                                                            <div class="form-group">
                                                                <label for="">Time</label>
                                                                <input type="text" id="time" name="time" class="form-control"
                                                                       placeholder="Enter Time">
                                                            </div>
                                                            <br>
                                                            <div class="form-group">
                                                                <label for="">Admin Note</label>
                                                                <input type="text" name="admin_note" class="form-control"
                                                                       placeholder="Enter Admin Note">
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                    id="closeNewModal" data-dismiss="modal">Close
                                                            </button>
                                                            <button type="submit" class="btn btn-primary">Save changes
                                                            </button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <table class="table">
                                        <tbody>
                                        <tr>
                                            <th>Address</th>
                                            <th>Date Time</th>
                                            <th>Action</th>
                                        </tr>
                                        @foreach(\App\Models\WorkTracking::where('work_id',$row->id)->get() as $track)
                                            <tr>
                                                <td>{{ $track->location }}</td>
                                                <td>{{ format_date($track->date) }} {{ format_server_to_local($track->time) }}</td>
                                                <td>
                                                    <form
                                                        action="{{ route('super_admin.work_tracking.destroy',$track) }}"
                                                        method="post" id="formPost{{ $track->id }}">
                                                        @csrf @method('delete')
                                                        <button type="button" class="btn btn-xs btn-danger clickBtn"
                                                                data-id="formPost{{ $track->id }}"><i
                                                                class="fa fa-trash"></i></button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
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
    <script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
            integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
            crossorigin="anonymous"></script>
    <script type="text/javascript">
        $('#addNewModal').on('click', function () {
            $('#exampleModal').modal('show');
        });
        $('#closeNewModal').on('click', function () {
            $('#exampleModal').modal('hide');
        });
    </script>

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
