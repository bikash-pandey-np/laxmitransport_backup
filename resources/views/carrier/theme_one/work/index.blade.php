@extends($theme_path.'common.layout')

@section('content')

    <section class="tables">
        <div class="container-fluid">
            <div class="row gy-4">
                <div class="col-lg-12">
                    <div class="card mb-0">
                        <div class="card-header">
                            <h3 class="h4 mb-0">{{ $title ?? 'Title' }} List </h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                {{--                                {!! $dataTable->table() !!}--}}
                                <table id="example" class="table dataTable no-footer">
                                    <thead>
                                    <tr>
                                        <th>Work Id</th>
                                        <th>Pickup Location</th>
                                        <th>Pickup Date Time</th>
                                        <th>Drop Location</th>
                                        <th>Drop Date Time</th>
                                        <th>Status</th>
                                        <th>Approved By Admin?</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    @php($keyArr = [])
                                    @if(isset($works) && count($works)>0)
                                        @foreach($works as $key => $row)
                                            @php($location = $row->workLocation)
                                                @continue($location == null)
                                            <tr>
                                                <td>
                                                    SE-{{ $row->id + 1000 }}
{{--                                                    <a href="{{ route($base_route.'show',$row->id) }}">{{ !in_array($key,$keyArr) ? "SE-". $row->id+1000 : "" }}</a>--}}
                                                </td>
                                                <td>{{ $location->pickup_city_state_zipcode." ".$location->pickup_street_name." ".$location->pickup_house_number }}</td>
                                                <td>
                                                    @if($location->pickup_date)
                                                        {{ $location->pickup_date." ".format_server_to_local($location->pickup_time) }}
                                                    @endif
                                                </td>
                                                <td>{{ $location->drop_city_state_zipcode." ".$location->drop_street_name." ".$location->drop_house_number }}</td>
                                                <td>
                                                    @if($location->drop_date)
                                                        {{ $location->drop_date." ".format_server_to_local($location->drop_time) }}
                                                    @endif
                                                </td>
                                                <td>{{ !in_array($key,$keyArr) ? ucwords(str_replace('_',' ',$row->status)) : "" }}</td>
                                                <td>
                                                    @if($row->status != "pending")
                                                    {{ ($row->admin_status_approved)?"Yes":"No" }}
                                                        @endif
                                                </td>
                                                <td>
                                                    @if ($row->admin_status_approved == 1 && !in_array($row->status,['Cancel',"Unloaded"]))
                                                    <a href="{{ route($base_route.'edit',['id' => $location->id]) }}">
                                                        <button class="btn btn-xs btn-primary"><i class="fa fa-edit"></i></button>
                                                    </a>
                                                        @endif
                                                </td>
                                            </tr>
                                            @php(array_push($keyArr,$key))

                                        @endforeach
                                    @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/js/jquery.dataTables.min.js"
            integrity="sha512-BkpSL20WETFylMrcirBahHfSnY++H2O1W+UnEEO4yNIl+jI2+zowyoGJpbtk6bx97fBXf++WJHSSK2MV4ghPcg=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/css/dataTables.bootstrap.min.css"
          integrity="sha512-BMbq2It2D3J17/C7aRklzOODG1IQ3+MHw3ifzBHMBwGO/0yUqYmsStgBjI0z5EYlaDEFnvYV7gNYdD3vFLRKsA=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <script>
        $(document).ready(function () {
            $('#example').DataTable({
                "ordering": false
            });
        });
    </script>
    {{--    {{$dataTable->scripts()}}--}}
@endpush
