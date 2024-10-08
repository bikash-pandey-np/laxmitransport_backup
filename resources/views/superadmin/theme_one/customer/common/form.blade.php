
<h4>Brokerage Profile</h4>
@foreach(config('form.customer') as $field => $type)

    @if(isset($field) && $field == 'name')
        <div class="col-sm-6">
            <div class="input-material-group mb-3">
                <input class="input-material{{ $errors->has($field)?' validation_error':'' }}" id="{{ $field }}"
                       type="text"
                       name="{{ $field }}" value="{{ old($field) ?? $row[$field] ?? '' }}">
                @if($errors->has($field))
                    <div class="js-validate-error-label" style="color: #B81111">{{ $errors->first($field) }}</div>
                @else
                    <label class="label-material" for="{{ $field }}">Brokerage Name</label>
                @endif
            </div>
        </div>
    @elseif($field == 'admin_load_notes')
        @include($theme_path.'common.form.col_12_div',['field' => $field,'type' => $type])
    @else
        @include($theme_path.'common.form.col_6_div',['field' => $field,'type' => $type])
    @endif
@endforeach

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

<h4 style="margin-top: 10px">Dispatch</h4>

<div class="col-sm-6">
    <div class="input-material-group mb-3">
        <input class="input-material{{ $errors->has('dispatch_name')?' validation_error':'' }}" id="dispatch_name" type="text"
               name="dispatch_name" value="{{ old('dispatch_name') ?? $row['dispatch_name'] ?? '' }}">
        @if($errors->has('dispatch_name'))
            <div class="js-validate-error-label" style="color: #B81111">{{ $errors->first('dispatch_name') }}</div>
        @else
            <label class="label-material" for="dispatch_name">Dispatch Name</label>
        @endif
    </div>
</div>

<div class="col-sm-6">
    <div class="input-material-group mb-3">
        <input class="input-material{{ $errors->has('dispatch_phone_number')?' validation_error':'' }}" id="dispatch_phone_number" type="text"
               name="dispatch_phone_number" value="{{ old('dispatch_phone_number') ?? $row['dispatch_phone_number'] ?? '' }}">
        @if($errors->has('dispatch_phone_number'))
            <div class="js-validate-error-label" style="color: #B81111">{{ $errors->first('dispatch_phone_number') }}</div>
        @else
            <label class="label-material" for="dispatch_phone_number">Phone Number</label>
        @endif
    </div>
</div>

<div class="col-sm-6">
    <div class="input-material-group mb-3">
        <input class="input-material{{ $errors->has('dispatch_email')?' validation_error':'' }}" id="dispatch_email" type="text"
               name="dispatch_email" value="{{ old('dispatch_email') ?? $row['dispatch_email'] ?? '' }}">
        @if($errors->has('dispatch_email'))
            <div class="js-validate-error-label" style="color: #B81111">{{ $errors->first('dispatch_email') }}</div>
        @else
            <label class="label-material" for="dispatch_email">Dispatch Email</label>
        @endif
    </div>
</div>

<div class="col-sm-12">
    <div class="input-material-group mb-3">
            <textarea style="padding: 5px 10px" class="input-material{{ $errors->has('dispatch_admin_note')?' validation_error':'' }}" placeholder="Admin Note" id="dispatch_admin_note" row="1"
                      name="dispatch_admin_note">{{ old('dispatch_admin_note') ?? $row['dispatch_admin_note'] ?? '' }}</textarea>
        @if($errors->has('dispatch_admin_note'))
            <div class="js-validate-error-label" style="color: #B81111">{{ $errors->first('dispatch_admin_note') }}</div>
        @else
            {{--<label class="label-material" for="{{ $field }}">{{ $fieldTitle }}</label>--}}
        @endif
    </div>
</div>

<h4 style="margin-top: 10px">Billing Information</h4>

<div class="col-sm-6">
    <div class="input-material-group mb-3">
        <input class="input-material{{ $errors->has('bill_info_name')?' validation_error':'' }}" id="bill_info_name" type="text"
               name="bill_info_name" value="{{ old('bill_info_name') ?? $row['bill_info_name'] ?? '' }}">
        @if($errors->has('bill_info_name'))
            <div class="js-validate-error-label" style="color: #B81111">{{ $errors->first('bill_info_name') }}</div>
        @else
            <label class="label-material" for="bill_info_name">Billing Name</label>
        @endif
    </div>
</div>

<div class="col-sm-6">
    <div class="input-material-group mb-3">
        <input class="input-material{{ $errors->has('bill_info_business_address')?' validation_error':'' }}" id="bill_info_business_address" type="text"
               name="bill_info_business_address" value="{{ old('bill_info_business_address') ?? $row['bill_info_business_address'] ?? '' }}">
        @if($errors->has('bill_info_business_address'))
            <div class="js-validate-error-label" style="color: #B81111">{{ $errors->first('bill_info_business_address') }}</div>
        @else
            <label class="label-material" for="bill_info_business_address">Business Address</label>
        @endif
    </div>
</div>

<div class="col-sm-6">
    <div class="input-material-group mb-3">
        <input class="input-material{{ $errors->has('bill_info_phone_number')?' validation_error':'' }}" id="bill_info_phone_number" type="text"
               name="bill_info_phone_number" value="{{ old('bill_info_phone_number') ?? $row['bill_info_phone_number'] ?? '' }}">
        @if($errors->has('bill_info_phone_number'))
            <div class="js-validate-error-label" style="color: #B81111">{{ $errors->first('bill_info_phone_number') }}</div>
        @else
            <label class="label-material" for="bill_info_phone_number">Phone Number</label>
        @endif
    </div>
</div>

<div class="col-sm-6">
    <div class="input-material-group mb-3">
        <input class="input-material{{ $errors->has('bill_info_accounting_email')?' validation_error':'' }}" id="bill_info_accounting_email" type="text"
               name="bill_info_accounting_email" value="{{ old('bill_info_accounting_email') ?? $row['bill_info_accounting_email'] ?? '' }}">
        @if($errors->has('bill_info_accounting_email'))
            <div class="js-validate-error-label" style="color: #B81111">{{ $errors->first('bill_info_accounting_email') }}</div>
        @else
            <label class="label-material" for="bill_info_accounting_email">Billing Email</label>
        @endif
    </div>
</div>

<div class="col-sm-6">
    <div class="input-material-group mb-3">
        <input class="input-material{{ $errors->has('bill_info_federal_tax_payer_id')?' validation_error':'' }}" id="bill_info_federal_tax_payer_id" type="text"
               name="bill_info_federal_tax_payer_id" value="{{ old('bill_info_federal_tax_payer_id') ?? $row['bill_info_federal_tax_payer_id'] ?? '' }}">
        @if($errors->has('bill_info_federal_tax_payer_id'))
            <div class="js-validate-error-label" style="color: #B81111">{{ $errors->first('bill_info_federal_tax_payer_id') }}</div>
        @else
            <label class="label-material" for="bill_info_federal_tax_payer_id">Federal Tax Payer Id</label>
        @endif
    </div>
</div>
