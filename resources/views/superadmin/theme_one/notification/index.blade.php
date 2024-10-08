@extends($theme_path.'common.layout')

@section('content')

    <section class="pb-0" style="margin-bottom: 40px;">
        <div class="container-fluid">
            <div class="row gy-4">
                <!-- Trending Articles-->
                <div class="col-lg-12">
                    <div class="card mb-0">
                        <div class="card-header position-relative">
                            <div class="card-close">
                                <div class="dropdown">
                                    <button class="dropdown-toggle text-sm" type="button" id="closeCard1"
                                            data-bs-toggle="dropdown" aria-expanded="false"><i
                                            class="fas fa-ellipsis-v"></i></button>
                                    <div class="dropdown-menu dropdown-menu-end shadow-sm" aria-labelledby="closeCard1">
                                        <a class="dropdown-item py-1 px-3 remove" href="#"> <i class="fas fa-times"></i>Close</a><a
                                            class="dropdown-item py-1 px-3 edit" href="#"> <i class="fas fa-cog"></i>Edit</a>
                                    </div>
                                </div>
                            </div>
                            <?php
                            $total = \App\Models\Notification::where([
                                'receiver_type' => 'super_admin',
                                'receiver_id' => auth('super_admin')->id(),
                                'seen' => 0
                            ])->count();
                            ?>
                                <h2 class="h3 mb-0 d-flex align-items-center">Notifications @if($total > 0) <span
                                        class="badge rounded-pill bg-green ms-2 text-xs">{{ $total }} New       </span>@endif
                                </h2>
                        </div>
                        <div class="card-body p-0">

                            @php
                                $notifications = \App\Models\Notification::where([
                                    'receiver_type' => 'super_admin',
                                    'receiver_id' => auth('super_admin')->id()
])->orderBy('id','desc')->get()
                            @endphp

                            @if(count($notifications) > 0)
                                @foreach($notifications as $key => $notification)

                                    @php($bgColor = ($key%2==0)?"white":"#f1f1f1")

                                        <?php
                                        $notification->update(['seen' => 1]);
                                        if ($notification->sender_type == 'driver')
                                            $user = \App\Models\Driver::find($notification->sender_id);
                                        ?>

                                    @if(isset($user->full_name))
                                        <div style="background-color: {{ $bgColor }}" class="p-3 d-flex align-items-center"><img
                                                class="img-fluid rounded-circle p-1 border border-faintGreen flex-shrink-0"
                                                src="{{ $user->image('50_50') }}" alt="..."
                                                width="50">
                                            <div class="ms-3"><a class="d-block" href="#">
                                                    <h3 class="h5 fw-normal text-dark mb-0">{{ $notification->description }}</h3>
                                                </a><small class="text-gray-500">Posted on {{ format_date($notification->created_at) }} by {{ $user->full_name }}. </small></div>
                                        </div>
                                    @else
                                        <div style="background-color: {{ $bgColor }}" class="p-3 d-flex align-items-center"><img
                                                class="img-fluid rounded-circle p-1 border border-faintGreen flex-shrink-0"
                                                src="{{ asset('themes/prabin_dashboard/img/avatar-1.jpg') }}" alt="..."
                                                width="50">
                                            <div class="ms-3"><a class="d-block" href="#">
                                                    <h3 class="h5 fw-normal text-dark mb-0">{{ $notification->description }}</h3>
                                                </a>
                                            </div>
                                        </div>
                                    @endif

                                @endforeach
                            @else

                                <div class="p-3 d-flex align-items-center">
                                    <div class="ms-3"><a class="d-block" href="#">
                                            <h3 class="h5 fw-normal text-dark mb-0">No Notification</h3></a></div>
                                </div>

                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
