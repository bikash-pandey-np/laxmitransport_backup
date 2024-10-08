@extends($theme_path.'profile.profile_layout')

@section('profile')

    <div class="card mb-0">
        <div class="card-close">
            <div class="dropdown">
                <button class="dropdown-toggle text-sm" type="button" id="closeCard1" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></button>
                <div class="dropdown-menu dropdown-menu-end shadow-sm" aria-labelledby="closeCard1"><a class="dropdown-item py-1 px-3 edit" href="{{ route('driver.profile.edit') }}"> <i class="fas fa-cog"></i>Edit Profile</a></div>
            </div>
        </div>
        <div class="card-body d-flex flex-column">
            <h3>{{ $auth->first_name.' '.$auth->last_name }}</h3>
            <form action="{{ route('driver.profile.update') }}" method="post">
                @csrf

                <div class="row">
                    <div class="col-md-12">
                        <div class="input-material-group mb-3">
                            <input class="input-material{{ $errors->has('first_name')?' validation_error':'' }}" id="first_name" type="text" name="first_name"  value="{{ old('first_name') ?? $auth->first_name ?? '' }}">
                            @if($errors->has('first_name'))
                                <div class="js-validate-error-label" style="color: #B81111">{{ $errors->first('first_name') }}</div>
                            @else
                                <label class="label-material" for="first_name">First Name</label>
                            @endif
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="input-material-group mb-3">
                            <input class="input-material{{ $errors->has('last_name')?' validation_error':'' }}" id="last_name" type="text" name="last_name"  value="{{ old('last_name') ?? $auth->last_name ?? '' }}">
                            @if($errors->has('last_name'))
                                <div class="js-validate-error-label" style="color: #B81111">{{ $errors->first('last_name') }}</div>
                            @else
                                <label class="label-material" for="last_name">Last Name</label>
                            @endif
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="input-material-group mb-3">
                            <input class="input-material{{ $errors->has('email')?' validation_error':'' }}" id="email" type="text" name="email"  value="{{ old('email') ?? $auth->email ?? '' }}">
                            @if($errors->has('email'))
                                <div class="js-validate-error-label" style="color: #B81111">{{ $errors->first('email') }}</div>
                            @else
                                <label class="label-material" for="email">Email</label>
                            @endif
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="input-material-group mb-3">
                            <input class="input-material{{ $errors->has('mobile_number')?' validation_error':'' }}" id="mobile_number" type="text" name="mobile_number"  value="{{ old('mobile_number') ?? $auth->mobile_number ?? '' }}">
                            @if($errors->has('mobile_number'))
                                <div class="js-validate-error-label" style="color: #B81111">{{ $errors->first('mobile_number') }}</div>
                            @else
                                <label class="label-material" for="mobile_number">Mobile Number</label>
                            @endif
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="input-material-group mb-3">
                            <input class="input-material{{ $errors->has('address_one')?' validation_error':'' }}" id="address_one" type="text" name="address_one"  value="{{ old('address_one') ?? $auth->address_one ?? '' }}">
                            @if($errors->has('address_one'))
                                <div class="js-validate-error-label" style="color: #B81111">{{ $errors->first('address_one') }}</div>
                            @else
                                <label class="label-material" for="address_one">Address One</label>
                            @endif
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="input-material-group mb-3">
                            <input class="input-material{{ $errors->has('address_two')?' validation_error':'' }}" id="address_two" type="text" name="address_two"  value="{{ old('address_two') ?? $auth->address_two ?? '' }}">
                            @if($errors->has('address_two'))
                                <div class="js-validate-error-label" style="color: #B81111">{{ $errors->first('address_two') }}</div>
                            @else
                                <label class="label-material" for="address_two">Address Two</label>
                            @endif
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="input-material-group mb-3">
                            <label class="" for="admin_can_login">Admin Can Login</label>
                            <br>
                            <input id="admin_can_login" type="radio" name="admin_can_login"  value="1" {{ $auth->admin_can_login == "1" ? "checked" : "" }}> Yes
                            <input id="admin_can_login" type="radio" name="admin_can_login"  value="0" {{ $auth->admin_can_login == "0" ? "checked" : "" }}> No
                        </div>
                    </div>
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
