@extends('layouts.app')

@section('main')
    <!-- Heading -->
    <div class="flex justify-between">
        <h1 class="mb-3 text-xl font-semibold dark:text-white">Business Links</h1>

        <a href="{{ route('admin.businesses.index') }}">
            <x-secondary-button>
                <i class="fa-solid fa-arrow-left"></i>
            </x-secondary-button>
        </a>
    </div>

    <form method="POST" action="{{ route('admin.businesses.links.store', request()->route('business')) }}">
        @csrf

        <!-- Website Link -->
        <div>
            <x-input-label for="website_link" :value="__('Website Link')" />

            <x-text-input id="website_link" class="block mt-1 w-full" type="text" name="website_link" :value="$business->website_link ?? old('website_link')" />

            <x-input-error :messages="$errors->get('website_link')" class="mt-2" />
        </div>

        <!-- Facebook Link -->
        <div class="mt-4">
            <x-input-label for="facebook_link" :value="__('Facebook Link')" />

            <x-text-input id="facebook_link" class="block mt-1 w-full" type="text" name="facebook_link" :value="$business->facebook_link ?? old('facebook_link')" />

            <x-input-error :messages="$errors->get('facebook_link')" class="mt-2" />
        </div>

        <!-- Instagram Link -->
        <div class="mt-4">
            <x-input-label for="instagram_link" :value="__('Instagram Link')" />

            <x-text-input id="instagram_link" class="block mt-1 w-full" type="text" name="instagram_link" :value="$business->instagram_link ?? old('instagram_link')" />

            <x-input-error :messages="$errors->get('instagram_link')" class="mt-2" />
        </div>

        <!-- Twitter Link -->
        <div class="mt-4">
            <x-input-label for="twitter_link" :value="__('Twitter Link')" />

            <x-text-input id="twitter_link" class="block mt-1 w-full" type="text" name="twitter_link" :value="$business->twitter_link ?? old('twitter_link')" />

            <x-input-error :messages="$errors->get('twitter_link')" class="mt-2" />
        </div>

        <!-- YouTube Link -->
        <div class="mt-4">
            <x-input-label for="youtube_link" :value="__('YouTube Link')" />

            <x-text-input id="youtube_link" class="block mt-1 w-full" type="text" name="youtube_link" :value="$business->youtube_link ?? old('youtube_link')" />

            <x-input-error :messages="$errors->get('youtube_link')" class="mt-2" />
        </div>

        <!-- TikTok Link -->
        <div class="mt-4">
            <x-input-label for="tiktok_link" :value="__('TikTok Link')" />

            <x-text-input id="tiktok_link" class="block mt-1 w-full" type="text" name="tiktok_link" :value="$business->tiktok_link ?? old('tiktok_link')" />

            <x-input-error :messages="$errors->get('tiktok_link')" class="mt-2" />
        </div>

        <!-- Uber Link -->
        <div class="mt-4">
            <x-input-label for="uber_link" :value="__('Uber Link')" />

            <x-text-input id="uber_link" class="block mt-1 w-full" type="text" name="uber_link" :value="$business->uber_link ?? old('uber_link')" />

            <x-input-error :messages="$errors->get('uber_link')" class="mt-2" />
        </div>

        <!-- Doordash Link -->
        <div class="mt-4">
            <x-input-label for="doordash_link" :value="__('Doordash Link')" />

            <x-text-input id="doordash_link" class="block mt-1 w-full" type="text" name="doordash_link" :value="$business->doordash_link ?? old('doordash_link')" />

            <x-input-error :messages="$errors->get('doordash_link')" class="mt-2" />
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
