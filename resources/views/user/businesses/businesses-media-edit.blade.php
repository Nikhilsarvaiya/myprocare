@extends('layouts.app')

@section('main')
    <!-- Heading -->
    <div class="flex justify-between">
        <h1 class="mb-3 text-xl font-semibold dark:text-white">Edit Business Media</h1>

        <a href="{{ route('user.businesses.links.edit', request()->route('business')) }}">
            <x-secondary-button>
                <i class="fa-solid fa-arrow-left"></i>
            </x-secondary-button>
        </a>
    </div>

    <form method="POST" enctype="multipart/form-data" action="{{ route('user.businesses.media.update', request()->route('business')) }}">
        @csrf
        @method('PUT')

        <!-- Business Profile Photo -->
        <div>
            <x-input-label for="profile" :value="__('Business Profile Photo')" />

            <x-text-input
                id="profile"
                name="profile"
                type="file"
                :value="old('profile')"
                class="block mt-1"
            />

            <img id="profile-preview-before-upload" class="mt-3 h-20 w-20 object-fit">

            <x-input-error :messages="$errors->get('profile')" class="mt-2" />
        </div>

        <!-- Business Banner Photo -->
        <div class="mt-4">
            <x-input-label for="banner" :value="__('Banner photo or video')" />

            <x-text-input id="banner" class="block mt-1" type="file" name="banner" :value="old('banner')" />

            <img id="banner-preview-before-upload" class="mt-3 h-20 w-20 object-fit">

            <x-input-error :messages="$errors->get('banner')" class="mt-2" />
        </div>

        <x-primary-button class="mt-4" type="submit">
            Next
        </x-primary-button>
    </form>
@endsection

@push('script')
    <script>
        let profileFileUrl = {!! json_encode($business->getFirstMediaUrl('profile')) !!};
        document.getElementById('profile-preview-before-upload').src = profileFileUrl;

        let bannerFileFileUrl = {!! json_encode($business->getFirstMediaUrl('banner')) !!};
        document.getElementById('banner-preview-before-upload').src = bannerFileFileUrl;

        document.getElementById('profile').addEventListener('change', function (e) {
            document.getElementById('profile-preview-before-upload').src = URL.createObjectURL(e.target.files[0]);
        });

        document.getElementById('banner').addEventListener('change', function (e) {
            document.getElementById('banner-preview-before-upload').src = URL.createObjectURL(e.target.files[0]);
        });
    </script>
@endpush
