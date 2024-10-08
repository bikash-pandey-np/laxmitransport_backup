<li class="sidebar-item{{ Request::is('carrier/dashboard')?' active':'' }}"><a class="sidebar-link" href="{{ route('carrier.index') }}">
        <svg class="svg-icon svg-icon-sm svg-icon-heavy me-xl-2">
            <use xlink:href="#real-estate-1"> </use>
        </svg>Dashboard </a></li>


<li class="sidebar-item{{ Request::is('carrier/work/on_site')?' active':'' }}"><a class="sidebar-link" href="{{ route('carrier.work.index','on_site') }}">
        <svg class="svg-icon svg-icon-sm svg-icon-heavy me-xl-2">
            <use xlink:href="#real-estate-1"> </use>
        </svg>Assigned Load </a></li>


<li class="sidebar-item{{ Request::is('carrier/work/delivery')?' active':'' }}"><a class="sidebar-link" href="{{ route('carrier.work.index','delivery') }}">
        <svg class="svg-icon svg-icon-sm svg-icon-heavy me-xl-2">
            <use xlink:href="#real-estate-1"> </use>
        </svg>Worked Load </a></li>



<li class="sidebar-item"><a class="sidebar-link" href="#loadboard" data-bs-toggle="collapse" aria-expanded="{{ Request::is('carrier/loadboard*')?'true':'false' }}{{ Request::is('carrier/my-loadboard*')?'true':'false' }}">
        <img style="height: 22px;width: 22px;margin-right: 5px;" src="https://www.pngkit.com/png/detail/152-1526510_go-to-image-white-construction-icon-png.png"/>
        </svg> Load Board </a>
    <ul class="collapse list-unstyled{{ Request::is('carrier/loadboard*')?' is-open show':'' }}{{ Request::is('carrier/my-loadboard*')?' is-open show':'' }}" id="loadboard">
        <li><a class="sidebar-link{{ Request::is('carrier/my-loadboard')?' active_sidebar':'' }}" href="{{ route('carrier.loadboard.my') }}">Work</a></li>
        <li><a class="sidebar-link{{ Request::is('carrier/loadboard')?' active_sidebar':'' }}" href="{{ route('carrier.loadboard.index') }}">Find Load</a></li>
    </ul>
</li>
