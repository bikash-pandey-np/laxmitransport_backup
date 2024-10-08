{{--<div class="col-sm-6">
    <div class="input-material-group mb-3">
        <input class="input-material" id="unique_id" type="text"
               name="unique_id" value="#119919" readonly>
            <label class="label-material" for="unique_id">Unique Id</label>
    </div>
</div>--}}

@php($driverId = old('driver_id') ?? $row->driver_id ?? '')
@php($vehicleId = old('vehicle_id') ?? $row->vehicle_id ?? '')

<div class="col-sm-6">
    <div class="input-material-group mb-3">
        <select name="driver_id" id="driver_id" class="input-material{{ $errors->has('driver_id')?' validation_error':'' }}">
            <option value="">Choose Driver</option>
            @if(isset($drivers) && count($drivers)>0)
                @foreach($drivers as $driver)
                    @php($driverId = old('driver_id') ?? $row->driver_id ?? '')
            <option {{ ($driverId == $driver->id)?'selected':'' }} value="{{ $driver->id }}">{{ $driver->first_name.' '.$driver->last_name }}</option>
                @endforeach
            @endif
        </select>
        @if($errors->has('driver_id'))
            <div class="js-validate-error-label" style="color: #B81111">{{ $errors->first('driver_id') }}</div>
        @endif
    </div>
</div>

<div class="col-sm-6">
    <div class="input-material-group mb-3">
        <select name="vehicle_id" id="vehicle_id" class="input-material{{ $errors->has('vehicle_id')?' validation_error':'' }}">
            <option value="">Choose Vehicle</option>
            @if(isset($vehicles) && count($vehicles)>0)
                @foreach($vehicles as $vehicle)
                    <option {{ ($vehicleId == $vehicle->id)?'selected':'' }} value="{{ $vehicle->id }}">Unit - {{ $vehicle->vehicle_id }} ({{ $vehicle->vehicle_type }})</option>
                @endforeach
            @endif
        </select>
        @if($errors->has('vehicle_id'))
            <div class="js-validate-error-label" style="color: #B81111">{{ $errors->first('vehicle_id') }}</div>
        @endif
    </div>
</div>

@foreach(config('form.work') as $field => $type)
    @if($field == 'admin_load_notes')
    @include($theme_path.'common.form.col_12_div',['field' => $field,'type' => $type])
    @else
    @include($theme_path.'common.form.col_6_div',['field' => $field,'type' => $type])
    @endif
@endforeach

@push('js')

    <script>
        $('#add_location_btn').on('click',function(){
            $.get('{{ url('admin/work/add/location') }}',function(html){
                $('#location_table').append(html);
            });
        });
    </script>
    <script>
        $(document).on('click','.minus_row',function () {
            $(this).parent().parent().remove();
        })
    </script>
@endpush


<div class="col-sm-12">
    <div class="input-material-group mb-3">
        <table class="table">
            <thead>
                <tr>
                    <th class="col-5">Pick up Address</th>
                    <th class="col-5">Drop Address</th>
                    <th class="col-1"><button type="button" class="btn btn-xs btn-primary" id="add_location_btn"><i class="fa fa-plus"></i></button></th>
                </tr>
            </thead>
            <tbody id="location_table">
            @if(isset($row->workLocations) && count($row->workLocations)>0)
                @foreach($row->workLocations as $location)
                    @include($view_path."ajax.location",[
                        'uniqueId' => $location->id,
                        'location' => $location
                    ])
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
</div>


