@php
    $title = ucwords(str_replace('-',' ',explode('.',$base_route)[1] ?? ''));
    if(isset($changesTitle)){
        $title = $changesTitle;
    }
@endphp

<div style="display:flex;">
    @if($row->status !== 'delivery')
        @if($row->admin_status_approved == 0)
            waiting approve
        @else
            <a href="{{ route($base_route.'edit',$row->id) }}">
                <button title="Edit {{ $title ?? '' }}" class="btn btn-xs btn-primary"><i class="fa fa-edit"></i>
                </button>
            </a>
        @endif
    @else
        <a href="{{ route($base_route.'show',$row->id) }}">
            <button title="Edit {{ $title ?? '' }}" class="btn btn-xs btn-info"><i class="fa fa-eye"></i>
            </button>
        </a>
    @endif
</div>
