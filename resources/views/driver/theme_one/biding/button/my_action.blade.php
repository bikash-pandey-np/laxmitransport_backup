@php
    $title = ucwords(str_replace('-',' ',explode('.',$base_route)[1] ?? ''));
    if(isset($changesTitle)){
        $title = $changesTitle;
    }
@endphp

<div style="display:flex;">
            <a href="{{ route('driver.biding.create',$row->work_id) }}">
                <button title="Edit {{ $title ?? '' }}" class="btn btn-primary"> Edit Amount
                </button>
            </a>
</div>
