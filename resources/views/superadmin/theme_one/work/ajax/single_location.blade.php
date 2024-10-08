<div class="col-sm-12">
    <div class="input-material-group mb-3">
        <div class="table-responsive">
            <table class="table">
                <thead>
                <tr>
                    <th class="col">Pick up Address</th>
                    <th class="col">Drop Address</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>
                        <input type="text" class="form-control" value="{{ $location->company_name ?? '' }}"
                               name="single_location[0][company_name]" placeholder="Company Name">
                    </td>

                    <td>
                        <input type="text" class="form-control" value="{{ $location->consignee_name ?? '' }}"
                               name="single_location[0][consignee_name]" placeholder="Consignee Name">
                    </td>
                </tr>

                <tr>
                    <td>
                        <input type="text" class="form-control" value="{{ $location->pickup_house_number ?? '' }}"
                               name="single_location[0][pickup_house_number]" placeholder="Pickup Address">
                    </td>

                    <td>
                        <input type="text" class="form-control" value="{{ $location->drop_house_number ?? '' }}"
                               name="single_location[0][drop_house_number]" placeholder="Drop Address">
                    </td>
                </tr>

                <tr>
                    <td>
                        <input class="form-control{{ $errors->has('origin_destination')?' validation_error':'' }}"
                               id="origin_destination" type="text" placeholder="City, St Zip code"
                               name="origin_destination" value="{{ old('origin_destination') ?? $row['origin_destination'] ?? '' }}">
                    </td>

                    <td>
                        <input class="form-control{{ $errors->has('drop_destination')?' validation_error':'' }}" id="drop_destination"
                               type="text" placeholder="City, St Zip code"
                               name="drop_destination" value="{{ old('drop_destination') ?? $row['drop_destination'] ?? '' }}">
                    </td>
                </tr>

                <tr>
                    <td>

                        <div class="row">
                            <div class="col-md-6">
                                <input type="date" class="form-control" value="{{ $location->pickup_date ?? '' }}"
                                       name="single_location[0][pickup_date]" placeholder="MM/DD/YYYY">
                            </div>
                            <div class="col-md-6">
                                <input type="text" id="time" class="form-control" value="{{ $location->pickup_time ?? '' }}"
                                       name="single_location[0][pickup_time]" placeholder="HH:MM">
                            </div>
                        </div>
                    </td>
                    <td>

                        <div class="row">
                            <div class="col-md-6">
                                <input type="date" class="form-control" value="{{ $location->drop_date ?? '' }}"
                                       name="single_location[0][drop_date]" placeholder="MM/DD/YYYY">
                            </div>
                            <div class="col-md-6">
                                <input type="text" id="time" class="form-control" value="{{ $location->drop_time ?? '' }}"
                                       name="single_location[0][drop_time]" placeholder="HH:MM">
                            </div>
                        </div>

                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
