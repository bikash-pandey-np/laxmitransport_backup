@extends($theme_path.'common.layout')

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0 py-3">
            <li class="breadcrumb-item"><a class="fw-light" href="{{ route('carrier.index') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a class="fw-light"
                                           href="{{ route($base_route.'index') }}">{{ $title ?? 'Title' }}</a></li>
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
                                    <button class="dropdown-toggle text-sm" type="button" id="closeCard1"
                                            data-bs-toggle="dropdown" aria-expanded="false"><i
                                            class="fas fa-ellipsis-v"></i></button>
                                    <div class="dropdown-menu dropdown-menu-end shadow-sm" aria-labelledby="closeCard1">
                                        <a class="dropdown-item py-1 px-3 edit" href="{{ route($base_route.'index') }}">
                                            <i class="fas fa-list"></i>List</a>
                                    </div>
                                </div>
                            </div>
                            <h3 class="h4 mb-0">{{ $title ?? 'Title' }} Form</h3>
                        </div>
                        <div class="card-body">
                            <form class="form-horizontal" action="{{ route('carrier.loadboard.store',($row->load_board_id ?? request('id'))) }}"
                                  method="post">
                                @csrf
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="input-material-group mb-3">
                                            <input class="input-material" value="{{ $row->amount ?? '' }}"
                                                   id="register-username" type="number" step="0.01" name="amount">
                                            @if(!isset($row->amount))
                                                <label class="label-material" for="register-username">Amount</label>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-9 ms-auto">
                                        <button class="btn btn-secondary" type="reset">Cancel</button>
                                        <button class="btn btn-primary" type="submit">Submit</button>
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
