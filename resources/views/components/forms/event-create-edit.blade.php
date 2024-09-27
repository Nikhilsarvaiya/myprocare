@props([
    'type' => 'create',
    'url',
    'method' => null,
    'event' => null
])

<form
    action="{{ $url }}"
    method="POST"
    enctype="multipart/form-data"
>
    @csrf

    @if($method)
        @method($method)
    @endif

    <!-- Name -->
    <div>
        <x-input-label for="name" :value="__('Name')"/>

        <x-text-input
            id="name"
            name="name"
            type="text"
            :value="old('name', $event?->name)"
            class="block mt-1 w-full"
            required
            autofocus
        />

        <x-input-error :messages="$errors->get('name')" class="mt-2"/>
    </div>

    <!-- Description -->
    <div class="mt-4">
        <x-input-label for="description" :value="__('Description')"/>

        <x-text-input
            id="description"
            name="description"
            type="text"
            :value="old('description', $event?->description)"
            class="block mt-1 w-full"
            required
        />

        <x-input-error :messages="$errors->get('description')" class="mt-2"/>
    </div>

    <!-- Link -->
    <div class="mt-4">
        <x-input-label for="link" :value="__('Link (optional)')"/>

        <x-text-input
            id="link"
            name="link"
            type="text"
            :value="old('link', $event?->link)"
            class="block mt-1 w-full"
        />

        <x-input-error :messages="$errors->get('link')" class="mt-2"/>
    </div>

    <!-- Link Title -->
    <div class="mt-4">
        <x-input-label for="link_title" :value="__('Link Title (required if link)')"/>

        <x-text-input
            id="link_title"
            name="link_title"
            type="text"
            class="block mt-1 w-full"
            :value="old('link_title', $event?->link_title)"
        />

        <x-input-error :messages="$errors->get('link_title')" class="mt-2"/>
    </div>

    <!-- Image -->
    <div class="mt-4">
        <x-input-label for="image" :value="__('Image')"/>

        <x-text-input
            id="image"
            name="image"
            type="file"
            accept="image/*"
            class="block mt-1 w-full"
        />

        <img
            id="preview-image"
            src="@if($event) {{$event->media[0]->getUrl()}} @endif"
            class="h-20 w-20 mt-4 {{ $event ? '' : 'hidden' }}"
            alt="image"
        >

        <x-input-error :messages="$errors->get('image')" class="mt-2"/>
    </div>

    <x-primary-button class="mt-4" type="submit">
        {{ __('Save') }}
    </x-primary-button>
</form>

<x-web.image-preview-js/>
