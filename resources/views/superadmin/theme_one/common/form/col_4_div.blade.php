@php($fieldTitle = $titleLabel ?? ucwords(str_replace('_',' ',$field)))

@if(isset($type) && $type == 'string')
    <div class="col-sm-4">
        <div class="input-material-group mb-3">
            <input class="input-material{{ $errors->has($field)?' validation_error':'' }}" id="{{ $field }}" type="text"
                   name="{{ $field }}" value="{{ old($field) ?? $row[$field] ?? '' }}">
            @if($errors->has($field))
                <div class="js-validate-error-label" style="color: #B81111">{{ $errors->first($field) }}</div>
            @else
                <label class="label-material" for="{{ $field }}">{{ $fieldTitle }}</label>
            @endif
        </div>
    </div>
@elseif(isset($type) && $type == 'datepicker')
    <div class="col-sm-4">
        <div class="input-material-group mb-3">
            <input class="input-material{{ $errors->has($field)?' validation_error':'' }} datepicker" id="{{ $field }}"
                   type="text"
                   name="{{ $field }}" value="{{ old($field) ?? $row[$field] ?? '' }}">
            @if($errors->has($field))
                <div class="js-validate-error-label" style="color: #B81111">{{ $errors->first($field) }}</div>
            @else
                <label class="label-material" for="{{ $field }}">{{ $fieldTitle }}</label>
            @endif
        </div>
    </div>
@elseif(isset($type) && $type == 'text_area')
    <div class="col-sm-4">
        <div class="input-material-group mb-3">
            <textarea class="input-material{{ $errors->has($field)?' validation_error':'' }}" placeholder="{{ $fieldTitle }}" id="{{ $field }}" row="1"
                      name="{{ $field }}">{{ old($field) ?? $row[$field] ?? '' }}</textarea>
            @if($errors->has($field))
                <div class="js-validate-error-label" style="color: #B81111">{{ $errors->first($field) }}</div>
            @else
                {{--<label class="label-material" for="{{ $field }}">{{ $fieldTitle }}</label>--}}
            @endif
        </div>
    </div>
@elseif(isset($type) && $type == 'number')
    <div class="col-sm-4">
        <div class="input-material-group mb-3">
            <input class="input-material{{ $errors->has($field)?' validation_error':'' }}" id="{{ $field }}"
                   type="number" step="0.01"
                   name="{{ $field }}" value="{{ old($field) ?? $row[$field] ?? '' }}">
            @if($errors->has($field))
                <div class="js-validate-error-label" style="color: #B81111">{{ $errors->first($field) }}</div>
            @else
                <label class="label-material" for="{{ $field }}">{{ $fieldTitle }}</label>
            @endif
        </div>
    </div>
@elseif(isset($type) && $type == 'email')
    <div class="col-sm-4">
        <div class="input-material-group mb-3">
            <input class="input-material{{ $errors->has($field)?' validation_error':'' }}" id="{{ $field }}"
                   type="email"
                   name="{{ $field }}" value="{{ old($field) ?? $row[$field] ?? '' }}">
            @if($errors->has($field))
                <div class="js-validate-error-label" style="color: #B81111">{{ $errors->first($field) }}</div>
            @else
                <label class="label-material" for="{{ $field }}">{{ $fieldTitle }}</label>
            @endif
        </div>
    </div>
@elseif(isset($type) && $type == 'yes_no')
    <div class="col-sm-4">
        <div class="input-material-group mb-3">
            <select name="{{ $field }}" class="input-material{{ $errors->has($field)?' validation_error':'' }}"
                    id="{{ $field }}">
                <option value="" disabled selected>{{ $fieldTitle }}</option>
                <option {{ (isset($row) && $row[$field] == 'yes')?'selected':'' }} value="yes">Yes</option>
                <option {{ (isset($row) && $row[$field] == 'no')?'selected':'' }}value="no">No</option>
            </select>
            @if($errors->has($field))
                <div class="js-validate-error-label" style="color: #B81111">{{ $errors->first($field) }}</div>
            @else
                {{--<label class="label-material" for="{{ $field }}">{{ ucwords(str_replace('_',' ',$field)) }}</label>--}}
            @endif
        </div>
    </div>
@elseif(isset($type) && $type == 'active_deactive')
    <div class="col-sm-4">
        <div class="input-material-group mb-3">
            <select name="{{ $field }}" class="input-material{{ $errors->has($field)?' validation_error':'' }}"
                    id="{{ $field }}">
                <option value="" disabled selected>{{ $fieldTitle }}</option>
                <option {{ (isset($row) && $row[$field] == 'active')?'selected':'' }} value="active">Active</option>
                <option {{ (isset($row) && $row[$field] == 'de_active')?'selected':'' }} value="de_active">De-active</option>
            </select>
            @if($errors->has($field))
                <div class="js-validate-error-label" style="color: #B81111">{{ $errors->first($field) }}</div>
            @else
                {{--<label class="label-material" for="{{ $field }}">{{ ucwords(str_replace('_',' ',$field)) }}</label>--}}
            @endif
        </div>
    </div>
@else

@endif
