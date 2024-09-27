@props([
    'type' => 'create',
    'url',
    'method' => null,
    'advertisement' => null
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
        <x-input-label for="title" :value="__('Title')"/>

        <x-text-input
            id="title"
            name="title"
            type="text"
            :value="old('title', $advertisement?->title)"
            class="block mt-1 w-full"
            required
            autofocus
        />

        <x-input-error :messages="$errors->get('title')" class="mt-2"/>
    </div>

    <!-- Link -->
    <div class="mt-4">
        <x-input-label for="link" :value="__('Link (optional)')"/>

        <x-text-input
            id="link"
            name="link"
            type="text"
            :value="old('link', $advertisement?->link)"
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
            :value="old('link_title', $advertisement?->link_title)"
        />

        <x-input-error :messages="$errors->get('link_title')" class="mt-2"/>
    </div>

    <div class="mt-4">
        <x-input-label for="business_id" :value="__('Business (optional)')"/>

        <select
            id="business_id"
            name="business_id"
            type="text"
            class="block mt-1 w-full"
        >
            <option value="">search business.</option>
            @if($advertisement?->business)
                <option value="{{ $advertisement->business->id }}"
                        selected>{{ $advertisement->business->name }}</option>
            @endif
        </select>

        <x-input-error :messages="$errors->get('business_id')" class="mt-2"/>
    </div>

    <!-- Image -->
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
            src="@if($advertisement) {{$advertisement->media[0]->getUrl()}} @endif"
            class="h-20 w-20 mt-4 {{ $advertisement ? '' : 'hidden' }}"
            alt="image"
        >

        <x-input-error :messages="$errors->get('image')" class="mt-2"/>
    </div>

    <x-primary-button class="mt-4" type="submit">
        {{ __('Save') }}
    </x-primary-button>
</form>

<x-web.image-preview-js/>

@push('script')
    <script type="module">
        let url = {!! json_encode(route('admin.json.businesses.name')) !!};

        const element = document.querySelector('#business_id');
        var singleFetch = new Choices(element, {
            allowHTML: false,
            placeholderValue: 'search business.',
            searchPlaceholderValue: 'search...',
            removeItemButton: true,
        });

        element.addEventListener("search", _.debounce(async (event) => {
                let data = await fetch(`${url}?search=${event.detail.value}`).then(function (response) {
                    return response.json();
                }).then(function (data) {
                    return data.map(function (business) {
                        return {label: business.name, value: business.id};
                    });
                });

                singleFetch.setChoices(data, "value", "label", true);
            }, 300)
        );
    </script>
@endpush
