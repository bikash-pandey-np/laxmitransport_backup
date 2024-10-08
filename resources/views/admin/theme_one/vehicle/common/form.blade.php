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
    @else
    @include($theme_path.'common.form.col_6_div',['field' => $field,'type' => $type])
    @endif
    @endforeach

