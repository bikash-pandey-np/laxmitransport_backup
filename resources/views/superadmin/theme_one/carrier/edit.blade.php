@extends($theme_path.'common.layout')

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0 py-3">
            <li class="breadcrumb-item"><a class="fw-light" href="{{ route('super_admin.index') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a class="fw-light" href="{{ route($base_route.'index') }}">{{ $title ?? 'Title' }}</a></li>
            <li class="breadcrumb-item active fw-light" aria-current="page">Edit</li>
        </ol>
    </nav>
@endsection

@section('content')

    <section class="forms">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
{{--                        <div class="card-header">--}}
{{--                            <div class="card-close">--}}
{{--                                <div class="dropdown">--}}
{{--                                    <button class="dropdown-toggle text-sm" type="button" id="closeCard1" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></button>--}}
{{--                                    <div class="dropdown-menu dropdown-menu-end shadow-sm" aria-labelledby="closeCard1">--}}
{{--                                        <a class="dropdown-item py-1 px-3 edit" href="{{ route($base_route.'update',$row->id) }}"> <i class="fas fa-list"></i>List</a>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <h3 class="h4 mb-0">{{ $title ?? 'Title' }} Edit Form</h3>--}}
{{--                        </div>--}}
                        <div class="card-body">
                            <form class="form-horizontal" action="{{ route($base_route.'update',$row->id) }}" method="post" enctype="multipart/form-data">
                                @csrf @method('put')
                                <div class="row">
                                    @include($view_path.'common.form')
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-sm-9 ms-auto">
                                        <button class="btn btn-secondary" type="reset">Cancel</button>
                                        <button class="btn btn-primary" type="submit">Save changes</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @endsection
