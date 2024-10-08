@extends($theme_path.'profile.profile_layout')

@section('profile')

    <div class="card mb-0">
        <div class="card-close">
            <div class="dropdown">
                <button class="dropdown-toggle text-sm" type="button" id="closeCard1" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></button>
                <div class="dropdown-menu dropdown-menu-end shadow-sm" aria-labelledby="closeCard1"><a class="dropdown-item py-1 px-3 edit" href="{{ route('super_admin.profile.edit') }}"> <i class="fas fa-cog"></i>Edit Profile</a></div>
            </div>
        </div>
        <div class="card-body d-flex flex-column">
            <h3>{{ $auth->first_name.' '.$auth->last_name }}</h3>
            <form action="{{ route('super_admin.profile.update') }}" method="post">
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