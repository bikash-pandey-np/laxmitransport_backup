<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Speedy</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="robots" content="all,follow">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,700">
    <link rel="stylesheet"
          href="http://192.168.0.109:8000/themes/prabin_dashboard/vendor/choices.js/public/assets/styles/choices.min.css">
    <link rel="stylesheet" id="theme-stylesheet" href="http://192.168.0.109:8000/themes/prabin_dashboard/css/style.default.css">
    <link rel="stylesheet" href="http://192.168.0.109:8000/themes/prabin_dashboard/css/custom.css">
    <link rel="shortcut icon" href="http://192.168.0.109:8000/themes/prabin_dashboard/img/niraj.jpg">
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <style>
        .active_sidebar {
            color: #fff;
            border-left: 4px solid #3b25e6;
            background: #796AEE !important;
        }
    </style>
</head>
<body>
<div class="page">
    <header class="header z-index-50">
        <nav class="navbar py-3 px-0 shadow-sm text-white position-relative">
            <div class="search-box shadow-sm">
                <button class="dismiss d-flex align-items-center">
                    <svg class="svg-icon svg-icon-heavy">
                        <use xlink:href="#close-1"></use>
                    </svg>
                </button>
                <form id="searchForm" action="http://192.168.0.109:8000/super-admin/search" role="search">
                    <input class="form-control shadow-0" type="text" name="q" placeholder="What are you looking for...">
                </form>
            </div>
            <div class="container-fluid w-100">
                <div class="navbar-holder d-flex align-items-center justify-content-between w-100">
                    <div class="navbar-header">
                        <a class="navbar-brand d-none d-sm-inline-block" href="http://192.168.0.109:8000/super-admin/dashboard">
                            <div class="brand-text d-none d-lg-inline-block">
                                <span>Speedy </span><strong></strong></div>
                        </a>
                        <a class="menu-btn active" id="toggle-btn" href="#"><span></span><span></span><span></span></a>
                    </div>
                    <ul class="nav-menu list-unstyled d-flex flex-md-row align-items-md-center">
                        <li class="nav-item d-flex align-items-center"><a id="search" href="#">
                                <svg class="svg-icon svg-icon-xs svg-icon-heavy">
                                    <use xlink:href="#find-1"></use>
                                </svg>
                            </a></li>
                        <li class="nav-item dropdown"><a class="nav-link text-white" id="notifications" href="#"
                                                         data-bs-toggle="dropdown" aria-expanded="false">
                                <svg class="svg-icon svg-icon-xs svg-icon-heavy">
                                    <use xlink:href="#chart-1"></use>
                                </svg>
                                <span class="badge bg-red badge-corner fw-normal">12</span></a>
                            <ul class="dropdown-menu dropdown-menu-end mt-3 shadow-sm" aria-labelledby="notifications">
                                <li><a class="dropdown-item py-3" href="#">
                                        <div class="d-flex">
                                            <div class="icon icon-sm bg-blue">
                                                <svg class="svg-icon svg-icon-xs svg-icon-heavy">
                                                    <use xlink:href="#envelope-1"></use>
                                                </svg>
                                            </div>
                                            <div class="ms-3"><span
                                                        class="h6 d-block fw-normal mb-1 text-xs text-gray-600">You have 6 new messages </span>
                                                <small class="small text-gray-600">4 minutes ago</small>
                                            </div>
                                        </div>
                                    </a></li>
                                <li><a class="dropdown-item py-3" href="#">
                                        <div class="d-flex">
                                            <div class="icon icon-sm bg-green">
                                                <svg class="svg-icon svg-icon-xs svg-icon-heavy">
                                                    <use xlink:href="#chats-1"></use>
                                                </svg>
                                            </div>
                                            <div class="ms-3"><span
                                                        class="h6 d-block fw-normal mb-1 text-xs text-gray-600">New 2 WhatsApp messages</span>
                                                <small class="small text-gray-600">4 minutes ago</small>
                                            </div>
                                        </div>
                                    </a></li>
                                <li><a class="dropdown-item py-3" href="#">
                                        <div class="d-flex">
                                            <div class="icon icon-sm bg-orange">
                                                <svg class="svg-icon svg-icon-xs svg-icon-heavy">
                                                    <use xlink:href="#checked-window-1"></use>
                                                </svg>
                                            </div>
                                            <div class="ms-3"><span
                                                        class="h6 d-block fw-normal mb-1 text-xs text-gray-600">Server Rebooted</span>
                                                <small class="small text-gray-600">8 minutes ago</small>
                                            </div>
                                        </div>
                                    </a></li>
                                <li><a class="dropdown-item py-3" href="#">
                                        <div class="d-flex">
                                            <div class="icon icon-sm bg-green">
                                                <svg class="svg-icon svg-icon-xs svg-icon-heavy">
                                                    <use xlink:href="#chats-1"></use>
                                                </svg>
                                            </div>
                                            <div class="ms-3"><span
                                                        class="h6 d-block fw-normal mb-1 text-xs text-gray-600">New 2 WhatsApp messages</span>
                                                <small class="small text-gray-600">10 minutes ago</small>
                                            </div>
                                        </div>
                                    </a></li>
                                <li><a class="dropdown-item all-notifications text-center" href="http://192.168.0.109:8000/super-admin/notification"> <strong
                                                class="text-xs text-gray-600">view all notifications </strong></a></li>
                            </ul>
                        </li>

                        <li class="nav-item dropdown"><a class="nav-link text-white" id="messages" rel="nofollow"
                                                         href="#" data-bs-toggle="dropdown" aria-expanded="false">
                                <svg class="svg-icon svg-icon-xs svg-icon-heavy">
                                    <use xlink:href="#envelope-1"></use>
                                </svg>
                                <span class="badge bg-orange badge-corner fw-normal">10</span></a>
                            <ul class="dropdown-menu dropdown-menu-end mt-3 shadow-sm" aria-labelledby="messages">
                                <li><a class="dropdown-item d-flex py-3" href="http://192.168.0.109:8000/super-admin/chat/1"> <img class="img-fluid rounded-circle"
                                                                                                                                   src="http://192.168.0.109:8000/themes/prabin_dashboard/img/avatar-3.jpg" alt="..."
                                                                                                                                   width="45">
                                        <div class="ms-3"><span class="h6 d-block fw-normal mb-1 text-sm text-gray-600">Jason Doe</span>
                                            <small class="small text-gray-600"> Sent You Message</small>
                                        </div>
                                    </a></li>
                                <li><a class="dropdown-item text-center" href="http://192.168.0.109:8000/super-admin/chat"> <strong
                                                class="text-xs text-gray-600">Read all messages </strong></a></li>
                            </ul>
                        </li>

                        <li class="nav-item">
                            <form action="http://192.168.0.109:8000/super-admin/logout" method="post" id="logout_form">
                                <button class="nav-link text-white" style="background: #2f333e;border: none;"
                                        type="submit">
                                    <span class="d-none d-sm-inline">Logout</span>
                                    <svg class="svg-icon svg-icon-xs svg-icon-heavy">
                                        <use xlink:href="#security-1"></use>
                                    </svg>
                                </button>
                                <input type="hidden" name="_token" value="PBxLpVETmuatR0Cx9qXQUBP7TEFLOwlWkHYlXAHh">                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <div class="page-content d-flex align-items-stretch">
        <nav class="side-navbar z-index-40">
            <div class="sidebar-header d-flex align-items-center py-4 px-3">
                <a href="http://192.168.0.109:8000/super-admin/profile">
                    <img class="avatar shadow-0 img-fluid rounded-circle"
                         src="http://192.168.0.109:8000/themes/prabin_dashboard/img/niraj.jpg" alt="...">
                </a>
                <div class="ms-3 title">
                    <h1 class="h4 mb-2">Admin </h1>
                    <p class="text-sm text-gray-500 fw-light mb-0 lh-1">Superadmin</p>
                </div>
            </div>
            <ul class="list-unstyled py-4">
                <li class="sidebar-item"><a class="sidebar-link" href="http://192.168.0.109:8000/super-admin/dashboard">
                        <svg class="svg-icon svg-icon-sm svg-icon-heavy me-xl-2">
                            <use xlink:href="#real-estate-1"> </use>
                        </svg>Dashboard </a></li>

                <li class="sidebar-item"><a class="sidebar-link" href="#admin" data-bs-toggle="collapse" aria-expanded="true">
                        <img style="height: 22px;width: 22px;margin-right: 5px;" src="https://www.pinclipart.com/picdir/middle/217-2178422_add-administrator-icon-admin-icon-png-white-clipart.png"/>
                        </svg>Admin </a>
                    <ul class="collapse list-unstyled is-open show" id="admin">
                        <li><a class="sidebar-link active_sidebar" href="http://192.168.0.109:8000/super-admin/admin">List</a></li>
                        <li><a class="sidebar-link" href="http://192.168.0.109:8000/super-admin/admin/create">Create</a></li>
                    </ul>
                </li>

                <li class="sidebar-item"><a class="sidebar-link" href="#driver" data-bs-toggle="collapse" aria-expanded="false">
                        <img style="height: 22px;width: 22px;margin-right: 5px;" src="https://icon-library.com/images/driver-icon-png/driver-icon-png-24.jpg"/>
                        </svg>Driver </a>
                    <ul class="collapse list-unstyled" id="driver">
                        <li><a class="sidebar-link" href="http://192.168.0.109:8000/super-admin/driver">List</a></li>
                        <li><a class="sidebar-link" href="http://192.168.0.109:8000/super-admin/driver/create">Create</a></li>
                    </ul>
                </li>

                <li class="sidebar-item"><a class="sidebar-link" href="#vehicle" data-bs-toggle="collapse" aria-expanded="false">
                        <img style="height: 22px;width: 22px;margin-right: 5px;" src="https://cdn3.iconfinder.com/data/icons/car-icons-front-views/451/Compact_Car_Front_View-512.png"/>
                        </svg>Vehicle </a>
                    <ul class="collapse list-unstyled" id="vehicle">
                        <li><a class="sidebar-link" href="http://192.168.0.109:8000/super-admin/vehicle">List</a></li>
                        <li><a class="sidebar-link" href="http://192.168.0.109:8000/super-admin/vehicle/create">Create</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
        <div class="content-inner w-100">

            <div class="bg-white">
                <div class="container-fluid">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 py-3">
                            <li class="breadcrumb-item"><a class="fw-light" href="http://192.168.0.109:8000/super-admin/dashboard">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item"><a class="fw-light"
                                                           href="http://192.168.0.109:8000/super-admin/admin">Admin</a>
                            </li>
                            <li class="breadcrumb-item active fw-light" aria-current="page">List</li>
                        </ol>
                    </nav>
                </div>
            </div>


            <div id="test">
                <section class="tables">
                    <div class="container-fluid">
                        <div class="row gy-4">
                            <div class="col-lg-12">
                                <div class="card mb-0">
                                    <div class="card-header">
                                        <div class="card-close">
                                            <div class="dropdown">
                                                <button class="dropdown-toggle text-sm" type="button" id="closeCard1"
                                                        data-bs-toggle="dropdown" aria-expanded="false"><i
                                                            class="fas fa-ellipsis-v"></i></button>
                                                <div class="dropdown-menu dropdown-menu-end shadow-sm" aria-labelledby="closeCard1">
                                                    <a class="dropdown-item py-1 px-3 edit"
                                                       href="http://192.168.0.109:8000/super-admin/admin/create"> <i
                                                                class="fas fa-plus"></i>Create</a>
                                                </div>
                                            </div>
                                        </div>
                                        <h3 class="h4 mb-0">Admin List </h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table  class="table mb-0" id="example"><thead><tr><th  title="Action" width="60">Action</th><th  title="Id">Id</th><th  title="First Name">First Name</th><th  title="Created At">Created At</th><th  title="Updated At">Updated At</th></tr></thead></table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>


                <section class="tables">
                    <div class="container-fluid">
                        <div class="row gy-4">
                            <div class="col-lg-12">
                                <div class="card mb-0">
                                    <div class="card-header">
                                        <div class="card-close">
                                            <div class="dropdown">
                                                <button class="dropdown-toggle text-sm" type="button" id="closeCard1"
                                                        data-bs-toggle="dropdown" aria-expanded="false"><i
                                                            class="fas fa-ellipsis-v"></i></button>
                                                <div class="dropdown-menu dropdown-menu-end shadow-sm" aria-labelledby="closeCard1">
                                                    <a class="dropdown-item py-1 px-3 edit"
                                                       href="http://192.168.0.109:8000/super-admin/admin/create"> <i
                                                                class="fas fa-plus"></i>Create</a>
                                                </div>
                                            </div>
                                        </div>
                                        <h3 class="h4 mb-0">Admin List</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table  class="table mb-0" id="example"><thead><tr><th  title="Action" width="60">Action</th><th  title="Id">Id</th><th  title="First Name">First Name</th><th  title="Created At">Created At</th><th  title="Updated At">Updated At</th></tr></thead></table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>


                <section class="tables">
                    <div class="container-fluid">
                        <div class="row gy-4">
                            <div class="col-lg-12">
                                <div class="card mb-0">
                                    <div class="card-header">
                                        <div class="card-close">
                                            <div class="dropdown">
                                                <button class="dropdown-toggle text-sm" type="button" id="closeCard1"
                                                        data-bs-toggle="dropdown" aria-expanded="false"><i
                                                            class="fas fa-ellipsis-v"></i></button>
                                                <div class="dropdown-menu dropdown-menu-end shadow-sm" aria-labelledby="closeCard1">
                                                    <a class="dropdown-item py-1 px-3 edit"
                                                       href="http://192.168.0.109:8000/super-admin/admin/create"> <i
                                                                class="fas fa-plus"></i>Create</a>
                                                </div>
                                            </div>
                                        </div>
                                        <h3 class="h4 mb-0">Admin List</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table  class="table mb-0" id="example"><thead><tr><th  title="Action" width="60">Action</th><th  title="Id">Id</th><th  title="First Name">First Name</th><th  title="Created At">Created At</th><th  title="Updated At">Updated At</th></tr></thead></table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>


                <section class="tables">
                    <div class="container-fluid">
                        <div class="row gy-4">
                            <div class="col-lg-12">
                                <div class="card mb-0">
                                    <div class="card-header">
                                        <div class="card-close">
                                            <div class="dropdown">
                                                <button class="dropdown-toggle text-sm" type="button" id="closeCard1"
                                                        data-bs-toggle="dropdown" aria-expanded="false"><i
                                                            class="fas fa-ellipsis-v"></i></button>
                                                <div class="dropdown-menu dropdown-menu-end shadow-sm" aria-labelledby="closeCard1">
                                                    <a class="dropdown-item py-1 px-3 edit"
                                                       href="http://192.168.0.109:8000/super-admin/admin/create"> <i
                                                                class="fas fa-plus"></i>Create</a>
                                                </div>
                                            </div>
                                        </div>
                                        <h3 class="h4 mb-0">Admin List</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table  class="table mb-0" id="example"><thead><tr><th  title="Action" width="60">Action</th><th  title="Id">Id</th><th  title="First Name">First Name</th><th  title="Created At">Created At</th><th  title="Updated At">Updated At</th></tr></thead></table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>


                <section class="tables">
                    <div class="container-fluid">
                        <div class="row gy-4">
                            <div class="col-lg-12">
                                <div class="card mb-0">
                                    <div class="card-header">
                                        <div class="card-close">
                                            <div class="dropdown">
                                                <button class="dropdown-toggle text-sm" type="button" id="closeCard1"
                                                        data-bs-toggle="dropdown" aria-expanded="false"><i
                                                            class="fas fa-ellipsis-v"></i></button>
                                                <div class="dropdown-menu dropdown-menu-end shadow-sm" aria-labelledby="closeCard1">
                                                    <a class="dropdown-item py-1 px-3 edit"
                                                       href="http://192.168.0.109:8000/super-admin/admin/create"> <i
                                                                class="fas fa-plus"></i>Create</a>
                                                </div>
                                            </div>
                                        </div>
                                        <h3 class="h4 mb-0">Admin List</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table  class="table mb-0" id="example"><thead><tr><th  title="Action" width="60">Action</th><th  title="Id">Id</th><th  title="First Name">First Name</th><th  title="Created At">Created At</th><th  title="Updated At">Updated At</th></tr></thead></table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>



            <footer class="position-absolute bottom-0 bg-darkBlue text-white text-center py-3 w-100 text-xs"
                    id="footer">
                <div class="container-fluid">
                    <div class="row gy-2">
                        <div class="col-sm-6 text-sm-start">
                            <p class="mb-0">Speedy &copy; 2021</p>
                        </div>
                        <div class="col-sm-6 text-sm-end">
                            <p class="mb-0">Develop by <a href="http://santoshdheke.com.np/" target="_blank"
                                                          class="text-white text-decoration-none">Santosh Dheke</a></p>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
</div>

<script src="http://192.168.0.109:8000/themes/prabin_dashboard/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="http://192.168.0.109:8000/themes/prabin_dashboard/vendor/chart.js/Chart.min.js"></script>
<script src="http://192.168.0.109:8000/themes/prabin_dashboard/vendor/just-validate/js/just-validate.min.js"></script>
<script src="http://192.168.0.109:8000/themes/prabin_dashboard/vendor/choices.js/public/assets/scripts/choices.min.js"></script>
<script src="http://192.168.0.109:8000/themes/prabin_dashboard/js/front.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>


<script>

    function injectSvgSprite(path) {

        var ajax = new XMLHttpRequest();
        ajax.open("GET", path, true);
        ajax.send();
        ajax.onload = function (e) {
            var div = document.createElement("div");
            div.className = 'd-none';
            div.innerHTML = ajax.responseText;
            document.body.insertBefore(div, document.body.childNodes[0]);
        }
    }

    injectSvgSprite('https://bootstraptemple.com/files/icons/orion-svg-sprite.svg');


</script>



<script>
    function messateNotificaiton(user, msg, icon) {
        Notification.requestPermission();
        var n = new Notification(user, {
            body: msg,
            icon: icon || "https://etrain.themenepal/images/default/user.jpg"
        });

        n.onclick = function (event) {
            event.preventDefault();
            var url = "https://developer.mozilla.org/en-US/docs/Web/API/notification";
            window.open(url, '_blank');
        };

        setTimeout(function() {
            n.close()
        }, 4000);
    }
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/js/jquery.dataTables.min.js" integrity="sha512-BkpSL20WETFylMrcirBahHfSnY++H2O1W+UnEEO4yNIl+jI2+zowyoGJpbtk6bx97fBXf++WJHSSK2MV4ghPcg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/css/dataTables.bootstrap.min.css" integrity="sha512-BMbq2It2D3J17/C7aRklzOODG1IQ3+MHw3ifzBHMBwGO/0yUqYmsStgBjI0z5EYlaDEFnvYV7gNYdD3vFLRKsA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<script>
    $(document).ready(function() {
        $('#example').DataTable();
    } );
</script>

<script>
    $(window).on('scroll',function () {
        const {scrollTop, scrollHeight, clientHeight} = document.documentElement;
        console.log({
            scrollTop, scrollHeight, clientHeight
        })

        if (scrollTop + clientHeight >= scrollHeight){
            $('#test').append(`new html`);
        }
    })
</script>


<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css"
      integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
</body>
</html>
