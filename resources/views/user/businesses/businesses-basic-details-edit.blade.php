@extends('layouts.app')

@section('main')
    <!-- Heading -->
    <div class="flex justify-between">
        <h1 class="mb-3 text-xl font-semibold dark:text-white">Edit Business Basic Details</h1>

        <a href="{{ route('user.businesses.index') }}">
            <x-secondary-button>
                <i class="fa-solid fa-arrow-left"></i>
            </x-secondary-button>
        </a>
    </div>

    <form
        method="POST"
        action="{{ route('user.businesses.basic_details.update', $business->id) }}"
        x-data="{
            sellFoodBeverage: {{ $business->businessType->sell_food_beverage }},
            businessTypes: {{ $businessTypes }},
            filteredBusinessTypes: [],
            selectedBusinessTypeId: {{ $business->businessType->id }},
        }"
        x-init="
            $watch('sellFoodBeverage', (value) => filteredBusinessTypes = businessTypes.filter((businessType) => businessType.sell_food_beverage == value));
            $nextTick(() => filteredBusinessTypes = businessTypes.filter((businessType) => businessType.sell_food_beverage == sellFoodBeverage))
        "
    >
        @csrf
        @method('PUT')

        <!-- Sell Food Beverages -->
        <div>
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
            >
                <option value="">Select Business Type</option>
                <template x-for="businessType in filteredBusinessTypes" :key="businessType.id">
                    <option :value="businessType.id" x-html="businessType.name" :selected="businessType.id === selectedBusinessTypeId"></option>
                </template>
            </select>

            <x-input-error :messages="$errors->get('business_type_id')" class="mt-2"/>
        </div>

        <!-- Name -->
        <div class="mt-4">
            <x-input-label for="name" :value="__('Business Name')" />

            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name') ?? $business->name" required />

            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Description -->
        <div class="mt-4">
            <x-input-label for="about" :value="__('About')" />

            <x-text-input id="about" class="block mt-1 w-full" type="text" name="about" :value="old('about') ?? $business->about" required />

            <x-input-error :messages="$errors->get('about')" class="mt-2" />
        </div>

        <!-- Phone -->
        <div class="mt-4">
            <x-input-label for="phone" :value="__('Phone')" />

            <x-text-input id="phone" class="block mt-1 w-full" type="text" name="phone" :value="old('phone') ?? $business->phone" required />

            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
        </div>

        <!-- Address -->
        <div class="mt-4">
            <x-input-label for="address" :value="__('Address')" />

            <x-text-input id="address" class="block mt-1 w-full" type="text" name="address" :value="old('address') ?? $business->address" required />

            <x-input-error :messages="$errors->get('address')" class="mt-2" />
        </div>

        <!-- Location -->
        <div class="mt-4">
            <x-input-label for="address" :value="__('Location')"/>

            <div id="map" class="mt-1 h-96 w-full"></div>

            <input type="hidden" id="latitude" name="latitude" value="{{ $business->latitude ?? old('latitude') }}">
            <input type="hidden" id="longitude" name="longitude" value="{{ $business->longitude ?? old('longitude') }}">

            <x-input-error :messages="$errors->get('latitude')" class="mt-2"/>
        </div>

        <x-primary-button class="my-4" type="submit">
            Next
        </x-primary-button>
    </form>
@endsection


@push('script')
    <script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD0EMJp7S5B6CKaNTfJ55fv0xEpKOEu2gM&callback=initMap&v=weekly"
        defer
    ></script>

    <script>
        async function initMap() {
            const myLatLng = {
                lat: parseFloat(document.getElementById('latitude').value),
                lng: parseFloat(document.getElementById('longitude').value)
            };

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
