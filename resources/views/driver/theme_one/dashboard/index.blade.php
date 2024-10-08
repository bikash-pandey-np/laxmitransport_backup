@extends($theme_path.'common.layout')

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
                        <div class="col-xl-6 col-sm-6 py-4 border-lg-end border-gray-200">
                            <div class="d-flex align-items-center">
                                <div class="icon flex-shrink-0 bg-yellow">
                                    <svg class="svg-icon svg-icon-sm svg-icon-heavy">
                                        <use xlink:href="#survey-1"></use>
                                    </svg>
                                </div>
                                <div class="mx-3">
                                    <h6 class="h4 fw-light text-gray-600 mb-3">Up-date<br>Assigned Load</h6>
                                    <div class="progress" style="height: 4px">
                                        <div class="progress-bar bg-yellow" role="progressbar"
                                             style="width: 25%; height: 4px;" aria-valuenow="25" aria-valuemin="0"
                                             aria-valuemax="100"></div>
                                    </div>
                                </div>
                                <div class="number"><strong
                                        class="text-lg">{{ \App\Models\Work::where('driver_id',auth()->id())->where('status','on_site')->count() }}</strong>
                                </div>
                            </div>
                        </div>
                        <!-- Item -->
                        {{--                        <div class="col-xl-4 col-sm-6 py-4 border-lg-end border-gray-200">--}}
                        {{--                            <div class="d-flex align-items-center">--}}
                        {{--                                <div class="icon flex-shrink-0 bg-paleBlue">--}}
                        {{--                                    <svg class="svg-icon svg-icon-sm svg-icon-heavy">--}}
                        {{--                                        <use xlink:href="#survey-1"> </use>--}}
                        {{--                                    </svg>--}}
                        {{--                                </div>--}}
                        {{--                                <div class="mx-3">--}}
                        {{--                                    <h6 class="h4 fw-light text-gray-600 mb-3">Picked<br>Up</h6>--}}
                        {{--                                    <div class="progress" style="height: 4px">--}}
                        {{--                                        <div class="progress-bar bg-paleBlue" role="progressbar" style="width: 70%; height: 4px;" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100"></div>--}}
                        {{--                                    </div>--}}
                        {{--                                </div>--}}
                        {{--                                <div class="number"><strong class="text-lg">{{ \App\Models\Work::where('driver_id',auth()->id())->where('status','picked_up')->count() }}</strong></div>--}}
                        {{--                            </div>--}}
                        {{--                        </div>--}}
                        <!-- Item -->
                        <div class="col-xl-6 col-sm-6 py-4 border-lg-end border-gray-200">
                            <div class="d-flex align-items-center">
                                <div class="icon flex-shrink-0 bg-faintGreen">
                                    <svg class="svg-icon svg-icon-sm svg-icon-heavy">
                                        <use xlink:href="#survey-1"></use>
                                    </svg>
                                </div>
                                <div class="mx-3">
                                    <h6 class="h4 fw-light text-gray-600 mb-3">Delivered <br> Work</h6>
                                    <div class="progress" style="height: 4px">
                                        <div class="progress-bar bg-faintGreen" role="progressbar"
                                             style="width: 40%; height: 4px;" aria-valuenow="40" aria-valuemin="0"
                                             aria-valuemax="100"></div>
                                    </div>
                                </div>
                                <div class="number"><strong
                                        class="text-lg">{{ \App\Models\Work::where('driver_id',auth()->id())->where('status','delivery')->count() }}</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="pb-0">
        <div class="container-fluid">
            <div class="card mb-0">
                <div class="card-body">
                    <div class="row gx-5 bg-white">
                        <div class="col-xl-12 col-sm-12 py-4 border-lg-end border-gray-200">
                            <div class="card mb-0">
                                <div class="card-body d-flex flex-column">
                                    <h3>Change Status</h3>
                                    <form action="{{ route('driver.change.status.update') }}" method="post">
                                        @csrf
                                        <div class="row">
                                            @if(count(auth('driver')->user()->activeWorks) > 0)
                                                <div class="col-md-6">
                                                    <div class="input-material-group mb-3"
                                                         style="{{ count(auth('driver')->user()->activeWorks) > 0 ? "":"display: none;" }}">
                                                        <select name="" class="input-material">
                                                            <option value="">Work on speedy</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            @else
                                                <div class="col-md-6">
                                                    <div class="input-material-group mb-3"
                                                         style="{{ count(auth('driver')->user()->activeWorks) > 0 ? "display: none;":"" }}">
                                                        @php($oldData = old('driver_status') ?? auth('driver')->user()->driver_status ?? "")
                                                        <select name="driver_status" id="driver_status"
                                                                class="input-material{{ $errors->has('driver_status')?' validation_error':'' }}">
                                                            <option value="">Choose Status</option>
                                                            <option
                                                                {{ ($oldData == "Available")?"selected":"" }} value="Available">
                                                                Available
                                                            </option>
                                                            <option
                                                                {{ ($oldData == "Not Available")?"selected":"" }} value="Not Available">
                                                                Not Available
                                                            </option>
                                                            <option
                                                                {{ ($oldData == "Retired")?"selected":"" }} value="Retired">
                                                                Retired
                                                            </option>
                                                        </select>
                                                        @if($errors->has('driver_status'))
                                                            <div class="js-validate-error-label"
                                                                 style="color: #B81111">{{ $errors->first('driver_status') }}</div>
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="col-md-6 available_location"
                                                     style="{{ $oldData == "Available" ? "" : "display: none;"  }}">
                                                    <div class="input-material-group mb-3">
                                                        <input type="text" name="available_city"
                                                               value="{{ old('available_city') ?? auth('driver')->user()->available_city ?? "" }}"
                                                               class="input-material" id="city">
                                                        <label class="label-material" for="city">City St Zip</label>
                                                    </div>
                                                    @if($errors->has('available_city'))
                                                        <div class="js-validate-error-label"
                                                             style="color: #B81111">{{ $errors->first('available_city') }}</div>
                                                    @endif
                                                </div>
{{--                                                <div class="col-md-6 available_location"--}}
{{--                                                     style="{{ $oldData == "Available" ? "" : "display: none;"  }}">--}}
{{--                                                    <div class="input-material-group mb-3">--}}
{{--                                                        <input type="text" name="available_state"--}}
{{--                                                               value="{{ old('available_state') ?? $location->stateName ?? $location->regionName ?? "" }}"--}}
{{--                                                               class="input-material" id="state">--}}
{{--                                                        <label class="label-material" for="state">State</label>--}}
{{--                                                    </div>--}}
{{--                                                    @if($errors->has('available_state'))--}}
{{--                                                        <div class="js-validate-error-label"--}}
{{--                                                             style="color: #B81111">{{ $errors->first('available_state') }}</div>--}}
{{--                                                    @endif--}}
{{--                                                </div>--}}
{{--                                                <div class="col-md-6 available_location"--}}
{{--                                                     style="{{ $oldData == "Available" ? "" : "display: none;"  }}">--}}
{{--                                                    <div class="input-material-group mb-3">--}}
{{--                                                        <input type="text" name="available_zip_code"--}}
{{--                                                               value="{{ auth("driver")->user()->available_zip_code ?? old('available_zip_code') ?? $location->zipCode ?? "" }}"--}}
{{--                                                               class="input-material" id="zip_code">--}}
{{--                                                        <label class="label-material" for="zip_code">Zip Code</label>--}}
{{--                                                    </div>--}}
{{--                                                    @if($errors->has('available_zip_code'))--}}
{{--                                                        <div class="js-validate-error-label"--}}
{{--                                                             style="color: #B81111">{{ $errors->first('available_zip_code') }}</div>--}}
{{--                                                    @endif--}}
{{--                                                </div>--}}
                                                <div class="col-md-6 available_location"
                                                     style="{{ $oldData == "Available" ? "" : "display: none;"  }}">
                                                    <div class="input-material-group mb-3">
                                                        <input type="text" name="available_date"
                                                               value="{{ auth("driver")->user()->available_date ?? old('available_date') ?? "" }}"
                                                               class="input-material datepicker" id="date">
                                                        <label class="label-material" for="date">Date</label>
                                                    </div>
                                                    @if($errors->has('available_date'))
                                                        <div class="js-validate-error-label"
                                                             style="color: #B81111">{{ $errors->first('available_date') }}</div>
                                                    @endif
                                                </div>
                                                <div class="col-md-6 available_location"
                                                     style="{{ $oldData == "Available" ? "" : "display: none;"  }}">
                                                    <div class="input-material-group mb-3">
                                                        <input type="text" name="available_time"
                                                               value="{{ format_server_to_local(auth("driver")->user()->available_time) ?? old('available_time') ?? "" }}"
                                                               class="input-material" id="time">
                                                        <label class="label-material" for="time"></label>
                                                    </div>
                                                    @if($errors->has('available_time'))
                                                        <div class="js-validate-error-label"
                                                             style="color: #B81111">{{ $errors->first('available_time') }}</div>
                                                    @endif
                                                </div>
                                            @endif
                                        </div>
                                        <br>
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
            </div>
        </div>
    </section>

    <div style="height: 100px"></div>
@endsection

@push('js')
    <script src="{{ asset('themes/prabin_dashboard/js/charts-home.js') }}"></script>
    <script>
        $('#driver_status').change(function () {
            if ($(this).val() == "Available") {
                $('.available_location').show();
            } else {
                $('.available_location').hide();
            }
        });
    </script>
@endpush
