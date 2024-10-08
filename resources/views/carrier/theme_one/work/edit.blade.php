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
                            <h3 class="h4 mb-0">Order Status Update</h3>
                        </div>
                        <div class="card-body">
                            <form class="form-horizontal" action="{{ route($base_route.'update',$location->id) }}"
                                  method="post" enctype="multipart/form-data">
                                @csrf @method('put')
                                <div class="row">
                                    <input type="hidden" name="type" value="{{ request('type') }}">
                                    <div class="col-sm-6">
                                        <div class="input-material-group mb-3">
                                            <select name="status" id="status" class="input-material-group form-control" required>
                                                <option value="" disabled selected>Change Status</option>
                                                <option value="On Route To Pickup">On Route To Pickup</option>
                                                <option value="On Site At Pickup">On Site At Pickup</option>
                                                <option value="Loaded At Shipper">Loaded At Shipper</option>
                                                <option value="On Route To Delivered">On Route To Delivered</option>
                                                <option value="On Site At Cosignee">On Site At Cosignee</option>
                                                <option value="Unloaded">Unloaded</option>
                                                <option value="Cancel">Cancel</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="input-material-group mb-3">
                                                    <input class="input-material datepicker" id="date"
                                                           type="text"
                                                           name="date" value="{{ old('date') }}">
                                                    @if($errors->has('status'))
                                                        <div class="js-validate-error-label"
                                                             style="color: #B81111">{{ $errors->first('date') }}</div>
                                                    @else
                                                        <label class="label-material" id="date_time_text" for="date">Pickup Date
                                                            Time</label>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="input-material-group mb-3">
                                                    <input class="input-material" id="time" type="text"
                                                           name="time" value="{{ old('time') }}">
                                                    @if($errors->has('status'))
                                                        <div class="js-validate-error-label"
                                                             style="color: #B81111">{{ $errors->first('time') }}</div>
                                                    @else
                                                        <label class="label-material" for="time"></label>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" id="pickup" style="display: none;">
                                    <div class="col-sm-12">
                                        <div class="input-material-group mb-3">
                                            <input class="input-material" id="pickup_city" type="text"
                                                   name="pickup_city" value="{{ $location->pickup_house_number }}"
                                                   disabled>
                                            <label class="label-material" for="pickup_city">Address</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="input-material-group mb-3">
                                                <textarea class="input-material" rows="6" id="pickup_note" type="text"
                                                          placeholder="Pickup Note"
                                                          name="pickup_note">{{ $location->pickup_note }}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" id="drop" style="display: none;">
                                    <div class="col-sm-12">
                                        <div class="input-material-group mb-3">
                                            <input class="input-material" id="drop_city" type="text"
                                                   name="drop_city" value="{{ $location->drop_house_number }}" disabled>
                                            <label class="label-material" for="drop_city">Address</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="input-material-group mb-3">
                                                <textarea class="input-material" rows="6" id="drop_note" type="text"
                                                          placeholder="Drop Note"
                                                          name="drop_note">{{ $location->pickup_city_state_zipcode }}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" id="images" style="display: none;">

                                    <div class="col-sm-6">
                                        <div class="input-material-group mb-3">
                                            <input type="file" name="images[]" multiple>
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="input-material-group mb-3">
                                            <input class="input-material" id="delivery_pod_signed_by" type="text"
                                                   name="delivery_pod_signed_by">
                                            <label class="label-material" for="delivery_pod_signed_by">POD signed by</label>
                                        </div>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-sm-12 ms-auto">
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

@push('js')
    <script>
        $("#status").on("change",function(){
            $('#pickup').hide();
            $('#drop').hide();
            $('#images').hide();
            $('#date_time_text').text('Date Time');
            if($(this).val() == "Loaded At Shipper"){
                $('#pickup').show();
                $('#images').show();
                $('#date_time_text').text('Pickup Date Time');
            }
            if($(this).val() == "Unloaded"){
                $('#drop').show();
                $('#images').show();
                $('#date_time_text').text('Drop Date Time');
            }
        });
    </script>
@endpush
