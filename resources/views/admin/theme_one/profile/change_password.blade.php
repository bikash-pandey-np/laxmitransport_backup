@extends($theme_path.'profile.profile_layout')

@section('profile')

    <div class="card mb-0">
        <div class="card-close">
            <div class="dropdown">
                <button class="dropdown-toggle text-sm" type="button" id="closeCard1" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></button>
                <div class="dropdown-menu dropdown-menu-end shadow-sm" aria-labelledby="closeCard1"><a class="dropdown-item py-1 px-3 edit" href="{{ route('admin.profile.edit') }}"> <i class="fas fa-cog"></i>Edit Profile</a></div>
            </div>
        </div>
        <div class="card-body d-flex flex-column">
            <h3>{{ $auth->first_name.' '.$auth->last_name }}</h3>
            <form action="{{ route('admin.change.password.update') }}" method="post">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="input-material-group mb-3">
                            <input class="input-material{{ $errors->has('old_password')?' validation_error':'' }}" id="old_password" type="password" name="old_password">
                            @if($errors->has('old_password'))
                                <div class="js-validate-error-label" style="color: #B81111">{{ $errors->first('old_password') }}</div>
                            @else
                                <label class="label-material" for="old_password">Old Password</label>
                            @endif
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="input-material-group mb-3">
                            <input class="input-material{{ $errors->has('password')?' validation_error':'' }}" id="password" type="password" name="password">
                            @if($errors->has('password'))
                                <div class="js-validate-error-label" style="color: #B81111">{{ $errors->first('password') }}</div>
                            @else
                                <label class="label-material" for="password">Password</label>
                            @endif
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="input-material-group mb-3">
                            <input class="input-material{{ $errors->has('confirm_password')?' validation_error':'' }}" id="confirm_password" type="password" name="confirm_password">
                            @if($errors->has('confirm_password'))
                                <div class="js-validate-error-label" style="color: #B81111">{{ $errors->first('confirm_password') }}</div>
                            @else
                                <label class="label-material" for="confirm_password">Confirm Password</label>
                            @endif
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