
    <input type="hidden" name="work_id" value="{{ request('id') }}">

@foreach(config('form.payroll') as $field => $type)
    @if($field == 'admin_load_notes')
        @include($theme_path.'common.form.col_12_div',['field' => $field,'type' => $type])
    @else
        @include($theme_path.'common.form.col_6_div',['field' => $field,'type' => $type])
    @endif
@endforeach

    <div class="col-sm-6">
        <div class="input-material-group mb-3">
            <select name="status" class="input-material{{ $errors->has('status')?' validation_error':'' }}"
                    id="status">
                <option value="" disabled selected>Status</option>
                <option {{ (isset($row->status) && $row->status=="Paid")?"selected":"" }} value="Paid">Paid</option>
                <option {{ (isset($row->status) && $row->status=="Unpaid")?"selected":"" }} value="Unpaid">Unpaid</option>
            </select>
            @if($errors->has('status'))
                <div class="js-validate-error-label" style="color: #B81111">{{ $errors->first('status') }}</div>
            @else
                {{--<label class="label-material" for="status">{{ ucwords(str_replace('_',' ',$field)) }}</label>--}}
            @endif
        </div>
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
        $(document).on('change', "#location_type", function () {
            if ($(this).val() == "multiple") {
                $('#multiple_location').show();
                $('#single_location').hide();
            } else {
                $('#multiple_location').hide();
                $('#single_location').show();
            }
        })
    </script>
@endpush
