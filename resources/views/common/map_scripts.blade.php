<input type="text" id="service_address" value="Madhyapur Thimi, Nepal">

<script
    src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places&key=AIzaSyDdAHM5SClWy9unwDEG3mvydQiW5xk5Ki4"></script>
<script>
    $(document).ready(function () {
        var url = "https://maps.googleapis.com/maps/api/geocode/json?latlng=27.682440,85.431322&key=AIzaSyDdAHM5SClWy9unwDEG3mvydQiW5xk5Ki4";

        $.get(url,function (data){
            console.log('data == ',data);
        });

        var autocomplete;
        autocomplete = new google.maps.places.Autocomplete((document.getElementById('service_address')), {
            types: ['geocode'],
            componentRestrictions: {
                country: "np"
            }
        });

        var near_place = autocomplete.getPlace();
        if (!near_place.geometry || !near_place.geometry.location) {

            window.alert("Please select the location from dropdown");
            return;f
        }

        console.log(near_place.formatted_address)
        document.getElementById('service_address').value = near_place.formatted_address;
        document.getElementById('latitude').value = near_place.geometry.location.lat();
        document.getElementById('longitude').value = near_place.geometry.location.lng();

        google.maps.event.addListener(autocomplete, 'place_changed', function () {

            var near_place = autocomplete.getPlace();
            if (!near_place.geometry || !near_place.geometry.location) {

                window.alert("Please select the location from dropdown");
                return;
            }

            console.log(near_place.formatted_address)
            document.getElementById('service_address').value = near_place.formatted_address;
            document.getElementById('latitude').value = near_place.geometry.location.lat();
            document.getElementById('longitude').value = near_place.geometry.location.lng();

        });
    });
</script>
