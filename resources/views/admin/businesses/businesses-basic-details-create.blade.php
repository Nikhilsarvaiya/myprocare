@extends('layouts.app')

@section('main')
    <!-- Heading -->
    <div class="flex justify-between">
        <h1 class="mb-3 text-xl font-semibold dark:text-white">Business Basic Details</h1>

        <a href="{{ route('admin.businesses.index') }}">
            <x-secondary-button>
                <i class="fa-solid fa-arrow-left"></i>
            </x-secondary-button>
        </a>
    </div>

    <form
        method="POST"
        action="{{ request()->routeIs('admin.businesses.basic_details.create') ? route('admin.businesses.basic_details.store') : route('admin.businesses.basic_details.update', request()->route('business')) }}"
        x-data="{
            sellFoodBeverage: {{ old('sell_food_beverage', 0) }},
            businessTypes: {{ $businessTypes }},
            filteredBusinessTypes: [],
        }"
        x-init="
            $watch('sellFoodBeverage', (value) => filteredBusinessTypes = businessTypes.filter((businessType) => businessType.sell_food_beverage == value));
            $nextTick(() => filteredBusinessTypes = businessTypes.filter((businessType) => businessType.sell_food_beverage == sellFoodBeverage))
        "
    >
        @csrf

        @if(request()->routeIs('admin.businesses.basic_details.edit'))
            @method('PUT')
        @endif

        <div>
            <x-input-label for="business_user_email" :value="__('Business User Email')"/>

            <select
                id="business_user_email"
                name="business_user_email"
                type="text"
                class="block mt-1 w-full"
            >
                <option value="">select a user email.</option>
            </select>

            <x-input-error :messages="$errors->get('business_user_email')" class="mt-2"/>
        </div>

        <!-- Sell Food Beverages -->
        <div class="mt-4">
            <x-input-label for="sell_food_beverage" :value="__('Sell Food Beverages')"/>

            <div class="mt-2 flex space-x-4">
                <div class="flex items-center">
                    <input
                        id="sell_food_beverage_1"
                        name="sell_food_beverage"
                        type="radio"
                        value="1"
                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                        x-model="sellFoodBeverage"
                        required
                    >
                    <x-input-label for="sell_food_beverage_1" :value="__('Yes')" class="ml-2"/>
                </div>
                <div class="flex items-center">
                    <input
                        id="sell_food_beverage_2"
                        name="sell_food_beverage"
                        type="radio"
                        value="0"
                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                        x-model="sellFoodBeverage"
                        required
                    >
                    <x-input-label for="sell_food_beverage_2" :value="__('No')" class="ml-2"/>
                </div>
            </div>

            <x-input-error :messages="$errors->get('sell_food_beverage')" class="mt-2"/>
        </div>

        <!-- Business Types -->
        <div class="mt-4">
            <x-input-label for="business_type_id" :value="__('Business Type')"/>

            <select
                id="business_type_id"
                name="business_type_id"
                class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                required
            >
                <option value="">Select Business Type</option>
                <template x-for="businessType in filteredBusinessTypes" :key="businessType.id">
                    <option  :value="businessType.id" x-html="businessType.name"></option>
                </template>
            </select>

            <x-input-error :messages="$errors->get('business_type_id')" class="mt-2"/>
        </div>

        <!-- Name -->
        <div class="mt-4">
            <x-input-label for="name" :value="__('Business Name')"/>

            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required/>

            <x-input-error :messages="$errors->get('name')" class="mt-2"/>
        </div>

        <!-- Description -->
        <div class="mt-4">
            <x-input-label for="about" :value="__('About')"/>

            <x-text-input id="about" class="block mt-1 w-full" type="text" name="about" :value="old('about')" required/>

            <x-input-error :messages="$errors->get('about')" class="mt-2"/>
        </div>

        <!-- Phone -->
        <div class="mt-4">
            <x-input-label for="phone" :value="__('Phone')"/>

            <x-text-input id="phone" class="block mt-1 w-full" type="text" name="phone" :value="old('phone')" required/>

            <x-input-error :messages="$errors->get('phone')" class="mt-2"/>
        </div>

        <!-- Address -->
        <div class="mt-4">
            <x-input-label for="address" :value="__('Address')"/>

            <x-text-input id="address" class="block mt-1 w-full" type="text" name="address" :value="old('address')"
                          required/>

            <x-input-error :messages="$errors->get('address')" class="mt-2"/>
        </div>

        <div class="mt-4">
            <x-input-label for="address" :value="__('Location')"/>

            <div id="map" class="mt-1 h-96 w-full"></div>

            <input type="hidden" id="latitude" name="latitude">
            <input type="hidden" id="longitude" name="longitude">

            <x-input-error :messages="$errors->get('latitude')" class="mt-2"/>
        </div>

        <x-primary-button class="mt-4" type="submit">
            Next
        </x-primary-button>
    </form>
@endsection

@push('script')
    <script type="module">
        let url = {!! json_encode(route('admin.json.users.email')) !!};

        const element = document.querySelector('#business_user_email');
        var singleFetch = new Choices(element, {
            allowHTML: false,
            placeholderValue: 'search an user email.',
            searchPlaceholderValue: 'search...',
            removeItemButton: true,
        });

        element.addEventListener("search", _.debounce(async (event) => {
                let data = await fetch(`${url}?search=${event.detail.value}`).then(function (response) {
                    return response.json();
                }).then(function (data) {
                    return data.map(function (email) {
                        return {label: email, value: email};
                    });
                });

                singleFetch.setChoices(data, "value", "label", true);
            }, 300)
        );
    </script>

    <script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD0EMJp7S5B6CKaNTfJ55fv0xEpKOEu2gM&callback=initMap&v=weekly"
        defer
    ></script>

    <script>

        async function initMap() {
            const myLatLng = { lat: 35.3744858, lng: -119.0200281 };

            var map = new google.maps.Map(document.getElementById('map'), {
                zoom: 5,
                center: myLatLng
            });

            var marker = new google.maps.Marker({
                position: myLatLng,
                map: map,
                draggable:true,
            });

            google.maps.event.addListener(marker, 'dragend', function(marker){
                var latLng = marker.latLng;
                console.log(`${latLng.lat()} , ${latLng.lng()}`)
                document.getElementById('latitude').value = latLng.lat();
                document.getElementById('longitude').value = latLng.lng();
            });
        }

        window.initMap = initMap;
    </script>
@endpush
