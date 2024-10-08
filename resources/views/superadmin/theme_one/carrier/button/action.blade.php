@php
    $title = ucwords(str_replace('-',' ',explode('.',$base_route)[1] ?? ''));
    if(isset($changesTitle)){
        $title = $changesTitle;
    }
@endphp

<div style="display:flex;">
    <a href="{{ route($base_route.'.edit',$row) }}"><button title="Edit {{ $title ?? '' }}" class="btn btn-xs btn-primary"><i class="fa fa-edit"></i></button></a>

{{--    <form action="{{ route($base_route.'.destroy',$row) }}" method="post" id="formPost{{ $row->id }}">--}}
{{--        @csrf @method('delete')--}}
{{--        <button type="button" class="btn btn-xs btn-danger clickBtn" data-id="formPost{{ $row->id }}"><i--}}
{{--                class="fa fa-trash"></i></button>--}}
{{--    </form>--}}

    <form action="{{ route($base_route.'.login',$row) }}" target="_blank" method="post">
        @csrf
        <button type="submit" class="btn btn-xs btn-warning" title="Login"><i
                class="fa fa-lock-open"></i></button>
    </form>
</div>
