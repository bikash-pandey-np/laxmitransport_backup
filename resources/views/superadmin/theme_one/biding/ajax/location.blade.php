<tr>
    <td>

        <input type="text" class="form-control" value="{{ $location->company_name ?? '' }}"
               name="location[{{ $uniqueId }}][company_name]" placeholder="Company Name">

    </td>
    <td>
        @if(isset($location->id))
            <input type="hidden" value="{{ $location->id }}" name="location[{{ $uniqueId }}][id]">
        @endif
        <input type="text" class="form-control" value="{{ $location->pickup_house_number ?? '' }}"
               name="location[{{ $uniqueId }}][pickup_house_number]" placeholder="Pickup Address">

    </td>
    <td>
        <input type="date" class="form-control" value="{{ $location->pickup_date ?? '' }}"
               name="location[{{ $uniqueId }}][pickup_date]" placeholder="MM/DD/YYYY">
    </td>
    <td>
        <input type="text" id="time" class="form-control" value="{{ $location->pickup_time ?? '' }}"
               name="location[{{ $uniqueId }}][pickup_time]" placeholder="HH:MM">
    </td>

    <td>

        <input type="text" class="form-control" value="{{ $location->consignee_name ?? '' }}"
               name="location[{{ $uniqueId }}][consignee_name]" placeholder="Consignee Name">

    </td>
    <td>

        <input type="text" class="form-control" value="{{ $location->drop_house_number ?? '' }}"
               name="location[{{ $uniqueId }}][drop_house_number]" placeholder="Drop Address">

    </td>
    <td>

        <input type="date" class="form-control" value="{{ $location->drop_date ?? '' }}"
               name="location[{{ $uniqueId }}][drop_date]" placeholder="MM/DD/YYYY">

    </td>
    <td>

        <input type="text" id="time" class="form-control" value="{{ $location->drop_time ?? '' }}"
               name="location[{{ $uniqueId }}][drop_time]" placeholder="HH:MM">

    </td>
    <th>
        <button type="button" class="btn btn-xs btn-danger minus_row"><i class="fa fa-minus"></i></button>
    </th>
</tr>
