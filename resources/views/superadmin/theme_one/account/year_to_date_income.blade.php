@extends($theme_path.'common.layout',[
    "hidemenu" => true
])

@section('content')

    <section class="tables">
        <div class="container-fluid">
            <div class="row gy-4">
                <div class="col-lg-12">
                    <div class="card mb-0">
                        <div class="card-header">
                            <h3 class="h4 mb-0">Driver List</h3>
                            <div class="" style="float: right">
                                <form action="">
                                    <input type="text" style="height: 36px" placeholder="unit number" name="unit_number" value="{{ request('unit_number') }}">
                                    <button class="btn btn-primary"><i class="fa fa-search"></i></button>
                                </form>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                {{--                                {!! $dataTable->table() !!}--}}
                                <table id="example" class="table dataTable no-footer">
                                    <thead>
                                    <tr>
                                        <th>Unit Number</th>
                                        <th>Full Name</th>
                                        <th>Date Of Birth</th>
                                        <th>Social Security Number</th>
                                        <th>Q1</th>
                                        <th>Q2</th>
                                        <th>Q3</th>
                                        <th>Q4</th>
                                        <th>Total</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    @if(isset($drivers) && count($drivers)>0)
                                        @foreach($drivers as $key => $driver)
                                            @php
                                            $q1 = 0;
                                            $q2 = 0;
                                            $q3 = 0;
                                            $q4 = 0;
                                            $orders = \App\Models\Work::where('driver_id',$driver->id)->whereYear('created_at',date('Y'))->get();
                                            foreach ($orders as $item) {
                                                $month = explode('-',$item->created_at)[1];
                                                if (in_array($month,['01','02','03'])){
                                                    $q1 = $q1+$item->amount;
                                                }elseif (in_array($month,['04','05','06'])){
                                                    $q2 = $q2+$item->amount;
                                                }elseif (in_array($month,['07','08','09'])){
                                                    $q3 = $q3+$item->amount;
                                                }elseif (in_array($month,['10','11','12'])){
                                                    $q4 = $q4+$item->amount;
                                                }
                                            }
                                            @endphp
                                            <tr>
                                                <td>{{ $driver->unit_number }}</td>
                                                <td>{{ $driver->full_name }}</td>
                                                <td>{{ $driver->date_of_birth }}</td>
                                                <td>{{ $driver->social_security_number }}</td>
                                                <td>$ {{ $q1 }}</td>
                                                <td>$ {{ $q2 }}</td>
                                                <td>$ {{ $q3 }}</td>
                                                <td>$ {{ $q4 }}</td>
                                                <td>$ {{ $q1+$q2+$q3+$q4 }}</td>
                                            </tr>
                                        @endforeach
                                    @endif
                                    </tbody>
                                </table>
                                <div style="float: right">
                                    {!! $drivers->links() !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/js/jquery.dataTables.min.js" integrity="sha512-BkpSL20WETFylMrcirBahHfSnY++H2O1W+UnEEO4yNIl+jI2+zowyoGJpbtk6bx97fBXf++WJHSSK2MV4ghPcg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/css/dataTables.bootstrap.min.css" integrity="sha512-BMbq2It2D3J17/C7aRklzOODG1IQ3+MHw3ifzBHMBwGO/0yUqYmsStgBjI0z5EYlaDEFnvYV7gNYdD3vFLRKsA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@endpush
