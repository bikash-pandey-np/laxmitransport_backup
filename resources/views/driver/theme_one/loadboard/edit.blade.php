@extends($theme_path.'common.layout')

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0 py-3">
            <li class="breadcrumb-item"><a class="fw-light" href="{{ route('driver.index') }}">Dashboard</a></li>
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
                            <h3 class="h4 mb-0">{{ $title ?? 'Title' }} Change Status To {{ $row->status == 'on_site' ? "Pickup" : "Delivery" }}</h3>
                        </div>
                        <div class="card-body">
                            <form class="form-horizontal" action="{{ route($base_route.'update',$row->id) }}"
                                  method="post" enctype="multipart/form-data">
                                @csrf @method('put')
                                <div class="row">
                                    @if($row->status == 'on_site')
                                        <div class="col-sm-6">
                                            <div class="input-material-group mb-3">
                                                <input class="input-material" id="pickup_city" type="text"
                                                       name="pickup_city" value="{{ old('pickup_city') }}" required>
                                                @if($errors->has('status'))
                                                    <div class="js-validate-error-label" style="color: #B81111">{{ $errors->first('pickup_city') }}</div>
                                                @else
                                                    <label class="label-material" for="pickup_city">Pickup City </label>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="input-material-group mb-3">
                                                <input class="input-material" id="pickup_state" type="text"
                                                       name="pickup_state" value="{{ old('pickup_state') }}" required>
                                                @if($errors->has('status'))
                                                    <div class="js-validate-error-label" style="color: #B81111">{{ $errors->first('pickup_state') }}</div>
                                                @else
                                                    <label class="label-material" for="pickup_state">Pickup State</label>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="input-material-group mb-3">
                                                <input class="input-material" id="pickup_zip_code" type="text"
                                                       name="pickup_zip_code" value="{{ old('pickup_zip_code') }}" required>
                                                @if($errors->has('status'))
                                                    <div class="js-validate-error-label" style="color: #B81111">{{ $errors->first('pickup_zip_code') }}</div>
                                                @else
                                                    <label class="label-material" for="pickup_zip_code">Pickup Zip Code</label>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="input-material-group mb-3">
                                                <textarea placeholder="Description" class="input-material" name="picked_up_note">{{ old('picked_up_note') }}</textarea>
                                            </div>
                                        </div>
                                    @else
                                        <div class="col-sm-6">
                                            <div class="input-material-group mb-3">
                                                <input class="input-material" id="delivery_city" type="text"
                                                       name="delivery_city" value="{{ old('delivery_city') }}" required>
                                                <label class="label-material" for="delivery_city">Delivery City </label>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="input-material-group mb-3">
                                                <input class="input-material" id="delivery_state" type="text"
                                                       name="delivery_state" value="{{ old('delivery_state') }}" required>
                                                <label class="label-material" for="delivery_state">Delivery State</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="input-material-group mb-3">
                                                <input class="input-material" id="delivery_zip_code" type="text"
                                                       name="delivery_zip_code" value="{{ old('delivery_zip_code') }}" required>
                                                <label class="label-material" for="delivery_zip_code">Delivery Zip Code</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="input-material-group mb-3">
                                                <input class="input-material" id="delivery_pod_signed_by" type="text"
                                                       name="delivery_pod_signed_by" value="{{ old('delivery_pod_signed_by') }}" required>
                                                <label class="label-material" for="delivery_pod_signed_by">Pod signed by</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="input-material-group mb-3">
                                                <textarea placeholder="Description" class="input-material" name="delivery_note">{{ old('delivery_note') }}</textarea>
                                            </div>
                                        </div>
                                    @endif

                                    <div class="col-sm-6">
                                        <div class="input-material-group mb-3">
                                            <input type="file" name="images[]" multiple>
                                        </div>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-sm-9 ms-auto">
                                        <button class="btn btn-primary" type="submit">Update</button>
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
