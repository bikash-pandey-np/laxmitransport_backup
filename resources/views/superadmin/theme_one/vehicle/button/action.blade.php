@php
    $title = ucwords(str_replace('-',' ',explode('.',$base_route)[1] ?? ''));
    if(isset($changesTitle)){
        $title = $changesTitle;
    }
@endphp

<div style="display:flex;">
    @if($row->driver_id !== 0)
        <a href="{{ route('super_admin.chat.message',['role' => 'driver','id' => $row->driver_id]) }}">
            <button title="Chat with {{ $row->full_name ?? '' }}" class="btn btn-xs btn-success"><i
                    class="fa fa-comments"></i></button>
        </a>
    @endif
    <a href="{{ route($base_route.'.edit',$row) }}">
        <button title="Edit {{ $title ?? '' }}" class="btn btn-xs btn-primary"><i class="fa fa-edit"></i></button>
    </a>

{{--    <form action="{{ route($base_route.'.destroy',$row) }}" method="post" id="formPost{{ $row->id }}">--}}
{{--        @csrf @method('delete')--}}
{{--        <button type="button" class="btn btn-xs btn-danger clickBtn" title="Delete" data-id="formPost{{ $row->id }}"><i--}}
{{--                class="fa fa-trash"></i></button>--}}
{{--    </form>--}}
    @if($row->driver_id !== 0)
        <form action="{{ route('super_admin.driver.login',$row->driver->id) }}" target="_blank" method="post">
            @csrf
            <button type="submit" class="btn btn-xs btn-warning" title="Login"><i
                    class="fa fa-lock-open"></i></button>
        </form>
    @endif
    {{--<a href="javascript:void(0)"><button type="button" data-toggle="modal" data-target="#delete{{ $row->id }}" class="btn btn-xs btn-danger"><i
                class="fa fa-trash"></i></button></a>--}}
</div>

{{--<div class="modal fade" id="delete{{ $row->id }}" tabindex="-1" role="dialog"
     aria-labelledby="delete{{ $row->id }}Label" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="delete{{ $row->id }}Label">Are you sure? you want to
                    delete {{ $title ?? 'it' }}?</h5>
            </div>
            <div class="modal-body">
                <i class="fa fa-warning"></i> Its never restored. after delete.
            </div>
            <div class="modal-footer">
                <form action="{{ route($base_route.'.destroy',$row) }}" method="post">
                    @csrf @method('delete')
                    <button type="button" class="btn btn-xs btn-primary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-xs btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>--}}
