<li class="sidebar-item{{ Request::is('admin/dashboard')?' active':'' }}"><a class="sidebar-link" href="{{ route('admin.index') }}">
        <svg class="svg-icon svg-icon-sm svg-icon-heavy me-xl-2">
            <use xlink:href="#real-estate-1"> </use>
        </svg>Dashboard </a></li>

<li class="sidebar-item"><a class="sidebar-link" href="#vehicle" data-bs-toggle="collapse" aria-expanded="{{ Request::is('admin/vehicle*')?'true':'false' }}">
        <img class="sidebar-image" style="height: 22px;width: 22px;margin-right: 5px;" src="https://cdn3.iconfinder.com/data/icons/car-icons-front-views/451/Compact_Car_Front_View-512.png"/>
        </svg>Vehicle </a>
    <ul class="collapse list-unstyled{{ Request::is('admin/vehicle*')?' is-open show':'' }}" id="vehicle">
        <li><a class="sidebar-link{{ Request::is('admin/vehicle')?' active_sidebar':'' }}" href="{{ route('admin.vehicle.index') }}">List</a></li>
        <li><a class="sidebar-link{{ Request::is('admin/vehicle/create')?' active_sidebar':'' }}" href="{{ route('admin.vehicle.create') }}">Create</a></li>
    </ul>
</li>

<li class="sidebar-item"><a class="sidebar-link" href="#driver" data-bs-toggle="collapse" aria-expanded="{{ Request::is('admin/driver*')?'true':'false' }}">
        <img class="sidebar-image" style="height: 22px;width: 22px;margin-right: 5px;" src="https://icon-library.com/images/driver-icon-png/driver-icon-png-24.jpg"/>
        </svg>Driver </a>
    <ul class="collapse list-unstyled{{ Request::is('admin/driver*')?' is-open show':'' }}" id="driver">
        <li><a class="sidebar-link{{ (Request::is('admin/driver') && request('status') !== "pending" && request('status') !== "available")?' active_sidebar':'' }}" href="{{ route('admin.driver.index') }}">List</a></li>
        <li><a class="sidebar-link{{ (Request::is('admin/driver') && request('status') == "pending")?' active_sidebar':'' }}" href="{{ route('admin.driver.index',['status' => 'pending']) }}">Pending</a></li>
        <li><a class="sidebar-link{{ (Request::is('admin/driver') && request('status') == "available")?' active_sidebar':'' }}" href="{{ route('admin.driver.index',['status' => 'available']) }}">Available</a></li>
        <li><a class="sidebar-link{{ Request::is('admin/driver/create')?' active_sidebar':'' }}" href="{{ route('admin.driver.create') }}">Create</a></li>
    </ul>
</li>

<li class="sidebar-item"><a class="sidebar-link" href="#work" data-bs-toggle="collapse" aria-expanded="{{ Request::is('admin/work*')?'true':'false' }}">
        <img class="sidebar-image" style="height: 22px;width: 22px;margin-right: 5px;" src="https://www.pngkit.com/png/detail/152-1526510_go-to-image-white-construction-icon-png.png"/>
        </svg> Order </a>
    <ul class="collapse list-unstyled{{ Request::is('admin/work*')?' is-open show':'' }}" id="work">
        <li><a class="sidebar-link{{ (Request::is('admin/work') && request('status') == 'delivery')?' active_sidebar':'' }}" href="{{ route('admin.work.index',['status' => 'delivery']) }}">Completed Orders</a></li>
        <li><a class="sidebar-link{{ (Request::is('admin/work') && request('admin_status_approved') == 'zero')?' active_sidebar':'' }}" href="{{ route('admin.work.index',['admin_status_approved' => 'zero']) }}">Pending Approved</a></li>
        <li><a class="sidebar-link{{ (Request::is('admin/work') && request('admin_status_approved') !== 'zero' && request('status') !== 'delivery')?' active_sidebar':'' }}" href="{{ route('admin.work.index') }}">List</a></li>
        <li><a class="sidebar-link{{ Request::is('admin/work/create')?' active_sidebar':'' }}" href="{{ route('admin.work.create') }}">Create</a></li>
    </ul>
</li>
