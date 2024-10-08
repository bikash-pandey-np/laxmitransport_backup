<div class="col-sm-6">
    <div class="input-material-group mb-3">
        <input class="input-material{{ $errors->has('actual_amount') ? ' validation_error' : '' }}" id="actual_amount"
            type="number" step="0.01" name="actual_amount" value="{{ old('actual_amount') ?? ($row->amount ?? '') }}">
        @if ($errors->has('actual_amount'))
            <div class="js-validate-error-label" style="color: #B81111">{{ $errors->first('actual_amount') }}</div>
        @else
            <label class="label-material" for="actual_amount">Actual Amount</label>
        @endif
    </div>
</div>

<div class="col-sm-6">
    <div class="input-material-group mb-3">
        <select name="status_after_complete" id="status" class="input-material-group form-control" required>
            <option value="" disabled selected>Change Status</option>
            @php($oldData = $row->status ?? (old('status_after_complete') ?? ''))
            <option {{ $oldData == 'Factored' ? 'selected' : '' }} value="{{ 'Factored' }}">{{ 'Factored' }}
            </option>
            <option {{ $oldData == 'Paid To Factoring' ? 'selected' : '' }} value="{{ 'Paid To Factoring' }}">
                {{ 'Paid To Factoring' }}</option>
            <option {{ $oldData == 'Direct Invoice' ? 'selected' : '' }} value="{{ 'Direct Invoice' }}">
                {{ 'Direct Invoice' }}</option>
            <option {{ $oldData == 'Payment Settled' ? 'selected' : '' }} value="{{ 'Payment Settled' }}">
                {{ 'Payment Settled' }}</option>
            <option {{ $oldData == 'Tonu' ? 'selected' : '' }} value="{{ 'Tonu' }}">{{ 'Tonu' }}
            </option>

        </select>
    </div>
</div>

<div class="col-sm-6">
    <div class="input-material-group mb-3">
        <input class="datepicker input-material{{ $errors->has('date') ? ' validation_error' : '' }}" id="date"
            type="text" name="date" value="{{ old('date') ?? ($row->date ?? '') }}">
        @if ($errors->has('date'))
            <div class="js-validate-error-label" style="color: #B81111">{{ $errors->first('date') }}</div>
        @else
            <label class="label-material" for="date">Date</label>
        @endif
    </div>
</div>

<div class="col-sm-6">
    <div class="input-material-group mb-3">
        <textarea name="admin_note" id="admin_note" class="input-material-group form-control" placeholder="Admin Note"
            cols="30" rows="10">{{ old('date') ?? ($row->admin_note ?? '') }}</textarea>
    </div>
</div>
