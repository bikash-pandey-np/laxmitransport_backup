@php
$title = ucwords(str_replace('-',' ',explode('.',$base_route)[1] ?? ''));
if(isset($changesTitle)){
    $title = $changesTitle;
}
@endphp

<div style="display:flex;">
    @if($row->admin_status_approved == 0)
    <a href="{{ route($base_route.'.approve',$row) }}"><button title="Edit {{ $title ?? '' }}" class="btn btn-success">Approve</button></a>
    <a href="{{ route($base_route.'.reject',$row) }}"><button title="Edit {{ $title ?? '' }}" class="btn btn-danger">Reject</button></a>
        @else
        <div style="display:flex;">
            <a href="{{ route($base_route.'.show',$row) }}"><button title="Edit {{ $title ?? '' }}" class="btn btn-xs btn-info"><i class="fa fa-eye"></i></button></a>
            <a href="{{ route($base_route.'.edit',$row) }}"><button title="Edit {{ $title ?? '' }}" class="btn btn-xs btn-primary"><i class="fa fa-edit"></i></button></a>

            <form action="{{ route($base_route.'.destroy',$row) }}" method="post" id="formPost{{ $row->id }}">
                @csrf @method('delete')
                <button type="button" class="btn btn-xs btn-danger clickBtn" data-id="formPost{{ $row->id }}"><i
                            class="fa fa-trash"></i></button>
            </form>
        </div>
    @endif
</div>
