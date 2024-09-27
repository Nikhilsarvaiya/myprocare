@extends('layouts.app')

@section('main')
    <!-- Heading -->
    <div class="flex justify-between">
        <x-web.page-title :title="'Edit Deal'"/>

        <a href="{{ route('admin.deals.index') }}">
            <x-secondary-button>
                <i class="fa-solid fa-arrow-left"></i>
            </x-secondary-button>
        </a>
    </div>

    <form method="POST" enctype="multipart/form-data" action="{{ route('admin.deals.update', $deal->id) }}">
        @csrf
        @method('PUT')

        <!-- Deal Name -->
        <div>
            <x-input-label for="name" :value="__('Deal Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="$deal->name" required autofocus />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Deal Description -->
        <div class="mt-4">
            <x-input-label for="description" :value="__('Deal Description')" />
            <x-text-input id="description" class="block mt-1 w-full" type="text" name="description" :value="$deal->description" required />
            <x-input-error :messages="$errors->get('description')" class="mt-2" />
        </div>

        <!-- Deal Image -->
        <div class="mt-4">
            <x-input-label for="image" :value="__('Deal Image')" />

            <x-text-input type="file" id="image" name="image" accept="image/*" class="block mt-1 w-full" />

            <img
                id="preview-image"
                src="@if(count($deal->media) > 0) {{$deal->media[0]->getUrl()}}@endif"
                class="h-20 w-20 mt-4 {{ count($deal->media) > 0 ? '' : 'hidden' }}"
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
