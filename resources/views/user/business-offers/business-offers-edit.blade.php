@extends('layouts.app')

@section('main')
    <!-- Heading -->
    <div class="flex justify-between">
        <x-web.page-title :title="'Edit Business Offer'"/>

        <a href="{{ route('user.business-offers.index') }}">
            <x-secondary-button>
                <i class="fa-solid fa-arrow-left"></i>
            </x-secondary-button>
        </a>
    </div>

    <form method="POST" enctype="multipart/form-data" action="{{ route('user.business-offers.update', $business_offer->id) }}">
        @csrf
        @method('PUT')

        <div>
            <x-input-label for="title" :value="__('Title')"/>

            <x-text-input
                id="title"
                name="title"
                type="text"
                :value="old('title', $business_offer->title)"
                class="block mt-1 w-full"
                required
                autofocus
            />

            <x-input-error :messages="$errors->get('title')" class="mt-2"/>
        </div>

        <div class="mt-4">
            <x-input-label for="description" :value="__('Description')"/>

            <x-text-input
                id="description"
                name="description"
                type="text"
                :value="old('description', $business_offer->description)"
                class="block mt-1 w-full"
                required
            />

            <x-input-error :messages="$errors->get('description')" class="mt-2"/>
        </div>

        <div class="mt-4">
            <x-input-label for="reward_point" :value="__('Reward Point')"/>

            <x-text-input
                id="reward_point"
                name="reward_point"
                type="number"
                :value="old('reward_point', $business_offer->reward_point)"
                class="block mt-1 w-full"
                required
            />

            <x-input-error :messages="$errors->get('reward_point')" class="mt-2"/>
        </div>

        <div class="mt-4">
            <x-input-label for="business_id" :value="__('Business')"/>

            <x-select-input
                id="business_id"
                name="business_id"
                default-option="Select Restaurant Type"
                :options="$businesses"
                :selected="old('business_id', $business_offer->business_id)"
                class="block mt-1 w-full"
            />

            <x-input-error :messages="$errors->get('business_id')" class="mt-2"/>
        </div>

        <div class="mt-4">
            <x-input-label for="image" :value="__('Image')" />

            <x-text-input
                id="image"
                name="image"
                type="file"
                accept="image/*"
                class="block mt-1 w-full"
            />

            <img
                id="preview-image"
                src="@if(count($business_offer->media) > 0) {{$business_offer->media[0]->getUrl()}}@endif"
                class="h-20 w-20 mt-4 {{ count($business_offer->media) > 0 ? '' : 'hidden' }}"
                alt="image"
            >

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
