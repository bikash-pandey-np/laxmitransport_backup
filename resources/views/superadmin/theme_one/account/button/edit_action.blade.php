@php
    $title = ucwords(str_replace('-', ' ', explode('.', $base_route)[1] ?? ''));
    if (isset($changesTitle)) {
        $title = $changesTitle;
    }
@endphp

<div style="display:flex;">
    <div style="display:flex;">
        <a href="{{ route($base_route . '.edit', ['speedy_sale' => request('speedy_sale'), 'speedy_id' => $row->id]) }}"><button
                title="Edit {{ $title ?? '' }}" class="btn btn-xs btn-primary"><i class="fa fa-edit"></i></button></a>

        <!-- Button trigger modal -->
        <a href="{{ url('super-admin/account/speedy-sales/' . request('speedy_sale') . '/view?speedy_id=' . $row->id) }}"
            class="btn btn-xs btn-success">
            <i class="fa fa-eye"></i>
        </a>

        {{-- <form action="{{ route($base_route.'.destroy',['speedy_sale' => request('speedy_sale'), 'speedy_id' => $row->id]) }}" method="post" id="formPost{{ $row->id }}">
                @csrf @method('delete')
                <button type="button" class="btn btn-xs btn-danger clickBtn" data-id="formPost{{ $row->id }}"><i
                        class="fa fa-trash"></i></button>
            </form> --}}
    </div>
</div>
