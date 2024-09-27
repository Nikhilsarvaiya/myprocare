@extends('layouts.app')

@section('main')
    <!-- Heading -->
    <div class="flex justify-between">
        <h1 class="mb-3 text-xl font-semibold dark:text-white">Business Media</h1>

        <a href="{{ route('admin.businesses.index') }}">
            <x-secondary-button>
                <i class="fa-solid fa-arrow-left"></i>
            </x-secondary-button>
        </a>
    </div>

    <form method="POST" enctype="multipart/form-data" action="{{ route('admin.businesses.media.store', request()->route('business')) }}">
        @csrf

        <!-- Business Profile Photo -->
        <div>
            <x-input-label for="profile" :value="__('Business Profile Photo')" />

            <x-text-input id="profile" class="block mt-1" type="file" name="profile" :value="old('profile')" />

            <x-input-error :messages="$errors->get('profile')" class="mt-2" />
        </div>

        <!-- Business Profile Photo -->
        <div class="mt-4">
            <x-input-label for="banner" :value="__('Banner photo or video')" />

            <x-text-input id="banner" class="block mt-1" type="file" name="banner" :value="old('banner')" />

            <x-input-error :messages="$errors->get('banner')" class="mt-2" />
        </div>

        <x-primary-button class="mt-4 !bg-blue-500 !text-white" type="submit">
            Next
        </x-primary-button>
    </form>
@endsection
