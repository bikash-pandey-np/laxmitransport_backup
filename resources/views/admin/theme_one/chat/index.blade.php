@extends($theme_path.'common.layout')

@section('sidebar')

@endsection

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0 py-3">
            <li class="breadcrumb-item"><a class="fw-light" href="{{ route('admin.index') }}">Dashboard</a>
            </li>
            <li class="breadcrumb-item active fw-light" aria-current="page">Chat</li>
        </ol>
    </nav>
@endsection

@section('content')

    <section class="tables">
        <div class="container-fluid">
            <div class="row gy-4">
                <div class="col-lg-12">

                </div>
            </div>
        </div>
    </section>

@endsection

@push('js')


    <script>
        $(document).ready(function () {
            $.get('{{ url('admin/chat/user/list') }}',function (response) {
                var html = "";
                $.each(response,function(index,value){

                    var route = "{{ url('admin/chat') }}/"+value.type+"/"+value.id;

                    html = html + `<li class="sidebar-item{{ Request::is('super-admin/chat/'.'2')?' active':'' }}">
    <a class="sidebar-link" href="${route}">
        <img style="height: 45px;width: 45px;margin-right: 15px;"
             src="${value.image}"/>
        ${value.full_name}
    </a>
</li>`;
                })

                $('.chat-list').html(html);
            });
        });
    </script>

    @endpush