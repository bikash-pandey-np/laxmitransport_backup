@extends($theme_path.'profile.profile_layout')

@section('profile')

    <div class="card mb-0">
        <div class="card-close">
            <div class="dropdown">
                <button class="dropdown-toggle text-sm" type="button" id="closeCard1" data-bs-toggle="dropdown"
                        aria-expanded="false"><i class="fas fa-ellipsis-v"></i></button>
                <div class="dropdown-menu dropdown-menu-end shadow-sm" aria-labelledby="closeCard1"><a
                        class="dropdown-item py-1 px-3 edit" href="{{ route('driver.profile.edit') }}"> <i
                            class="fas fa-cog"></i>Edit Profile</a></div>
            </div>
        </div>
        <div class="card-body d-flex flex-column">
            <h3>Change Status</h3>
            <form action="{{ route('driver.change.status.update') }}" method="post">
                @csrf
                <div class="row">
                        @php($oldData = old('driver_status') ?? auth('driver')->user()->driver_status ?? "")
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
                                <select name="driver_status" id="driver_status"
                                        class="input-material{{ $errors->has('driver_status')?' validation_error':'' }}">
                                    <option value="">Choose Status</option>
                                    <option {{ ($oldData == "Available")?"selected":"" }} value="Available">Available
                                    </option>
                                    <option {{ ($oldData == "Not Available")?"selected":"" }} value="Not Available">Not
                                        Available
                                    </option>
                                    <option
                                        {{ ($oldData == "Retired")?"selected":"" }} value="Retired">
                                        Retired
                                    </option>
                                    {{--                                                    <option {{ (old('driver_status') == "At Pickup Location")?"selected":"" }} value="At Pickup Location">At Pickup Location</option>--}}
                                    {{--                                                    <option {{ (old('driver_status') == "On Route")?"selected":"" }} value="On Route">On Route</option>--}}
                                    {{--                                                    <option {{ (old('driver_status') == "At Drop Location")?"selected":"" }} value="At Drop Location">At Drop Location</option>--}}
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
                                       value="{{ auth("driver")->user()->available_city ?? old('available_city') ?? $location->cityName ?? "" }}"
                                       class="input-material" id="city">
                                <label class="label-material" for="city">City</label>
                            </div>
                            @if($errors->has('available_city'))
                                <div class="js-validate-error-label"
                                     style="color: #B81111">{{ $errors->first('available_city') }}</div>
                            @endif
                        </div>
                        <div class="col-md-6 available_location"
                             style="{{ $oldData == "Available" ? "" : "display: none;"  }}">
                            <div class="input-material-group mb-3">
                                <input type="text" name="available_state"
                                       value="{{ auth("driver")->user()->available_state ?? old('available_state') ?? $location->stateName ?? $location->regionName ?? "" }}"
                                       class="input-material" id="state">
                                <label class="label-material" for="state">State</label>
                            </div>
                            @if($errors->has('available_state'))
                                <div class="js-validate-error-label"
                                     style="color: #B81111">{{ $errors->first('available_state') }}</div>
                            @endif
                        </div>
                        <div class="col-md-6 available_location"
                             style="{{ $oldData == "Available" ? "" : "display: none;"  }}">
                            <div class="input-material-group mb-3">
                                <input type="text" name="available_zip_code"
                                       value="{{ auth("driver")->user()->available_zip_code ?? old('available_zip_code') ?? $location->zipCode ?? "" }}"
                                       class="input-material" id="zip_code">
                                <label class="label-material" for="zip_code">Zip Code</label>
                            </div>
                            @if($errors->has('available_zip_code'))
                                <div class="js-validate-error-label"
                                     style="color: #B81111">{{ $errors->first('available_zip_code') }}</div>
                            @endif
                        </div>
                        <div class="col-md-6 available_location"
                             style="{{ $oldData == "Available" ? "" : "display: none;"  }}">
                            <div class="input-material-group mb-3">
                                <input type="text" name="available_date"
                                       value="{{ auth("driver")->user()->available_date ?? old('available_date') ?? $location->stateName ?? $location->regionName ?? "" }}"
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
                                       value="{{ auth("driver")->user()->available_time ?? old('available_time') ?? $location->zipCode ?? "" }}"
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

@endsection

@push('js')
    @include('common.map_scripts')
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
