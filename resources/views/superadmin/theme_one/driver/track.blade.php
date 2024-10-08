@extends($theme_path.'common.layout')

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0 py-3">
            <li class="breadcrumb-item"><a class="fw-light" href="{{ route('super_admin.index') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a class="fw-light" href="{{ route($base_route.'index') }}">{{ $title ?? 'Title' }}</a></li>
            <li class="breadcrumb-item active fw-light" aria-current="page">Create</li>
        </ol>
    </nav>
@endsection

@section('content')

    <section class="forms">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-close">
                                <div class="dropdown">
                                    <button class="dropdown-toggle text-sm" type="button" id="closeCard1" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></button>
                                    <div class="dropdown-menu dropdown-menu-end shadow-sm" aria-labelledby="closeCard1">
                                        <a class="dropdown-item py-1 px-3 edit" href="{{ route($base_route.'index') }}"> <i class="fas fa-list"></i>List</a>
                                    </div>
                                </div>
                            </div>
                            <h3 class="h4 mb-0">Driver Location</h3>
                        </div>
                        <div class="card-body">
                            <div id="map"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <style>
        #map {
            height: 600px;
            /* The height is 400 pixels */
            width: 100%;
            /* The width is the width of the web page */
        }
    </style>
    @endsection

@push('js')

    @php
    $lat = $row->driver_last_location_lat;
    $long = $row->driver_last_location_long;
    @endphp

    <script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCO_tbN__aYPr-St5IkQfEXf6kKQvRAwiE&callback=initMap&v=weekly"
        defer
    ></script>
    <script>

        console.log("{{ $lat }}")
        console.log("{{ $long }}")

        // Initialize and add the map
        function initMap() {
            // The location of Uluru
            const uluru = {lat: {{ $lat }}, lng: {{ $long }}};
            // The map, centered at Uluru
            const map = new google.maps.Map(document.getElementById("map"), {
                zoom: 14,
                center: uluru,
            });

            if("{{ $lat }}" == 27.6974){
                const marker = new google.maps.Marker({
                    map: map,
                });
            }else{
                const marker = new google.maps.Marker({
                    position: uluru,
                    map: map,
                });
            }

        }

        window.initMap = initMap;

    </script>

@endpush
