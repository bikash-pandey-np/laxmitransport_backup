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
                                    <button class="dropdown-toggle text-sm" type="button" id="closeCard1" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></button>
                                    <div class="dropdown-menu dropdown-menu-end shadow-sm" aria-labelledby="closeCard1"><a class="dropdown-item py-1 px-3 remove" href="#"> <i class="fas fa-times"></i>Close</a><a class="dropdown-item py-1 px-3 edit" href="#"> <i class="fas fa-cog"></i>Edit</a></div>
                                </div>
                            </div>
                            <h2 class="h3 mb-0 d-flex align-items-center">Trending Articles   <span class="badge rounded-pill bg-green ms-2 text-xs">4 New       </span></h2>
                        </div>
                        <div class="card-body p-0">
                            <div class="p-3 d-flex align-items-center"><img class="img-fluid rounded-circle p-1 border border-faintGreen flex-shrink-0" src="{{ asset('themes/prabin_dashboard/img/avatar-1.jpg') }}" alt="..." width="50">
                                <div class="ms-3"><a class="d-block" href="#">
                                        <h3 class="h5 fw-normal text-dark mb-0">Lorem Ipsum Dolor</h3></a><small class="text-gray-500">Posted on 5th June 2017 by Aria Smith.   </small></div>
                            </div>
                            <div class="p-3 d-flex align-items-center bg-light"><img class="img-fluid rounded-circle p-1 border border-faintGreen flex-shrink-0" src="{{ asset('themes/prabin_dashboard/img/avatar-2.jpg') }}" alt="..." width="50">
                                <div class="ms-3"><a class="d-block" href="#">
                                        <h3 class="h5 fw-normal text-dark mb-0">Lorem Ipsum Dolor</h3></a><small class="text-gray-500">Posted on 5th June 2017 by Frank Williams.   </small></div>
                            </div>
                            <div class="p-3 d-flex align-items-center"><img class="img-fluid rounded-circle p-1 border border-faintGreen flex-shrink-0" src="{{ asset('themes/prabin_dashboard/img/avatar-3.jpg') }}" alt="..." width="50">
                                <div class="ms-3"><a class="d-block" href="#">
                                        <h3 class="h5 fw-normal text-dark mb-0">Lorem Ipsum Dolor</h3></a><small class="text-gray-500">Posted on 5th June 2017 by Ashley Wood.   </small></div>
                            </div>
                            <div class="p-3 d-flex align-items-center bg-light"><img class="img-fluid rounded-circle p-1 border border-faintGreen flex-shrink-0" src="{{ asset('themes/prabin_dashboard/img/avatar-4.jpg') }}" alt="..." width="50">
                                <div class="ms-3"><a class="d-block" href="#">
                                        <h3 class="h5 fw-normal text-dark mb-0">Lorem Ipsum Dolor</h3></a><small class="text-gray-500">Posted on 5th June 2017 by Jason Doe.   </small></div>
                            </div>
                            <div class="p-3 d-flex align-items-center"><img class="img-fluid rounded-circle p-1 border border-faintGreen flex-shrink-0" src="{{ asset('themes/prabin_dashboard/img/avatar-5.jpg') }}" alt="..." width="50">
                                <div class="ms-3"><a class="d-block" href="#">
                                        <h3 class="h5 fw-normal text-dark mb-0">Lorem Ipsum Dolor</h3></a><small class="text-gray-500">Posted on 5th June 2017 by Sam Martinez.   </small></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection