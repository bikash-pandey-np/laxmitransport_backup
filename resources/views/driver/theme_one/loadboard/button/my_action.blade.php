@if(($row->loadboard->table ?? null) == null && ($row->loadboard->table_id ?? null) == null)
<div style="display:flex;">
    <a href="javascript:void(0)">
        <button title="Edit {{ $title ?? '' }}" class="btn btn-primary">Under Review
        </button>
    </a>
{{--    <a href="{{ route('driver.loadboard.create',$row->load_board_id) }}">--}}
{{--        <button title="Edit {{ $title ?? '' }}" class="btn btn-primary">Under Review--}}
{{--        </button>--}}
{{--    </a>--}}
</div>
@elseif(($row->loadboard->table ?? null) == \App\Models\Driver::class && ($row->loadboard->table_id ?? null) == auth('driver')->id())

    <div style="display:flex;">
        <a href="javascript:void(0)">
            <button class="btn btn-success">Approved
            </button>
        </a>
    </div>

@else

    <div style="display:flex;">
        <a href="javascript:void(0)">
            <button class="btn btn-danger">Rejected
            </button>
        </a>
    </div>

@endif
