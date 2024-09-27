@props([
    'type' => 'create',
    'url',
    'method' => null,
    'road_closure' => null
])

<form
    action="{{ $url }}"
    method="POST"
    enctype="multipart/form-data"
>
    @csrf

    @if($method)
        @method($method)
    @endif

    <input type="hidden" id="user_timezone" name="user_timezone">

    <div>
        <x-input-label for="title" :value="__('Title')"/>

        <x-text-input
            id="title"
            name="title"
            type="text"
            :value="old('title', $road_closure?->title)"
            class="block mt-1 w-full"
            required
            autofocus
        />

        <x-input-error :messages="$errors->get('title')" class="mt-2"/>
    </div>

    <div class="mt-4">
        <x-input-label for="start_time" :value="__('Start Time')"/>

        <x-text-input
            id="start_time"
            name="start_time"
            type="datetime-local"
            :value="old('start_time', $road_closure?->start_time)"
            class="block mt-1 w-full dark:[color-scheme:dark]"
            required
        />

        <x-input-error :messages="$errors->get('start_time')" class="mt-2"/>
    </div>

    <div class="mt-4">
        <x-input-label for="end_time" :value="__('End Time')"/>

        <x-text-input
            id="end_time"
            name="end_time"
            type="datetime-local"
            :value="old('end_time', $road_closure?->end_time)"
            class="block mt-1 w-full dark:[color-scheme:dark]"
            required
        />

        <x-input-error :messages="$errors->get('end_time')" class="mt-2"/>
    </div>

    <div class="mt-4">
        <x-input-label for="address" :value="__('Start Point and End Point')"/>

        <div class="mt-1 relative flex justify-center">
            <div id="map" class="h-96 w-full"></div>
            <div class="absolute">
                <x-danger-button
                    id="delete-markers"
                    type="button"
                    value="Delete Markers"
                    class="mt-3"
                >
                    Delete Markers
                </x-danger-button>
            </div>
        </div>

        <input type="hidden" id="start_latitude" name="start_latitude">
        <input type="hidden" id="start_longitude" name="start_longitude">
        <input type="hidden" id="end_latitude" name="end_latitude">
        <input type="hidden" id="end_longitude" name="end_longitude">

        <x-input-error :messages="$errors->get('start_latitude')" class="mt-2"/>
        <x-input-error :messages="$errors->get('start_longitude')" class="mt-2"/>
        <x-input-error :messages="$errors->get('end_latitude')" class="mt-2"/>
        <x-input-error :messages="$errors->get('end_longitude')" class="mt-2"/>
    </div>

    <x-primary-button class="mt-4" type="submit">
        {{ __('Save') }}
    </x-primary-button>
</form>

@push('script')
    <script>
        // Use JavaScript to get the user's timezone and populate the input field
        var userTimezone = Intl.DateTimeFormat().resolvedOptions().timeZone;
        document.getElementById('user_timezone').value = userTimezone;
    </script>

    <script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD0EMJp7S5B6CKaNTfJ55fv0xEpKOEu2gM&callback=initMap&v=weekly"
        defer
    ></script>

    <script>
        let map;
        let markers = [];

        function initMap() {
            const roadClosure = {!! json_encode($road_closure) !!};

            let myLatLng;
            if(roadClosure){
                myLatLng = {
                    lat: parseFloat(roadClosure.start_latitude),
                    lng: parseFloat(roadClosure.start_longitude)
                };
            }else {
                myLatLng = { lat: 35.3744858, lng: -119.0200281 };
            }

            map = new google.maps.Map(document.getElementById("map"), {
                zoom: 5,
                center: myLatLng,
                mapTypeId: "terrain",
            });

            if(roadClosure != null && roadClosure.start_latitude && roadClosure.start_longitude){
                addMarker({
                    lat: parseFloat(roadClosure.start_latitude),
                    lng: parseFloat(roadClosure.start_longitude)
                })
            }

            if(roadClosure != null && roadClosure.end_latitude && roadClosure.end_longitude){
                addMarker({
                    lat: parseFloat(roadClosure.end_latitude),
                    lng: parseFloat(roadClosure.end_longitude)
                })
            }

            // This event listener will call addMarker() when the map is clicked.
            map.addListener("click", (event) => {
                if(markers.length < 2){
                    addMarker(event.latLng);
                }
            });

            // add event listeners for the buttons
            document.getElementById("delete-markers").addEventListener("click", deleteMarkers);
        }

        // Adds a marker to the map and push to the array.
        function addMarker(position) {
            const marker = new google.maps.Marker({
                position,
                map,
                draggable: true,
                type: markers.length === 0 ? 'start' : 'end',
                label: markers.length === 0 ? 'start' : 'end'
            });

            markers.push(marker);

            setDataToInput(marker, marker.position.lat(), marker.position.lng());

            marker.addListener('dragend', function(event) {
                setDataToInput(marker, event.latLng.lat(), event.latLng.lng());
            });
        }

        function setDataToInput(marker, latitude, longitude){
            let inputLatitudeId = `${marker.type}_latitude`;
            let inputLongitudeId = `${marker.type}_longitude`;

            document.getElementById(inputLatitudeId).value = latitude;
            document.getElementById(inputLongitudeId).value = longitude;
        }

        // Sets the map on all markers in the array.
        function setMapOnAll(map) {
            for (let i = 0; i < markers.length; i++) {
                markers[i].setMap(map);
            }
        }

        // Removes the markers from the map, but keeps them in the array.
        function hideMarkers() {
            setMapOnAll(null);
        }

        // Shows any markers currently in the array.
        function showMarkers() {
            setMapOnAll(map);
        }

        // Deletes all markers in the array by removing references to them.
        function deleteMarkers() {
            hideMarkers();
            markers = [];
            document.getElementById('start_latitude').value = null;
            document.getElementById('start_longitude').value = null;
            document.getElementById('end_latitude').value = null;
            document.getElementById('end_longitude').value = null;
        }

        window.initMap = initMap;
    </script>
@endpush


