@extends('layouts.business-register')

@section('main')
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100 dark:bg-gray-900">
        <div>
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </div>

        <div class="w-full sm:max-w-screen-xl mx-auto mt-6 px-6 py-4 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">
            <form
                method="POST"
                action="{{ route('business_register.basic_details.store') }}"
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

                <div class="grid grid-cols-12 sm:gap-8">
                    <div class="col-span-12 sm:col-span-6">
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
                            <x-input-label for="business_type" :value="__('Business Type')"/>

                            <select
                                id="business_type"
                                name="business_type"
                                class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                                required
                            >
                                <option value="">Select Business Type</option>
                                <template x-for="businessType in filteredBusinessTypes" :key="businessType.id">
                                    <option  :value="businessType.id" x-html="businessType.name"></option>
                                </template>
                            </select>

                            <x-input-error :messages="$errors->get('business_type')" class="mt-2"/>
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
                    </div>
                    <div class="mt-4 sm:mt-0 col-span-12 sm:col-span-6">
                        <!-- Location -->
                        <div class="h-full flex flex-col">
                            <x-input-label for="address" :value="__('Location')"/>

                            <div id="map" class="mt-1 h-80 sm:grow w-full"></div>

                            <input type="hidden" id="latitude" name="latitude">
                            <input type="hidden" id="longitude" name="longitude">

                            <x-input-error :messages="$errors->get('latitude')" class="mt-2"/>
                        </div>
                    </div>
                </div>


                <div class="flex items-center justify-end mt-4">
                    <x-primary-button type="submit">
                        {{ __('Next') }}
                    </x-primary-button>
                </div>

            </form>
        </div>
    </div>
@endsection

@push('script')
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
