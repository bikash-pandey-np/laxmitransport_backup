
<div class="col-sm-12">

    <div class="input-material-group mb-3">
        <input class="input-material{{ $errors->has('order_number')?' validation_error':'' }}" id="order_number" type="text"
               name="order_number" value="{{ getValue('order_number',$row ?? null) }}">
        @if($errors->has('order_number'))
            <div class="js-validate-error-label" style="color: #B81111">{{ $errors->first('order_number') }}</div>
        @else
            <label class="label-material" for="order_number">Order Number</label>
        @endif
    </div>
</div>

<div class="col-sm-6">

    <div class="input-material-group mb-3">
        <input class="input-material{{ $errors->has('pickup_city_st_zip_code')?' validation_error':'' }}" id="pickup_city_st_zip_code" type="text"
               name="pickup_city_st_zip_code" value="{{ getValue('pickup_city_st_zip_code',$row ?? null) }}">
        @if($errors->has('pickup_city_st_zip_code'))
            <div class="js-validate-error-label" style="color: #B81111">{{ $errors->first('pickup_city_st_zip_code') }}</div>
        @else
            <label class="label-material" for="pickup_city_st_zip_code">Pickup City ST Zip code</label>
        @endif
    </div>

    <div class="input-material-group mb-3">
        <input class="datepicker input-material{{ $errors->has('pickup_date')?' validation_error':'' }}" id="pickup_date" type="text"
               name="pickup_date" value="{{ getValue('pickup_date',$row ?? null) }}">
        @if($errors->has('pickup_date'))
            <div class="js-validate-error-label" style="color: #B81111">{{ $errors->first('pickup_date') }}</div>
        @else
            <label class="label-material" for="pickup_date">Pickup Date</label>
        @endif
    </div>

    <div class="input-material-group mb-3">
        <input class="time input-material{{ $errors->has('pickup_time')?' validation_error':'' }}" id="pickup_time" type="text"
               name="pickup_time" value="{{ getValue('pickup_time',$row ?? null,true) }}">
        @if($errors->has('pickup_time'))
            <div class="js-validate-error-label" style="color: #B81111">{{ $errors->first('pickup_time') }}</div>
        @else
            <label class="label-material" for="pickup_time">Pickup Time</label>
        @endif
    </div>

    <div class="input-material-group mb-3">

                @php($oldData = old('vehicle_type') ?? $row['vehicle_type'] ?? '')
                <select name="vehicle_type" class="input-material{{ $errors->has('vehicle_type')?' validation_error':'' }}">
                    <option value="">Vehicle Type</option>
                    <option {{ $oldData == 'Cargo Van'?"selected":"" }} value="Cargo Van">Cargo Van</option>
                    <option {{ $oldData == 'Sprinter'?"selected":"" }} value="Sprinter">Sprinter</option>
                    <option {{ $oldData == 'Large Straight'?"selected":"" }} value="Large Straight">Large Straight</option>
                    <option {{ $oldData == 'Small Straight'?"selected":"" }} value="Small Straight">Small Straight</option>
                    <option {{ $oldData == 'Tractor & Trailer'?"selected":"" }} value="Tractor & Trailer">Tractor & Trailer</option>
                </select>
                @if($errors->has('vehicle_type'))
                    <div class="js-validate-error-label" style="color: #B81111">{{ $errors->first('vehicle_type') }}</div>
                @endif
    </div>

    <div class="input-material-group mb-3">
        <input class="input-material{{ $errors->has('pieces')?' validation_error':'' }}" id="pieces" type="text"
               name="pieces" value="{{ getValue('pieces',$row ?? null) }}">
        @if($errors->has('pieces'))
            <div class="js-validate-error-label" style="color: #B81111">{{ $errors->first('pieces') }}</div>
        @else
            <label class="label-material" for="pieces">Pieces</label>
        @endif
    </div>

    <div class="input-material-group mb-3">
        <input class="input-material{{ $errors->has('weight')?' validation_error':'' }}" id="weight" type="text"
               name="weight" value="{{ getValue('weight',$row ?? null) }}">
        @if($errors->has('weight'))
            <div class="js-validate-error-label" style="color: #B81111">{{ $errors->first('weight') }}</div>
        @else
            <label class="label-material" for="weight">Weight</label>
        @endif
    </div>

    <div class="input-material-group mb-3">
        <input class="input-material{{ $errors->has('dims')?' validation_error':'' }}" id="dims" type="text"
               name="dims" value="{{ getValue('dims',$row ?? null) }}">
        @if($errors->has('dims'))
            <div class="js-validate-error-label" style="color: #B81111">{{ $errors->first('dims') }}</div>
        @else
            <label class="label-material" for="dims">DIMS</label>
        @endif
    </div>

    <div class="input-material-group mb-3">
        <input class="input-material{{ $errors->has('email')?' validation_error':'' }}" id="email" type="text"
               name="email" value="{{ getValue('email',$row ?? null) }}">
        @if($errors->has('email'))
            <div class="js-validate-error-label" style="color: #B81111">{{ $errors->first('email') }}</div>
        @else
            <label class="label-material" for="email">Email</label>
        @endif
    </div>

</div>

<div class="col-sm-6">

    <div class="input-material-group mb-3">
        <input class="input-material{{ $errors->has('drop_city_st_zip_code')?' validation_error':'' }}" id="drop_city_st_zip_code" type="text"
               name="drop_city_st_zip_code" value="{{ getValue('drop_city_st_zip_code',$row ?? null) }}">
        @if($errors->has('drop_city_st_zip_code'))
            <div class="js-validate-error-label" style="color: #B81111">{{ $errors->first('drop_city_st_zip_code') }}</div>
        @else
            <label class="label-material" for="drop_city_st_zip_code">Drop City ST Zip Code</label>
        @endif
    </div>

    <div class="input-material-group mb-3">
        <input class="datepicker input-material{{ $errors->has('drop_date')?' validation_error':'' }}" id="drop_date" type="text"
               name="drop_date" value="{{ getValue('drop_date',$row ?? null) }}">
        @if($errors->has('drop_date'))
            <div class="js-validate-error-label" style="color: #B81111">{{ $errors->first('drop_date') }}</div>
        @else
            <label class="label-material" for="drop_date">Drop Date</label>
        @endif
    </div>

    <div class="input-material-group mb-3">
        <input class="time input-material{{ $errors->has('drop_time')?' validation_error':'' }}" id="drop_time" type="text"
               name="drop_time" value="{{ getValue('drop_time',$row ?? null,true) }}">
        @if($errors->has('drop_time'))
            <div class="js-validate-error-label" style="color: #B81111">{{ $errors->first('drop_time') }}</div>
        @else
            <label class="label-material" for="drop_time">Drop Time</label>
        @endif
    </div>

    <div class="input-material-group mb-3">
        <input class="input-material{{ $errors->has('miles')?' validation_error':'' }}" id="miles" type="text"
               name="miles" value="{{ getValue('miles',$row ?? null) }}">
        @if($errors->has('miles'))
            <div class="js-validate-error-label" style="color: #B81111">{{ $errors->first('miles') }}</div>
        @else
            <label class="label-material" for="miles">Miles</label>
        @endif
    </div>

    <div class="input-material-group mb-3">
        <textarea class="time input-material{{ $errors->has('admin_note')?' validation_error':'' }}" id="admin_note" placeholder="Admin Note" rows="10"
                  name="admin_note">{{ getValue('admin_note',$row ?? null) }}</textarea>
        @if($errors->has('admin_note'))
            <div class="js-validate-error-label" style="color: #B81111">{{ $errors->first('admin_note') }}</div>
        @endif
    </div>

</div>
