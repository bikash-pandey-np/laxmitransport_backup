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

    <script src="http://maps.google.com/maps/api/js?key=AIzaSyCO_tbN__aYPr-St5IkQfEXf6kKQvRAwiE"
            type="text/javascript"></script>

    <script>

        var locations = [
            ['Ram Bahadur', -33.923036, 151.259052, 5],
            ['Yadav', -34.028249, 151.157507, 3],
            ['Ma pane', -33.80010128657071, 151.28747820854187, 2],
            ['Timi pane', -33.950198, 151.259302, 1]
        ];

        var map = new google.maps.Map(document.getElementById('map'), {
            zoom: 3,
            center: new google.maps.LatLng(11.890542, 8.274856),
            mapTypeId: google.maps.MapTypeId.ROADMAP
        });

        var infowindow = new google.maps.InfoWindow();

        var marker, i;

        for (i = 0; i < locations.length; i++) {
            marker = new google.maps.Marker({
                position: new google.maps.LatLng(locations[i][1], locations[i][2]),
                map: map,
            });

            google.maps.event.addListener(marker, 'click', (function(marker, i) {
                return function() {
                    infowindow.setContent(locations[i][0]);
                    infowindow.open(map, marker);
                }
            })(marker, i));

            google.maps.event.addListener(marker, 'click', function() {
                window.location.href = 'http://www.google.com/';
            });
        }

    </script>

@endpush
