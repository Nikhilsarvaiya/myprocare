@props([
    'type' => 'create-index',
    'url',
    'method' => null,
    'menu' => null
])

<form
    method="POST"
    enctype="multipart/form-data"
    action="{{ $url }}"
>
    @csrf

    @if($method)
        @method($method)
    @endif

    <!-- Menu Name -->
    <div>
        <x-input-label for="name" :value="__('Item Name')"/>

        <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $menu?->name)"
                      required/>

        <x-input-error :messages="$errors->get('name')" class="mt-2"/>
    </div>

    <!-- Menu Description -->
    <div class="mt-4">
        <x-input-label for="description" :value="__('Product Description')"/>

        <x-text-input id="description" class="block mt-1 w-full" type="text" name="description"
                      :value="old('description', $menu?->description)"/>

        <x-input-error :messages="$errors->get('description')" class="mt-2"/>
    </div>

    <!-- Menu Price -->
    <div class="mt-4">
        <x-input-label for="price" :value="__('Item Price')"/>

        <x-text-input id="price" class="block mt-1 w-full" type="text" name="price" :value="old('price', $menu?->price)"
                      required/>

        <x-input-error :messages="$errors->get('price')" class="mt-2"/>
    </div>

    <!-- Menu Image -->
    <div class="mt-4">
        <x-input-label for="image" :value="__('Image (optional)')"/>

        <x-text-input
            id="image"
            name="image"
            type="file"
            accept="image/*"
            class="block mt-1 w-full"
        />

        @if($menu)
            <img
                id="preview-image"
                src="@if(count($menu->media) > 0) {{$menu->media[0]->getUrl()}}@endif"
                class="h-20 w-20 mt-4 {{ count($menu->media) > 0 ? '' : 'hidden' }}"
                alt="image"
            >
        @else
            <img
                id="preview-image"
                src="#"
                class="h-20 w-20 mt-4 hidden"
                alt="image"
            >
        @endif

        <x-input-error :messages="$errors->get('image')" class="mt-2"/>
    </div>

    <div class="space-x-2">
        @if($menu)
            <x-primary-button class="mt-4" type="submit">
                Update
            </x-primary-button>
        @else
            <x-primary-button class="mt-4" type="submit">
                Add
            </x-primary-button>

            <a href="{{ route('user.businesses.index') }}">
                <x-primary-button class="mt-4 !bg-blue-500 !text-white" type="button">
                    Complete
                </x-primary-button>
            </a>
        @endif
    </div>

    <x-input-error :messages="$errors->get('redirect')" class="mt-2"/>
</form>

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
