@extends($theme_path . 'common.layout')

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0 py-3">
            <li class="breadcrumb-item active fw-light" aria-current="page">Dashboard</li>
        </ol>
    </nav>
@endsection

@section('content')
    <!-- Dashboard Counts Section-->
    <section class="pb-0">
        <div class="container-fluid">
            <div class="card mb-0">
                <div class="card-body">
                    <div class="row gx-5 bg-white">
                        <!-- Item -->
                        <div class="col-xl-3 col-sm-6 py-4 border-lg-end border-gray-200">
                            <div class="d-flex align-items-center">
                                <div class="icon flex-shrink-0 bg-violet">
                                    <img style="height: 22px;width: 22px;margin-right: 5px;filter: invert(1);"
                                        src="https://cdn3.iconfinder.com/data/icons/car-icons-front-views/451/Compact_Car_Front_View-512.png" />
                                </div>
                                <div class="mx-3">
                                    <h6 class="h4 fw-light text-gray-600 mb-3">Total<br>Vehicles</h6>
                                    <div class="progress" style="height: 4px">
                                        <div class="progress-bar bg-violet" role="progressbar"
                                            style="width: 25%; height: 4px;" aria-valuenow="25" aria-valuemin="0"
                                            aria-valuemax="100"></div>
                                    </div>
                                </div>
                                <div class="number"><strong class="text-lg">{{ \App\Models\Vehicle::count() }}</strong>
                                </div>
                            </div>
                        </div>
                        <!-- Item -->
                        <div class="col-xl-3 col-sm-6 py-4 border-lg-end border-gray-200">
                            <div class="d-flex align-items-center">
                                <div class="icon flex-shrink-0 bg-red">
                                    <img class="sidebar-image"
                                        style="height: 22px;width: 22px;margin-right: 5px;filter: invert(1);"
                                        src="https://icon-library.com/images/driver-icon-png/driver-icon-png-24.jpg" />
                                </div>
                                <div class="mx-3">
                                    <h6 class="h4 fw-light text-gray-600 mb-3">Total<br>Drivers</h6>
                                    <div class="progress" style="height: 4px">
                                        <div class="progress-bar bg-red" role="progressbar" style="width: 70%; height: 4px;"
                                            aria-valuenow="70" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                                <div class="number"><strong class="text-lg">{{ \App\Models\Driver::count() }}</strong></div>
                            </div>
                        </div>
                        <!-- Item -->
                        <div class="col-xl-3 col-sm-6 py-4 border-lg-end border-gray-200">
                            <div class="d-flex align-items-center">
                                <div class="icon flex-shrink-0 bg-green">
                                    <svg class="svg-icon svg-icon-sm svg-icon-heavy">
                                        <use xlink:href="#numbers-1"> </use>
                                    </svg>
                                </div>
                                <div class="mx-3">
                                    <h6 class="h4 fw-light text-gray-600 mb-3">Available<br>Drivers</h6>
                                    <div class="progress" style="height: 4px">
                                        <div class="progress-bar bg-green" role="progressbar"
                                            style="width: 40%; height: 4px;" aria-valuenow="40" aria-valuemin="0"
                                            aria-valuemax="100"></div>
                                    </div>
                                </div>
                                <div class="number"><strong class="text-lg">{{ $totalAvailableDrivers ?? 0 }}</strong></div>
                            </div>
                        </div>
                        <!-- Item -->
                        <div class="col-xl-3 col-sm-6 py-4 border-lg-end border-gray-200">
                            <div class="d-flex align-items-center">
                                <div class="icon flex-shrink-0 bg-green">
                                    <svg class="svg-icon svg-icon-sm svg-icon-heavy">
                                        <use xlink:href="#numbers-1"> </use>
                                    </svg>
                                </div>
                                <div class="mx-3">
                                    <h6 class="h4 fw-light text-gray-600 mb-3">Total<br>Work</h6>
                                    <div class="progress" style="height: 4px">
                                        <div class="progress-bar bg-green" role="progressbar"
                                            style="width: 40%; height: 4px;" aria-valuenow="40" aria-valuemin="0"
                                            aria-valuemax="100"></div>
                                    </div>
                                </div>
                                <div class="number"><strong class="text-lg">{{ \App\Models\Work::count() }}</strong></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Dashboard Header Section    -->
    {{-- <section class="pb-0">
        <div class="container-fluid">
            <div class="row align-items-stretch">
                <!-- Statistics -->
                <div class="col-lg-3 col-12">
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="icon flex-shrink-0 bg-red"><i class="fas fa-tasks"></i></div>
                                <div class="ms-3"><strong class="text-lg d-block lh-1 mb-1">234</strong><small class="text-uppercase text-gray-500 small d-block lh-1">Applications</small></div>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="icon flex-shrink-0 bg-green"><i class="far fa-calendar"></i></div>
                                <div class="ms-3"><strong class="text-lg d-block lh-1 mb-1">152</strong><small class="text-uppercase text-gray-500 small d-block lh-1">Interviews</small></div>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-0">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="icon flex-shrink-0 bg-orange"><i class="far fa-paper-plane"></i></div>
                                <div class="ms-3"><strong class="text-lg d-block lh-1 mb-1">147</strong><small class="text-uppercase text-gray-500 small d-block lh-1">Forwards</small></div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Line Chart            -->
                <div class="col-lg-6 col-12">
                    <div class="card mb-0 h-100">
                        <div class="card-body">
                            <canvas id="lineCahrt"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-12">
                    <!-- Bar Chart   -->
                    <div class="card">
                        <div class="card-body"><strong class="h2 mb-0 d-block text-violet">95%</strong><small class="text-gray-500 small text-uppercase d-block mb-3">Current Server Uptime</small>
                            <canvas id="barChartHome"></canvas>
                        </div>
                    </div>
                    <!-- Numbers-->
                    <div class="card mb-0">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="icon flex-shrink-0 bg-green"><i class="fas fa-chart-area"></i></div>
                                <div class="ms-3"><strong class="text-lg mb-0 d-block lh-1">99.9%</strong><small class="text-gray-500 small text-uppercase">Success Rate</small></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> --}}
    <!-- Projects Section-->
    {{-- <section class="pb-0">
        <div class="container-fluid">
            <!-- Project-->
            <div class="card mb-3">
                <div class="card-body p-3">
                    <div class="row align-items-center gx-lg-5 gy-3">
                        <div class="col-lg-6 border-lg-end">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center"><img class="img-fluid shadow-sm" src="{{ asset('themes/prabin_dashboard/img/project-1.jpg') }}" alt="..." width="50">
                                    <div class="ms-3">
                                        <h3 class="h4 text-gray-700 mb-0">Project Title</h3><small class="text-gray-500">Lorem Ipsum Dolor</small>
                                    </div>
                                </div><span class="text-sm text-gray-600 d-none d-sm-block">Today at 4:24 AM</span>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="d-flex align-items-center">
                                <p class="d-flex mb-0 text-gray-600 text-sm d-flex align-items-center flex-shrink-0"><i class="far fa-clock me-1"></i>12:00 PM</p>
                                <p class="d-flex mb-0 mx-3 text-gray-600 text-sm d-flex align-items-center flex-shrink-0"><i class="far fa-comment me-1"></i>20</p>
                                <div class="progress w-100" style="height: 5px; max-width: 15rem">
                                    <div class="progress-bar bg-red" role="progressbar" style="width: 45%; height: 6px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Project-->
            <div class="card mb-3">
                <div class="card-body p-3">
                    <div class="row align-items-center gx-lg-5 gy-3">
                        <div class="col-lg-6 border-lg-end">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center"><img class="img-fluid shadow-sm" src="{{ asset('themes/prabin_dashboard/img/project-2.jpg') }}" alt="..." width="50">
                                    <div class="ms-3">
                                        <h3 class="h4 text-gray-700 mb-0">Project Title</h3><small class="text-gray-500">Lorem Ipsum Dolor</small>
                                    </div>
                                </div><span class="text-sm text-gray-600 d-none d-sm-block">Today at 4:24 AM</span>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="d-flex align-items-center">
                                <p class="d-flex mb-0 text-gray-600 text-sm d-flex align-items-center flex-shrink-0"><i class="far fa-clock me-1"></i>12:00 PM</p>
                                <p class="d-flex mb-0 mx-3 text-gray-600 text-sm d-flex align-items-center flex-shrink-0"><i class="far fa-comment me-1"></i>20</p>
                                <div class="progress w-100" style="height: 5px; max-width: 15rem">
                                    <div class="progress-bar bg-green" role="progressbar" style="width: 45%; height: 6px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Project-->
            <div class="card mb-3">
                <div class="card-body p-3">
                    <div class="row align-items-center gx-lg-5 gy-3">
                        <div class="col-lg-6 border-lg-end">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center"><img class="img-fluid shadow-sm" src="{{ asset('themes/prabin_dashboard/img/project-3.jpg') }}" alt="..." width="50">
                                    <div class="ms-3">
                                        <h3 class="h4 text-gray-700 mb-0">Project Title</h3><small class="text-gray-500">Lorem Ipsum Dolor</small>
                                    </div>
                                </div><span class="text-sm text-gray-600 d-none d-sm-block">Today at 4:24 AM</span>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="d-flex align-items-center">
                                <p class="d-flex mb-0 text-gray-600 text-sm d-flex align-items-center flex-shrink-0"><i class="far fa-clock me-1"></i>12:00 PM</p>
                                <p class="d-flex mb-0 mx-3 text-gray-600 text-sm d-flex align-items-center flex-shrink-0"><i class="far fa-comment me-1"></i>20</p>
                                <div class="progress w-100" style="height: 5px; max-width: 15rem">
                                    <div class="progress-bar bg-violet" role="progressbar" style="width: 45%; height: 6px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Project-->
            <div class="card mb-0">
                <div class="card-body p-3">
                    <div class="row align-items-center gx-lg-5 gy-3">
                        <div class="col-lg-6 border-lg-end">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center"><img class="img-fluid shadow-sm" src="{{ asset('themes/prabin_dashboard/img/project-4.jpg') }}" alt="..." width="50">
                                    <div class="ms-3">
                                        <h3 class="h4 text-gray-700 mb-0">Project Title</h3><small class="text-gray-500">Lorem Ipsum Dolor</small>
                                    </div>
                                </div><span class="text-sm text-gray-600 d-none d-sm-block">Today at 4:24 AM</span>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="d-flex align-items-center">
                                <p class="d-flex mb-0 text-gray-600 text-sm d-flex align-items-center flex-shrink-0"><i class="far fa-clock me-1"></i>12:00 PM</p>
                                <p class="d-flex mb-0 mx-3 text-gray-600 text-sm d-flex align-items-center flex-shrink-0"><i class="far fa-comment me-1"></i>20</p>
                                <div class="progress w-100" style="height: 5px; max-width: 15rem">
                                    <div class="progress-bar bg-orange" role="progressbar" style="width: 45%; height: 6px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> --}}
    <!-- Client Section-->
    {{-- <section class="pb-0" style="margin-bottom: 40px;">
        <div class="container-fluid">
            <div class="row gy-4">
                <!-- Work Amount  -->
                <div class="col-lg-4">
                    <div class="card mb-0">
                        <div class="card-close">
                            <div class="dropdown">
                                <button class="dropdown-toggle text-sm" type="button" id="closeCard1" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></button>
                                <div class="dropdown-menu dropdown-menu-end shadow-sm" aria-labelledby="closeCard1"><a class="dropdown-item py-1 px-3 remove" href="#"> <i class="fas fa-times"></i>Close</a><a class="dropdown-item py-1 px-3 edit" href="#"> <i class="fas fa-cog"></i>Edit</a></div>
                            </div>
                        </div>
                        <div class="card-body d-flex flex-column">
                            <h3 class="mb-1">Work Hours</h3><small class="text-gray-500 d-block mb-0">Lorem ipsum dolor sit amet.</small>
                            <div class="pie-with-centered-text text-center my-5">
                                <canvas class="z-index-20" id="pieChart"></canvas>
                                <div class="text"><strong class="d-block lh-1 text-lg">90</strong><span class="text-gray-500">Hours</span></div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Client Profile -->
                <div class="col-lg-4">
                    <div class="card mb-0">
                        <div class="card-close">
                            <div class="dropdown">
                                <button class="dropdown-toggle text-sm" type="button" id="closeCard1" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></button>
                                <div class="dropdown-menu dropdown-menu-end shadow-sm" aria-labelledby="closeCard1"><a class="dropdown-item py-1 px-3 remove" href="#"> <i class="fas fa-times"></i>Close</a><a class="dropdown-item py-1 px-3 edit" href="#"> <i class="fas fa-cog"></i>Edit</a></div>
                            </div>
                        </div>
                        <div class="card-body text-center">
                            <div class="client-avatar mb-3"><img class="img-fluid rounded-circle shadow-0" src="{{ asset('themes/prabin_dashboard/img/avatar-2.jpg') }}" alt="...">
                                <div class="status bg-green"></div>
                            </div>
                            <h3 class="fw-normal">Jason Doe</h3>
                            <p class="text-sm text-gray-500 mb-1">Web Developer</p><a class="btn btn-faintGreen btn-sm text-white px-4 rounded-pill py-0" href="#">Follow</a>
                            <div class="row py-4 gy-3">
                                <div class="col-4"><strong class="d-block lh-1">20</strong><small>Photos</small></div>
                                <div class="col-4"><strong class="d-block lh-1">54</strong><small>Videos</small></div>
                                <div class="col-4"><strong class="d-block lh-1">235</strong><small>Tasks</small></div>
                            </div>
                            <div class="d-flex justify-content-between"><a class="text-gray-500 text-sm" href="#" target="_blank"><i class="fab fa-facebook-f"></i></a><a class="text-gray-500 text-sm" href="#" target="_blank"><i class="fab fa-twitter"></i></a><a class="text-gray-500 text-sm" href="#" target="_blank"><i class="fab fa-google"></i></a><a class="text-gray-500 text-sm" href="#" target="_blank"><i class="fab fa-instagram"></i></a><a class="text-gray-500 text-sm" href="#" target="_blank"><i class="fab fa-linkedin-in"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Total Overdue             -->
                <div class="col-lg-4">
                    <div class="card mb-0">
                        <div class="card-close">
                            <div class="dropdown">
                                <button class="dropdown-toggle text-sm" type="button" id="closeCard1" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></button>
                                <div class="dropdown-menu dropdown-menu-end shadow-sm" aria-labelledby="closeCard1"><a class="dropdown-item py-1 px-3 remove" href="#"> <i class="fas fa-times"></i>Close</a><a class="dropdown-item py-1 px-3 edit" href="#"> <i class="fas fa-cog"></i>Edit</a></div>
                            </div>
                        </div>
                        <div class="card-body d-flex flex-column">
                            <h3>Total Overdue</h3>
                            <p class="small mb-5 text-gray-500">Lorem ipsum dolor sit amet.</p>
                            <p class="text-xl text-center fw-normal">$20,000</p>
                            <div class="chart mt-auto">
                                <canvas id="lineChart1">                               </canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> --}}
@endsection

@push('js')
    <script src="{{ asset('themes/prabin_dashboard/js/charts-home.js') }}"></script>
@endpush
