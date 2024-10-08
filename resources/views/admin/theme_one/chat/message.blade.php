@extends($theme_path.'common.layout')

@section('sidebar')
{{--@include($theme_path.'chat.user_list')--}}
@endsection

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <div style="padding: 10px;">
            <a href="{{ route('admin.'.request('role').'.show',$user->id) }}" style="color: #2f333e">
                {{ $user->full_name }}
            </a>

            <a href="{{ route('admin.index') }}" style="float: right;color: #2f333e">
                <i class="fa fa-home"></i>
            </a>
        </div>
    </nav>
@endsection

@section('content')

    <section class="chat">
        <div class="container-fluid">
            <div class="row gy-4 chat-box" id="message_list">

                {{--<div style="width: 100%;">
                    <p style="text-align: center;">
                        <a href="javascript:void(0)">Load More</a>
                    </p>
                </div>--}}
                @foreach($messages as $message)

                    @if(request('role') == $message->sender_type)
                        <div class="col-lg-12">
                            <div class="sender">
                                <img class="avatar shadow-0 img-fluid rounded-circle chat-profile"
                                     src="{{ $user->image('50_50') }}"/>
                                <a class="chat-message">{{ $message->message }}</a>
                            </div>
                        </div>
                    @else
                        <div class="col-lg-12">
                            <div class="receiver">
                                <a class="chat-message">{{ $message->message }}</a>
                                <img class="avatar shadow-0 img-fluid rounded-circle chat-profile"
                                     src="{{ auth()->user()->image('50_50') }}"/>
                            </div>
                        </div>
                    @endif

                @endforeach
            </div>
        </div>
    </section>

@endsection

@section('footer')
    <footer class="bottom-0 bg-darkBlue text-white text-center py-3 w-100 text-xs"
            id="footer" style="background-color: #eef5f9!important;">
        <div class="container-fluid">
            <div class="row gy-2">
                    <div style="display: flex;">
                        <input class="chat_send_message" />
                        <button class="chat_send_btn"><i class="fa fa-paper-plane"></i></button>
                    </div>
            </div>
        </div>
    </footer>
@endsection

@push('js')
    <script>
        $("#message_list").animate({scrollTop: 20000000}, "slow");
        $('.chat_send_message').keypress(function (e) {
            if (e.keyCode == 13) {
                messageSend()
            }
        });
        $('.chat_send_btn').click(function () {
            messageSend()
        });

        function messageSend(){
            if ($('.chat_send_message').val() !== null && $('.chat_send_message').val() !== "") {
                $.post('{{ url('admin/chat') }}', {
                    "_token": "{{ csrf_token() }}",
                    "user_type": "{{ request('role') }}",
                    "id": "{{ request('id') }}",
                    "message": $('.chat_send_message').val()
                }, function (result) {
                    $("#message_list").append(`<div class="col-lg-12">
                    <div class="receiver">
                        <a class="chat-message">${result.message}</a>
                        <img class="avatar shadow-0 img-fluid rounded-circle chat-profile" src="{{ auth()->user()->image('50_50') }}"/>
                    </div>
                </div>`);
                    $("#message_list").animate({scrollTop: 20000000}, "slow");
                    socket.emit('message', {
                        'post_id': "{{ request('id') }}" + "{{ request('role') }}",
                        "result": result,
                        "user_type": "{{ request('role') }}",
                        "id": "{{ auth('admin')->id() }}"
                    });
                });
                $('.chat_send_message').val("");
            }
        }
    </script>

    <script>
        Echo.channel('chat')
            .listen('Chat', function (e) {

            });

        socket.on("{{ auth('admin')->id() }}"+'adminmessage_listen',function (data) {
            if (data.user_type == "admin" && data.id == "{{ request('id') }}"){
                $("#message_list").append(`<div class="col-lg-12">
                    <div class="sender">
                        <img class="avatar shadow-0 img-fluid rounded-circle chat-profile"
                             src="${data.result.sender_image}"/>
                        <a class="chat-message">${data.result.message}</a>
                    </div>
                </div>`);
                $("#message_list").animate({scrollTop: 20000000}, "slow");
            }
        })
    </script>

    <script>
        $(document).ready(function () {
            $.get('{{ url('admin/chat/user/list') }}',function (response) {
                var html = "";
                $.each(response,function(index,value){

                    var route = "{{ url('admin/chat') }}/"+value.type+"/"+value.id;

                    html = html + `<li class="sidebar-item{{ Request::is('admin/chat/'.'2')?' active':'' }}">
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
