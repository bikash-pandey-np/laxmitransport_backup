@extends($theme_path . 'common.layout')

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0 py-3">
            <li class="breadcrumb-item active fw-light" aria-current="page">Dashboard</li>
        </ol>
    </nav>
@endsection

@section('content')
    <!-- Dashboard Counts Section-->
    <section class="pb-0">
        <div class="container-fluid">
            <div class="card mb-0">
                <div class="card-body">
                    <div class="row gx-5 bg-white">
                        <!-- Item -->
                        <div class="col-xl-3 col-sm-6 py-4 border-lg-end border-gray-200">
                            <div class="d-flex align-items-center">
                                <div class="icon flex-shrink-0 bg-violet">
                                    <svg class="svg-icon svg-icon-sm svg-icon-heavy">
                                        <use xlink:href="#user-1"></use>
                                    </svg>
                                </div>
                                <div class="mx-3">
                                    <h6 class="h4 fw-light text-gray-600 mb-3">Total<br>Admins</h6>
                                    <div class="progress" style="height: 4px">
                                        <div class="progress-bar bg-violet" role="progressbar"
                                            style="width: 25%; height: 4px;" aria-valuenow="25" aria-valuemin="0"
                                            aria-valuemax="100"></div>
                                    </div>
                                </div>
                                <div class="number"><strong class="text-lg">{{ \App\Models\Admin::count() }}</strong>
                                </div>
                            </div>
                        </div>
                        <!-- Item -->
                        <div class="col-xl-3 col-sm-6 py-4 border-lg-end border-gray-200">
                            <div class="d-flex align-items-center">
                                <div class="icon flex-shrink-0 bg-red">
                                    <svg class="svg-icon svg-icon-sm svg-icon-heavy">
                                        <use xlink:href="#survey-1"></use>
                                    </svg>
                                </div>
                                <div class="mx-3">
                                    <h6 class="h4 fw-light text-gray-600 mb-3">Total<br>Drivers</h6>
                                    <div class="progress" style="height: 4px">
                                        <div class="progress-bar bg-red" role="progressbar" style="width: 70%; height: 4px;"
                                            aria-valuenow="70" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                                <div class="number"><strong class="text-lg">{{ \App\Models\Driver::count() }}</strong>
                                </div>
                            </div>
                        </div>
                        <!-- Item -->
                        <div class="col-xl-3 col-sm-6 py-4 border-lg-end border-gray-200">
                            <div class="d-flex align-items-center">
                                <div class="icon flex-shrink-0 bg-green">
                                    <svg class="svg-icon svg-icon-sm svg-icon-heavy">
                                        <use xlink:href="#numbers-1"></use>
                                    </svg>
                                </div>
                                <div class="mx-3">
                                    <h6 class="h4 fw-light text-gray-600 mb-3">Available<br>Drivers</h6>
                                    <div class="progress" style="height: 4px">
                                        <div class="progress-bar bg-green" role="progressbar"
                                            style="width: 40%; height: 4px;" aria-valuenow="40" aria-valuemin="0"
                                            aria-valuemax="100"></div>
                                    </div>
                                </div>
                                <div class="number"><strong class="text-lg">{{ $totalAvailableDrivers ?? 0 }}</strong>
                                </div>
                            </div>
                        </div>
                        <!-- Item -->
                        <div class="col-xl-3 col-sm-6 py-4">
                            <div class="d-flex align-items-center">
                                <div class="icon flex-shrink-0 bg-orange">
                                    <svg class="svg-icon svg-icon-sm svg-icon-heavy">
                                        <use xlink:href="#list-details-1"></use>
                                    </svg>
                                </div>
                                <div class="mx-3">
                                    <h6 class="h4 fw-light text-gray-600 mb-3">Total<br>Works</h6>
                                    <div class="progress" style="height: 4px">
                                        <div class="progress-bar bg-orange" role="progressbar"
                                            style="width: 50%; height: 4px;" aria-valuenow="50" aria-valuemin="0"
                                            aria-valuemax="100"></div>
                                    </div>
                                </div>
                                <div class="number"><strong class="text-lg">{{ \App\Models\Work::count() }}</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Dashboard Header Section    -->
    <section class="pb-0">
        <div class="container-fluid">
            <div class="row align-items-stretch">
                <!-- Statistics -->
                <!-- Line Chart            -->
                <div class="col-lg-8 col-12">
                    <div class="card mb-0 h-100">
                        <div class="card-body">
                            <div id="map"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-12">
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="ms-3"><strong class="text-lg d-block lh-1 mb-1">Report</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                    $amounts = \App\Models\Work::where('driver_id', '!=', null)
                        ->whereIn('status', ['cancel', 'Unloaded'])
                        ->get();
                    $amountsTotal = 0;
                    foreach ($amounts as $amount) {
                        $amountsTotal = $amountsTotal + (int) $amount->amount;
                    }
                    ?>
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="icon flex-shrink-0 bg-red"><i class="fas fa-tasks"></i></div>
                                <div class="ms-3"><strong class="text-lg d-block lh-1 mb-1">$
                                        {{ $amountsTotal }}</strong><small
                                        class="text-uppercase text-gray-500 small d-block lh-1">Payroll</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                    $actualAmounts = \App\Models\Work::where('driver_id', '!=', null)
                        ->whereIn('status', ['cancel', 'Unloaded'])
                        ->get();
                    $actualAmountsTotal = 0;
                    foreach ($actualAmounts as $actualAmount) {
                        $actualAmountsTotal = $actualAmountsTotal + (int) $actualAmount->actual_amount;
                    }
                    ?>
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="icon flex-shrink-0 bg-green"><i class="far fa-tasks"></i></div>
                                <div class="ms-3"><strong class="text-lg d-block lh-1 mb-1">$
                                        {{ $actualAmountsTotal }}</strong><small
                                        class="text-uppercase text-gray-500 small d-block lh-1">Sales</small></div>
                            </div>
                        </div>
                    </div>
                    <?php
                    $bills = \App\Models\Bill::get();
                    $billsTotal = 0;
                    foreach ($bills as $bill) {
                        $billsTotal = $billsTotal + (int) $bill->amount;
                    }
                    ?>
                    <div class="card mb-0">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="icon flex-shrink-0 bg-orange"><i class="far fa-tasks"></i></div>
                                <div class="ms-3"><strong class="text-lg d-block lh-1 mb-1">$
                                        {{ $billsTotal }}</strong><small
                                        class="text-uppercase text-gray-500 small d-block lh-1">Expenses</small></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <br>
    <style>
        #map {
            height: 350px;
            /* The height is 400 pixels */
            width: 100%;
            /* The width is the width of the web page */
        }
    </style>
@endsection

@push('js')
    <script src="http://maps.google.com/maps/api/js?key=AIzaSyCO_tbN__aYPr-St5IkQfEXf6kKQvRAwiE" type="text/javascript">
    </script>

    <script>
        $.get("{{ route('super_admin.dashboard.google-map') }}", function(locations) {
            getMap(locations)
        });

        // var locations = [
        //     ['Ram Bahadur', -33.923036, 151.259052, 5],
        //     ['Yadav', -34.028249, 151.157507, 3],
        //     ['Ma pane', -33.80010128657071, 151.28747820854187, 2],
        //     ['Timi pane', -33.950198, 151.259302, 1]
        // ];

        function getMap(locations) {
            var map = new google.maps.Map(document.getElementById('map'), {
                zoom: 2,
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
        }
    </script>
@endpush
