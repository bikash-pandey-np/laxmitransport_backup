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
            <table class="table">
                <tbody>
                <tr>
                    <th>{{ ucfirst(str_replace('_',' ','first_name')) }}</th>
                    <td>{{ $auth->first_name }}</td>
                </tr>
                <tr>
                    <th>{{ ucfirst(str_replace('_',' ','last_name')) }}</th>
                    <td>{{ $auth->last_name }}</td>
                </tr>
                <tr>
                    <th>{{ ucfirst(str_replace('_',' ','email')) }}</th>
                    <td>{{ $auth->email }}</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>

@endsection