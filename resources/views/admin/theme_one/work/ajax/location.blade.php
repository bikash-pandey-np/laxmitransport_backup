<tr>
    <td>
        <input type="text" class="form-control" value="{{ $location->picked_up_address ?? '' }}"
               name="location[{{ $uniqueId }}][picked_up_address]">
        @if(isset($location->id))
            <input type="hidden" value="{{ $location->id }}" name="location[{{ $uniqueId }}][id]">
        @endif
    </td>
    <td><input type="text" class="form-control" value="{{ $location->drip_address ?? '' }}"
               name="location[{{ $uniqueId }}][drip_address]"></td>
    <th>
        <button type="button" class="btn btn-xs btn-danger minus_row"><i class="fa fa-minus"></i></button>
    </th>
</tr>