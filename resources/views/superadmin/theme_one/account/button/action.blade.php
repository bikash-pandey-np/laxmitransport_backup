@php
    $title = ucwords(str_replace('-',' ',explode('.',$base_route)[1] ?? ''));
    if(isset($changesTitle)){
        $title = $changesTitle;
    }
@endphp

<div style="display:flex;">
        <div style="display:flex;">
            <a href="{{ route('super_admin.work.show',$row) }}"><button title="Edit {{ $title ?? '' }}" class="btn btn-xs btn-info"><i class="fa fa-eye"></i></button></a>
            <a href="{{ route($base_route.'.edit',$row) }}"><button title="Edit {{ $title ?? '' }}" class="btn btn-xs btn-primary"><i class="fa fa-edit"></i></button></a>
        </div>
</div>
