<div class="col-sm-6">
    <div class="input-material-group mb-3">
        <input class="input-material{{ $errors->has('first_name')?' validation_error':'' }}" id="first_name" type="text" name="first_name"  value="{{ old('first_name') ?? $row->first_name ?? '' }}">
        @if($errors->has('first_name'))
            <div class="js-validate-error-label" style="color: #B81111">{{ $errors->first('first_name') }}</div>
            @else
            <label class="label-material" for="first_name">First Name</label>
        @endif
    </div>
</div>

<div class="col-sm-6">
    <div class="input-material-group mb-3">
        <input class="input-material{{ $errors->has('last_name')?' validation_error':'' }}" id="last_name" type="text" name="last_name"  value="{{ old('last_name') ?? $row->last_name ?? '' }}">
        @if($errors->has('last_name'))
            <div class="js-validate-error-label" style="color: #B81111">{{ $errors->first('last_name') }}</div>
            @else
            <label class="label-material" for="last_name">Last Name</label>
        @endif
    </div>
</div>

<div class="col-sm-6">
    <div class="input-material-group mb-3">
        <input class="input-material{{ $errors->has('mobile_number')?' validation_error':'' }}" id="mobile_number" type="text" name="mobile_number"  value="{{ old('mobile_number') ?? $row->mobile_number ?? '' }}">
        @if($errors->has('mobile_number'))
            <div class="js-validate-error-label" style="color: #B81111">{{ $errors->first('mobile_number') }}</div>
            @else
            <label class="label-material" for="mobile_number">Mobile Number</label>
        @endif
    </div>
</div>

<div class="col-sm-6">
    <div class="input-material-group mb-3">
        <input class="input-material{{ $errors->has('email')?' validation_error':'' }}" id="email" type="email" name="email"  value="{{ old('email') ?? $row->email ?? '' }}">
        @if($errors->has('email'))
            <div class="js-validate-error-label" style="color: #B81111">{{ $errors->first('email') }}</div>
            @else
            <label class="label-material" for="email">Email Address</label>
        @endif
    </div>
</div>
