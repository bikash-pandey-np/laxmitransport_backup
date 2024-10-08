@php
    $title = ucwords(str_replace('-',' ',explode('.',$base_route)[1] ?? ''));
    if(isset($changesTitle)){
        $title = $changesTitle;
    }
@endphp

<div style="display:flex;">
{{--    <a href="{{ route($base_route.'.show',$row) }}"><button title="Show {{ $title ?? '' }}" class="btn btn-xs btn-success"><i class="fa fa-eye"></i></button></a>--}}
    <a href="{{ route($base_route.'.create',['id' => $row->id]) }}"><button title="Edit {{ $title ?? '' }}" class="btn btn-xs btn-primary"><i class="fa fa-edit"></i></button></a>
</div>
