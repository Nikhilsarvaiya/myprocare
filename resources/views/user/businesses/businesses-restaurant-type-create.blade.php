@extends('layouts.app')

@section('main')
    <!-- Heading -->
    <div class="flex justify-between">
        <h1 class="mb-3 text-xl font-semibold dark:text-white">Business Restaurant Type</h1>

        <a href="{{ route('user.businesses.index') }}">
            <x-secondary-button>
                <i class="fa-solid fa-arrow-left"></i>
            </x-secondary-button>
        </a>
    </div>

    <form method="POST" action="{{ route('user.businesses.restaurant_type.store', request()->route('business')) }}">
        @csrf

        <!-- Restaurant Type -->
        <div class="mt-4">
            <x-input-label for="restaurant_type" :value="__('Select Restaurant Type')"/>

            <x-select-input
                name="restaurant_type"
                class="block mt-1 w-full"
                default-option="Select Restaurant Type"
                :options="$restaurant_types"
                :selected="old('restaurant_type')"
            />

            <x-input-error :messages="$errors->get('restaurant_type')" class="mt-2"/>
        </div>

        <!-- Food Type -->
        <div class="mt-4">
            <x-input-label for="food_type" :value="__('Select Food Type')"/>

            <x-select-input
                name="food_type"
                class="block mt-1 w-full"
                default-option="Select Food Type"
                :options="$food_types"
                :selected="old('food_type')"
            />

            <x-input-error :messages="$errors->get('food_type')" class="mt-2"/>
        </div>

        <x-primary-button class="mt-4" type="submit">
            Next
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