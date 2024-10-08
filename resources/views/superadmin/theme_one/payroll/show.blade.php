@extends($theme_path.'common.layout')

@section('content')

    <section class="pb-0" style="margin-bottom: 40px;">
        <div class="container-fluid">
            <div class="row gy-4">
                <!-- Total Overdue             -->
                <div class="col-lg-12">
                    <div class="card mb-0">
                        <div class="card-header">
                            <div class="card-close">
                                <div class="dropdown">
                                    <button class="dropdown-toggle text-sm" type="button" id="closeCard1"
                                            data-bs-toggle="dropdown" aria-expanded="false"><i
                                            class="fas fa-ellipsis-v"></i></button>
                                    <div class="dropdown-menu dropdown-menu-end shadow-sm" aria-labelledby="closeCard1">
                                        <a class="dropdown-item py-1 px-3 edit"
                                           href="{{ route($base_route.'create') }}"> <i
                                                class="fas fa-plus"></i>Create</a>
                                    </div>
                                </div>
                            </div>
                            <h3 class="h4 mb-0">{{ $title ?? 'Title' }} List </h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="example" class="table dataTable no-footer">
                                    <tr>
                                        <td></td>
                                    </tr>
                                </table>
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
        const uluru = { lat: -25.344, lng: 131.031 };
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
