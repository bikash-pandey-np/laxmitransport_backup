
@foreach(config('form.bill') as $field => $type)
    @if($field == 'admin_load_notes')
        @include($theme_path.'common.form.col_12_div',['field' => $field,'type' => $type])
    @else
        @include($theme_path.'common.form.col_6_div',['field' => $field,'type' => $type])
    @endif
@endforeach

<div class="col-sm-6">
    <div class="input-material-group mb-3">
        <label for="image">Image</label>
        <br>
        <input id="image" type="file" name="image">
    </div>
    @if(isset($row))
        <img src="{{ $row->image('300_300') }}" style="width: 250px">
    @endif
</div>

@push('js')

<script>
    $('#add_location_btn').on('click', function () {
        $.get('{{ url('super-admin/work/add/location') }}', function (html) {
            $('#location_table').append(html);
        });
    });
</script>
<script>
    $(document).on('click', '.minus_row', function () {
        $(this).parent().parent().remove();
    })
</script>
<script>
    $(document).on('change',"#location_type", function () {
        if($(this).val() == "multiple"){
            $('#multiple_location').show();
            $('#single_location').hide();
        }else{
            $('#multiple_location').hide();
            $('#single_location').show();
        }
    })
</script>
@endpush
