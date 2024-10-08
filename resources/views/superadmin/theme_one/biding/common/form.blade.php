@php($vehicleId = old('vehicle_id') ?? $row->vehicle_id ?? '')

{{--<div class="col-sm-6">--}}
    {{--<div class="input-material-group mb-3">--}}
        {{--<select name="vehicle_id" id="vehicle_id" class="input-material{{ $errors->has('vehicle_id')?' validation_error':'' }}">--}}
            {{--<option value="">Choose Vehicle</option>--}}
            {{--@if(isset($vehicles) && count($vehicles)>0)--}}
                {{--@foreach($vehicles as $vehicle)--}}
                    {{--<option {{ ($vehicleId == $vehicle->id)?'selected':'' }} value="{{ $vehicle->id }}">Unit - {{ $vehicle->vehicle_id }} ({{ $vehicle->vehicle_type }})</option>--}}
                {{--@endforeach--}}
            {{--@endif--}}
        {{--</select>--}}
        {{--@if($errors->has('vehicle_id'))--}}
            {{--<div class="js-validate-error-label" style="color: #B81111">{{ $errors->first('vehicle_id') }}</div>--}}
        {{--@endif--}}
    {{--</div>--}}
{{--</div>--}}

@foreach(config('form.biding') as $field => $type)
    @if($field == 'admin_load_notes')
        @include($theme_path.'common.form.col_12_div',['field' => $field,'type' => $type])
    @else
        @include($theme_path.'common.form.col_6_div',['field' => $field,'type' => $type])
    @endif
@endforeach

<div class="col-sm-6">
    <div class="input-material-group mb-3">
        <input class="input-material{{ $errors->has('origin_destination')?' validation_error':'' }}" id="origin_destination" type="text"
               name="origin_destination" value="{{ old('origin_destination') ?? $row['origin_destination'] ?? '' }}">
        @if($errors->has('origin_destination'))
            <div class="js-validate-error-label" style="color: #B81111">{{ $errors->first('origin_destination') }}</div>
        @else
            <label class="label-material" for="origin_destination">Origin Destination</label>
        @endif
    </div>
</div>

<div class="col-sm-6">
    <div class="input-material-group mb-3">
        <input class="input-material{{ $errors->has('drop_destination')?' validation_error':'' }}" id="drop_destination" type="text"
               name="drop_destination" value="{{ old('drop_destination') ?? $row['drop_destination'] ?? '' }}">
        @if($errors->has('drop_destination'))
            <div class="js-validate-error-label" style="color: #B81111">{{ $errors->first('drop_destination') }}</div>
        @else
            <label class="label-material" for="drop_destination">Drop Destination</label>
        @endif
    </div>
</div>

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
    <div class="input-material-group mb-3">
        <select name="location_type" id="location_type" class="input-material">
            <option value="single">Location Single Or Multiple</option>
            <option value="single">Single</option>
            <option value="multiple">Multiple</option>
        </select>
    </div>
</div>

<div id="single_location">
    @include($view_path."ajax.single_location")
</div>

@push('js')

    <script>
        $('#add_location_btn').on('click',function(){
            $.get('{{ url('super-admin/work/add/location') }}',function(html){
                $('#location_table').append(html);
            });
        });
    </script>
    <script>
        $(document).on('click','.minus_row',function () {
            $(this).parent().parent().remove();
        })
    </script>
<script>
    $(document).on('change',"#location_type", function () {
        if($(this).val() == "multiple"){
            $('#multiple_location').show();
            $('#single_location').hide();
        }else{
            $('#multiple_location').hide();
            $('#single_location').show();
        }
    })
</script>
@endpush



<div style="display: none;" id="multiple_location">
    <div class="col-sm-12">
        <div class="input-material-group mb-3">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                    <tr>
                        <th class="col-16" colspan="4">Pickedup Address</th>
                        <th class="col-20" colspan="4">Drop Address</th>
                        <th class="col-1">
                            <button type="button" class="btn btn-xs btn-primary" id="add_location_btn"><i
                                        class="fa fa-plus"></i></button>
                        </th>
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
                    @else
                        @include($view_path."ajax.location",[
                                    'uniqueId' => uniqid(rand(1000,9999))
                                ])
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>



