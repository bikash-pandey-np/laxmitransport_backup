<li class="sidebar-item{{ Request::is('driver/dashboard')?' active':'' }}"><a class="sidebar-link" href="{{ route('driver.index') }}">
        <svg class="svg-icon svg-icon-sm svg-icon-heavy me-xl-2">
            <use xlink:href="#real-estate-1"> </use>
        </svg>Dashboard </a></li>

<li class="sidebar-item{{ Request::is('driver/work/on_site')?' active':'' }}"><a class="sidebar-link" href="{{ route('driver.work.index','on_site') }}">
        <img style="height: 22px;width: 22px;margin-right: 5px;" src="https://www.pngkit.com/png/detail/152-1526510_go-to-image-white-construction-icon-png.png"/>
        </svg> Assigned Load </a></li>

<li class="sidebar-item{{ Request::is('driver/work/delivery')?' active':'' }}"><a class="sidebar-link" href="{{ route('driver.work.index','delivery') }}">

        <img style="height: 22px;width: 22px;margin-right: 5px;" src="https://www.pngkit.com/png/detail/152-1526510_go-to-image-white-construction-icon-png.png"/>
        </svg> Worked Load </a></li>

<li class="sidebar-item"><a class="sidebar-link" href="#loadboard" data-bs-toggle="collapse" aria-expanded="{{ Request::is('driver/loadboard*')?'true':'false' }}{{ Request::is('driver/my-loadboard*')?'true':'false' }}">
        <img style="height: 22px;width: 22px;margin-right: 5px;" src="https://www.pngkit.com/png/detail/152-1526510_go-to-image-white-construction-icon-png.png"/>
        </svg> Load Board </a>
    <ul class="collapse list-unstyled{{ Request::is('driver/loadboard*')?' is-open show':'' }}{{ Request::is('driver/my-loadboard*')?' is-open show':'' }}" id="loadboard">
        <li><a class="sidebar-link{{ Request::is('driver/my-loadboard')?' active_sidebar':'' }}" href="{{ route('driver.loadboard.my') }}">Work</a></li>
        <li><a class="sidebar-link{{ Request::is('driver/loadboard')?' active_sidebar':'' }}" href="{{ route('driver.loadboard.index') }}">Find Load</a></li>
    </ul>
</li>

<li class="sidebar-item"><a class="sidebar-link" href="{{ route('driver.chat.message',['role' => 'super-admin', 'id' => 1]) }}">
        <img style="height: 22px;width: 22px;margin-right: 5px;" src="https://www.pngrepo.com/png/309410/180/chat-help.png"/>
        </svg> Help Chat </a></li>

