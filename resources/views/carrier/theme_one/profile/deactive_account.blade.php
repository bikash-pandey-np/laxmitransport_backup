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
            <h3>Deactive Account</h3>
            <form action="{{ route('driver.profile.deactive_account') }}" method="post">
                @csrf

                <div class="row">
                    <div class="col-md-12">
                        <div class="input-material-group mb-3">
                            <textarea class="input-material{{ $errors->has('email')?' validation_error':'' }}" name="deactive_reason" placeholder="Enter reason about deactive" style="padding: 5px 10px"></textarea>
                        </div>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-sm-9 ms-auto">
                        <button class="btn btn-primary" type="submit">Deactive</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection