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
                                {!! $dataTable->table() !!}
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
    {{$dataTable->scripts()}}
@endpush
