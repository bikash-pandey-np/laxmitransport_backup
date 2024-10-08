<div class="col-sm-6">
    <div class="input-material-group mb-3">
        @php($oldData = old('driver_id') ?? $row['driver_id'] ?? '')
        <select name="{{ 'driver_id' }}" class="input-material{{ $errors->has('driver_id')?' validation_error':'' }}" required>
            <option value="">Select Driver</option>
            @foreach($drivers as $driver)
                <option {{ $oldData == $driver->id?"selected":"" }} value="{{ $driver->id }}">{{ $driver->unit_number }}</option>
            @endforeach
        </select>
        @if($errors->has('driver_id'))
            <div class="js-validate-error-label" style="color: #B81111">{{ $errors->first('driver_id') }}</div>
        @endif
    </div>
</div>

@foreach(config('form.vehicle') as $field => $type)

    @if($field == 'vehicle_id')
        <div class="col-sm-6">
            <div class="input-material-group mb-3">
                <input class="input-material{{ $errors->has($field)?' validation_error':'' }}" id="{{ $field }}"
                       type="number" step="0.01"
                       name="{{ $field }}" value="{{ old($field) ?? $row[$field] ?? '' }}">
                @if($errors->has($field))
                    <div class="js-validate-error-label" style="color: #B81111">{{ $errors->first($field) }}</div>
                @else
                    <label class="label-material" for="{{ $field }}">Unit Number</label>
                @endif
            </div>
        </div>
    @elseif($field == 'box_dims_length')
        <div class="col-sm-6">
            <div class="input-material-group mb-3">
                <input class="input-material{{ $errors->has($field)?' validation_error':'' }}" id="{{ $field }}"
                       type="number" step="0.01"
                       name="{{ $field }}" value="{{ old($field) ?? $row[$field] ?? '' }}">
                @if($errors->has($field))
                    <div class="js-validate-error-label" style="color: #B81111">{{ $errors->first($field) }}</div>
                @else
                    <label class="label-material" for="{{ $field }}">Length</label>
                @endif
            </div>
        </div>
    @elseif($field == 'box_dims_height')
        <div class="col-sm-6">
            <div class="input-material-group mb-3">
                <input class="input-material{{ $errors->has($field)?' validation_error':'' }}" id="{{ $field }}"
                       type="number" step="0.01"
                       name="{{ $field }}" value="{{ old($field) ?? $row[$field] ?? '' }}">
                @if($errors->has($field))
                    <div class="js-validate-error-label" style="color: #B81111">{{ $errors->first($field) }}</div>
                @else
                    <label class="label-material" for="{{ $field }}">Height</label>
                @endif
            </div>
        </div>
    @elseif($field == 'box_dims_width')
        <div class="col-sm-6">
            <div class="input-material-group mb-3">
                <input class="input-material{{ $errors->has($field)?' validation_error':'' }}" id="{{ $field }}"
                       type="number" step="0.01"
                       name="{{ $field }}" value="{{ old($field) ?? $row[$field] ?? '' }}">
                @if($errors->has($field))
                    <div class="js-validate-error-label" style="color: #B81111">{{ $errors->first($field) }}</div>
                @else
                    <label class="label-material" for="{{ $field }}">Width</label>
                @endif
            </div>
        </div>
    @elseif($field == 'vehicle_type')
        <div class="col-sm-6">
            <div class="input-material-group mb-3">
                @php($oldData = old($field) ?? $row[$field] ?? '')
                <select name="{{ $field }}" class="input-material{{ $errors->has($field)?' validation_error':'' }}">
                    <option value="">Vehicle Type</option>
                    <option {{ $oldData == 'Car'?"selected":"" }} value="Car">Car</option>
                    <option {{ $oldData == 'Cargo Van'?"selected":"" }} value="Cargo Van">Cargo Van</option>
                    <option {{ $oldData == 'Sprinter'?"selected":"" }} value="Sprinter">Sprinter</option>
                    <option {{ $oldData == 'Large Straight'?"selected":"" }} value="Large Straight">Large Straight</option>
                    <option {{ $oldData == 'Small Straight'?"selected":"" }} value="Small Straight">Small Straight</option>
                    <option {{ $oldData == 'Tractor & Trailer'?"selected":"" }} value="Tractor & Trailer">Tractor & Trailer</option>
                </select>
                @if($errors->has($field))
                    <div class="js-validate-error-label" style="color: #B81111">{{ $errors->first($field) }}</div>
                @endif
            </div>
        </div>
    @else
        @include($theme_path.'common.form.col_6_div',['field' => $field,'type' => $type])
    @endif
@endforeach
