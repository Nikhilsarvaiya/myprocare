@extends('layouts.app')

@section('main')
    <!-- Heading -->
    <div class="flex justify-between">
        <h1 class="mb-3 text-xl font-semibold dark:text-white">Business Type Create</h1>

        <a href="{{ route('admin.business-types.index') }}">
            <x-secondary-button>
                <i class="fa-solid fa-arrow-left"></i>
            </x-secondary-button>
        </a>
    </div>

    <form
        method="POST"
        enctype="multipart/form-data"
        action="{{ route('admin.business-types.store') }}"
        x-data="{ sellFoodBeverage: {{ old('sell_food_beverage', 0) }} }"
    >
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />

            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />

            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Description -->
        <div class="mt-4">
            <x-input-label for="description" :value="__('Description')" />

            <x-text-input id="description" class="block mt-1 w-full" type="text" name="description" :value="old('description')" required />

            <x-input-error :messages="$errors->get('description')" class="mt-2" />
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

        <!-- Image -->
        <div class="mt-4">
            <x-input-label for="image" :value="__('Image')" />

            <x-text-input type="file" id="image" name="image" accept="image/*" class="block mt-1 w-full" required/>

            <img id="preview-image" src="#" class="h-20 w-20 mt-4 hidden" alt="image">

            <x-input-error :messages="$errors->get('image')" class="mt-2" />
        </div>

        <x-primary-button class="mt-4" type="submit">
            {{ __('Save') }}
        </x-primary-button>
    </form>
@endsection

@push('script')
    <script>
        document.getElementById('image').onchange = evt => {
            const preview = document.getElementById('preview-image');
            preview.style.display = 'block';
            const [file] = document.getElementById('image').files
            if (file) {
                preview.src = URL.createObjectURL(file)
            }
        }
    </script>
@endpush
