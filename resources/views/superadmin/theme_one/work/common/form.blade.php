{{--<div class="col-sm-6">
    <div class="input-material-group mb-3">
        <input class="input-material" id="unique_id" type="text"
               name="unique_id" value="#119919" readonly>
            <label class="label-material" for="unique_id">Unique Id</label>
    </div>
</div>--}}

@php($driverId = old('driver_id') ?? $row->driver_id ?? '')
@php($customerId = old('customer_id') ?? $row->customer_id ?? '')
@php($vehicleId = old('vehicle_id') ?? $row->vehicle_id ?? '')
@php($carrierId = $row->driver_id ?? '')

{{--<div class="col-sm-6">--}}
{{--    <div class="input-material-group mb-3">--}}
{{--        <select name="driver_id" id="driver_id"--}}
{{--                class="input-material{{ $errors->has('driver_id')?' validation_error':'' }}" required>--}}
{{--            <option value="">Choose Driver</option>--}}
{{--            @if(isset($drivers) && count($drivers)>0)--}}
{{--                @foreach($drivers as $driver)--}}
{{--                    @php($driverId = old('driver_id') ?? $row->driver_id ?? '')--}}
{{--                    <option--}}
{{--                        {{ ($driverId == $driver->id)?'selected':'' }} value="{{ $driver->id }}">{{ $driver->first_name.' '.$driver->last_name }}</option>--}}
{{--                @endforeach--}}
{{--            @endif--}}
{{--        </select>--}}
{{--        @if($errors->has('driver_id'))--}}
{{--            <div class="js-validate-error-label" style="color: #B81111">{{ $errors->first('driver_id') }}</div>--}}
{{--        @endif--}}
{{--    </div>--}}
{{--</div>--}}

<div class="col-sm-6">
    <div class="input-material-group mb-3">
        <select name="user_type" id="user_type"
                class="input-material{{ $errors->has('user_type')?' validation_error':'' }}">
            <option value="">Choose User Type</option>
            <option {{ (isset($row['user_type']) && $row['user_type'] == "App\Models\Driver") ? "selected" : "" }} value="App\Models\Driver">Driver</option>
            <option {{ (isset($row['user_type']) && $row['user_type'] == "App\Models\Carrier") ? "selected" : "" }} value="App\Models\Carrier">Carrier</option>
        </select>
        @if($errors->has('user_type'))
            <div class="js-validate-error-label" style="color: #B81111">{{ $errors->first('user_type') }}</div>
        @endif
    </div>
</div>

<div class="col-sm-6" style="{{ (isset($row['user_type']) && $row['user_type'] == "App\Models\Driver")?"":"display: none" }}" id="driver_div">
    <div class="input-material-group mb-3">
        <select name="vehicle_id" id="vehicle_id"
                class="input-material{{ $errors->has('vehicle_id')?' validation_error':'' }}">
            <option value="">Choose Vehicle/Driver</option>
            @if(isset($vehicles) && count($vehicles)>0)
                @foreach($vehicles as $vehicle)
                    <option {{ ($vehicleId == $vehicle->id)?'selected':'' }} value="{{ $vehicle->id }}">
                        {{ $vehicle->driver->unit_number ?? "" }}
                    </option>
                @endforeach
            @endif
        </select>
        @if($errors->has('vehicle_id'))
            <div class="js-validate-error-label" style="color: #B81111">{{ $errors->first('vehicle_id') }}</div>
        @endif
    </div>
</div>

<div class="col-sm-6" style="{{ (isset($row['user_type']) && $row['user_type'] == "App\Models\Driver")?"display: none":"" }}" id="carrier_div">
    <div class="input-material-group mb-3">
        <select name="carrier_id" id="carrier_id"
                class="input-material{{ $errors->has('carrier_id')?' validation_error':'' }}">
            <option value="">Choose Carrier</option>
            @if(isset($carriers) && count($carriers)>0)
                @foreach($carriers as $carrier)
                    <option {{ ($carrierId == $carrier->id)?'selected':'' }} value="{{ $carrier->id }}">
                        CU-{{ 1000+$carrier->id }}
                    </option>
                @endforeach
            @endif
        </select>
        @if($errors->has('carrier_id'))
            <div class="js-validate-error-label" style="color: #B81111">{{ $errors->first('carrier_id') }}</div>
        @endif
    </div>
</div>

<div class="col-sm-6">
    <div class="input-material-group mb-3">
        <input class="input-material{{ $errors->has('amount')?' validation_error':'' }}" id="amount"
               type="number" step="0.01"
               name="amount" value="{{ old('amount') ?? $row['amount'] ?? '' }}">
        @if($errors->has('amount'))
            <div class="js-validate-error-label" style="color: #B81111">{{ $errors->first('amount') }}</div>
        @else
            <label class="label-material" for="amount">Driver pay amount</label>
        @endif
    </div>
</div>

<div class="col-sm-6">
    <div class="input-material-group mb-3">
        <input class="input-material{{ $errors->has('actual_amount')?' validation_error':'' }}" id="actual_amount"
               type="number" step="0.01"
               name="actual_amount" value="{{ old('actual_amount') ?? $row['actual_amount'] ?? '' }}">
        @if($errors->has('actual_amount'))
            <div class="js-validate-error-label" style="color: #B81111">{{ $errors->first('actual_amount') }}</div>
        @else
            <label class="label-material" for="actual_amount">Actual amount</label>
        @endif
    </div>
</div>

<div class="col-sm-6">
    <div class="input-material-group mb-3">
        <select name="customer_id" id="customer_id"
                class="input-material{{ $errors->has('customer_id')?' validation_error':'' }}" required>
            <option value="">Choose Brokerage</option>
            @if(isset($customers) && count($customers)>0)
                @foreach($customers as $customer)
                    <option {{ ($customerId == $customer->id)?'selected':'' }} value="{{ $customer->id }}">
                        {{ $customer->name ?? "" }}
                    </option>
                @endforeach
            @endif
        </select>
        @if($errors->has('customer_id'))
            <div class="js-validate-error-label" style="color: #B81111">{{ $errors->first('customer_id') }}</div>
        @endif
    </div>
</div>

{{--@include($theme_path.'common.form.col_6_div',['field' => 'amount','type' => 'number'])--}}

@foreach(config('form.work') as $field => $type)
    @if($field == 'admin_load_notes')
        @include($theme_path.'common.form.col_12_div',['field' => $field,'type' => $type])
    @else
        @include($theme_path.'common.form.col_6_div',['field' => $field,'type' => $type])
    @endif
@endforeach


{{--<div class="col-sm-6">--}}
{{--    <div class="input-material-group mb-3">--}}
{{--        <input class="input-material{{ $errors->has('origin_destination')?' validation_error':'' }}"--}}
{{--               id="origin_destination" type="text"--}}
{{--               name="origin_destination" value="{{ old('origin_destination') ?? $row['origin_destination'] ?? '' }}">--}}
{{--        @if($errors->has('origin_destination'))--}}
{{--            <div class="js-validate-error-label" style="color: #B81111">{{ $errors->first('origin_destination') }}</div>--}}
{{--        @else--}}
{{--            <label class="label-material" for="origin_destination">Origin Destination</label>--}}
{{--        @endif--}}
{{--    </div>--}}
{{--</div>--}}

{{--<div class="col-sm-6">--}}
{{--    <div class="input-material-group mb-3">--}}
{{--        <input class="input-material{{ $errors->has('drop_destination')?' validation_error':'' }}" id="drop_destination"--}}
{{--               type="text"--}}
{{--               name="drop_destination" value="{{ old('drop_destination') ?? $row['drop_destination'] ?? '' }}">--}}
{{--        @if($errors->has('drop_destination'))--}}
{{--            <div class="js-validate-error-label" style="color: #B81111">{{ $errors->first('drop_destination') }}</div>--}}
{{--        @else--}}
{{--            <label class="label-material" for="drop_destination">Drop Destination</label>--}}
{{--        @endif--}}
{{--    </div>--}}
{{--</div>--}}

<div class="col-sm-6">
    <div class="input-material-group mb-3">
        <input class="input-material{{ $errors->has('pro_number')?' validation_error':'' }}" id="pro_number" type="text"
               name="pro_number" value="{{ old('pro_number') ?? $row['pro_number'] ?? '' }}">
        @if($errors->has('pro_number'))
            <div class="js-validate-error-label" style="color: #B81111">{{ $errors->first('pro_number') }}</div>
        @else
            <label class="label-material" for="pro_number">Pro Number</label>
        @endif
    </div>
</div>

<div class="col-sm-6">
{{--    <div class="input-material-group mb-3">--}}
{{--        <select name="location_type" id="location_type" class="input-material">--}}
{{--            <option value="single">Location Single Or Multiple</option>--}}
{{--            <option {{ (isset($row->workLocations) && count($row->workLocations) > 1)?"":"selected" }} value="single">--}}
{{--                Single--}}
{{--            </option>--}}
{{--            <option {{ (isset($row->workLocations) && count($row->workLocations) > 1)?"selected":"" }} value="multiple">--}}
{{--                Multiple--}}
{{--            </option>--}}
{{--        </select>--}}
{{--    </div>--}}
</div>

@php($single = true)
@if (isset($row->workLocations) && count($row->workLocations) > 1)
    @php($single = false)
@endif


{{--<div style="{{ $single?"":"display: none;" }}"--}}
{{--     id="single_location">--}}
    @if(isset($row->workLocations[0]))
        @include($view_path."ajax.single_location",['location' => $row->workLocations[0]])
    @else
        @include($view_path."ajax.single_location")
    @endif
{{--</div>--}}

{{--<div style="{{ $single?"display: none;":"" }}"--}}
{{--     id="multiple_location">--}}
{{--    <div class="col-sm-12">--}}
{{--        <div class="input-material-group mb-3">--}}
{{--            <div class="table-responsive">--}}
{{--                <table class="table">--}}
{{--                    <thead>--}}
{{--                    <tr>--}}
{{--                        <th class="col-16" colspan="4">Pickedup Address</th>--}}
{{--                        <th class="col-20" colspan="4">Drop Address</th>--}}
{{--                        <th class="col-1">--}}
{{--                            <button type="button" class="btn btn-xs btn-primary" id="add_location_btn"><i--}}
{{--                                    class="fa fa-plus"></i></button>--}}
{{--                        </th>--}}
{{--                    </tr>--}}
{{--                    </thead>--}}
{{--                    <tbody id="location_table">--}}
{{--                    @if(isset($row->workLocations) && count($row->workLocations)>0)--}}
{{--                        @foreach($row->workLocations as $location)--}}
{{--                            @include($view_path."ajax.location",[--}}
{{--                                'uniqueId' => $location->id,--}}
{{--                                'location' => $location--}}
{{--                            ])--}}
{{--                        @endforeach--}}
{{--                    @else--}}
{{--                        @include($view_path."ajax.location",[--}}
{{--                                    'uniqueId' => uniqid(rand(1000,9999))--}}
{{--                                ])--}}
{{--                    @endif--}}
{{--                    </tbody>--}}
{{--                </table>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}


@push('js')

    <script>
        $('#add_location_btn').on('click', function () {
            $.get('{{ url('super-admin/work/add/location') }}', function (html) {
                $('#location_table').append(html);
            });
        });
    </script>
    <script>
        $(document).on('click', '.minus_row', function () {
            $(this).parent().parent().remove();
        })
    </script>
    <script>
        $(document).on('change', "#location_type", function () {
            if ($(this).val() == "multiple") {
                $('#multiple_location').show();
                $('#single_location').hide();
            } else {
                $('#multiple_location').hide();
                $('#single_location').show();
            }
        })

        $('#user_type').change(function (){
            var type = $(this).val();
            if(type == "App\\Models\\Driver"){
                $('#carrier_div').hide();
                $('#driver_div').show();
            }else{
                $('#carrier_div').show();
                    $('#driver_div').hide();
            }
        });
    </script>
@endpush


