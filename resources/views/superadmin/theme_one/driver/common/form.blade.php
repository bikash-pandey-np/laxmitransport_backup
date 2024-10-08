@foreach (config('form.driver') as $field => $type)
    @if ($field == 'unit_number')
        <div class="col-sm-6">
            <div class="input-material-group mb-3">
                <input class="input-material{{ $errors->has($field) ? ' validation_error' : '' }}" id="{{ $field }}"
                    type="text" name="{{ $field }}" value="{{ old($field) ?? ($row[$field] ?? '') }}">
                @if ($errors->has($field))
                    <div class="js-validate-error-label" style="color: #B81111">{{ $errors->first($field) }}</div>
                @else
                    <label class="label-material" for="{{ $field }}">Unit</label>
                @endif
            </div>
        </div>
    @elseif($field == 'billed_mileage_type')
        <div class="col-sm-6">
            <div class="input-material-group mb-3">
                <input class="input-material{{ $errors->has($field) ? ' validation_error' : '' }}" id="{{ $field }}"
                    type="text" name="{{ $field }}" value="{{ old($field) ?? ($row[$field] ?? '') }}">
                @if ($errors->has($field))
                    <div class="js-validate-error-label" style="color: #B81111">{{ $errors->first($field) }}</div>
                @else
                    <label class="label-material" for="{{ $field }}">Odometer Mileage Type</label>
                @endif
            </div>
        </div>
    @elseif($field == 'address_one' || $field == 'address_two')
        @include($theme_path . 'common.form.col_12_div', ['field' => $field, 'type' => $type])
    @elseif($field == 'city' || $field == 'state' || $field == 'zip')
        @include($theme_path . 'common.form.col_4_div', ['field' => $field, 'type' => $type])
    @else
        @include($theme_path . 'common.form.col_6_div', ['field' => $field, 'type' => $type])
    @endif
@endforeach

{{-- <div class="col-sm-12"> --}}
{{--    <div class="input-material-group mb-3"> --}}
{{--        <label for="first_name">Licence State</label> --}}
{{--        <br> --}}
{{--        <select name="licence_state" class="input-material{{ $errors->has($field)?' validation_error':'' }}"> --}}
{{--            @foreach (config('form.us_state') as $item) --}}
{{--                <option value="{{ $item }}">{{ $item }}</option> --}}
{{--            @endforeach --}}
{{--        </select> --}}
{{--    </div> --}}
{{--    @if (isset($row)) --}}
{{--        <img src="{{ $row->image('300_300') }}" style="width: 250px"> --}}
{{--    @endif --}}
{{-- </div> --}}

</div>

<div class="row">

    {{-- <div class="col-sm-6">
                <div class="input-material-group mb-3">
                    <label for="first_name">Profile Picture</label>
                    <br>
                    <input id="first_name" type="file" name="image">
                </div>
                @if (isset($row))
                    <img src="{{ $row->image('300_300') }}" style="width: 250px">
                @endif
            </div> --}}

    {{--            <div class="col-sm-6"> --}}
    {{--                <div class="input-material-group mb-3"> --}}
    {{--                    <label for="front_citizenship">Front Citizenship/Passport/Permanent Resident CARD</label> --}}
    {{--                    <br> --}}
    {{--                    <input id="front_citizenship" type="file" name="front_citizenship"> --}}
    {{--                </div> --}}
    {{--                @if (isset($row)) --}}
    {{--                    <img src="{{ $row->frontCitizenship('300_300') }}" style="width: 250px"> --}}
    {{--                @endif --}}
    {{--            </div> --}}

    {{-- <div class="col-sm-6">
                <div class="input-material-group mb-3">
                    <label for="front_license">Driver’s License front</label>
                    <br>
                    <input id="front_license" type="file" name="front_license">
                </div>
                @if (isset($row))
                    <img src="{{ $row->frontLicense('300_300') }}" style="width: 250px">
                @endif
            </div> --}}

    {{--            <div class="col-sm-6"> --}}
    {{--                <div class="input-material-group mb-3"> --}}
    {{--                    <label for="back_license">Driver’s License back</label> --}}
    {{--                    <br> --}}
    {{--                    <input id="back_license" type="file" name="back_license"> --}}
    {{--                </div> --}}
    {{--                @if (isset($row)) --}}
    {{--                    <img src="{{ $row->backLicense('300_300') }}" style="width: 250px"> --}}
    {{--                @endif --}}
    {{--            </div> --}}

    {{-- <div class="col-sm-6">
                <div class="input-material-group mb-3">
                    <label for="social_security_image">Social Security Image</label>
                    <br>
                    <input id="social_security_image" type="file" name="social_security_image">
                </div>
                @if (isset($row))
                    <img src="{{ $row->socialSecurityImage('300_300') }}" style="width: 250px">
                @endif
            </div> --}}

    {{-- <div class="col-sm-4">
                <div class="input-material-group mb-3">
                    <label for="back_citizenship">Back Citizenship Copy</label>
                    <br>
                    <input id="back_citizenship" type="file" name="back_citizenship">
                </div>
                @if (isset($row))
                    <img src="{{ $row->backCitizenship('300_300') }}" style="width: 250px">
                @endif
            </div> --}}
