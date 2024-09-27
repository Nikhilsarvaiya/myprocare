@extends('layouts.app')

@section('main')
    <!-- Heading -->
    <div class="flex justify-between">
        <h1 class="mb-3 text-xl font-semibold dark:text-white">Products Edit</h1>

        @php
         if (request()->route('redirect') === "edit"){
             $backUrl = route('admin.businesses.products.edit.index', request()->route('business'));
         }else{
             $backUrl = route('admin.businesses.products.create.index', request()->route('business'));
         }
        @endphp
        <a href="{{ $backUrl }}">
            <x-secondary-button>
                <i class="fa-solid fa-arrow-left"></i>
            </x-secondary-button>
        </a>
    </div>

    <form method="POST" enctype="multipart/form-data" action="{{ route('admin.businesses.products.update', ['business' => request()->route('business'), 'product' => $product->id, 'redirect' => request('redirect')]) }}">
        @csrf
        @method('PUT')

        <!-- Product Name -->
        <div>
            <x-input-label for="name" :value="__('Product Name')"/>

            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name') ?? $product->name" required/>

            <x-input-error :messages="$errors->get('name')" class="mt-2"/>
        </div>

        <!-- Product Description -->
        <div class="mt-4">
            <x-input-label for="description" :value="__('Product Description')" />

            <x-text-input id="description" class="block mt-1 w-full" type="text" name="description" :value="old('description') ?? $product->description" required />

            <x-input-error :messages="$errors->get('description')" class="mt-2" />
        </div>

        <!-- Product Price -->
        <div class="mt-4">
            <x-input-label for="price" :value="__('Product Price')"/>

            <x-text-input id="price" class="block mt-1 w-full" type="number" step="any" name="price" :value="old('price') ?? $product->price" required/>

            <x-input-error :messages="$errors->get('price')" class="mt-2"/>
        </div>

        <!-- Product Image -->
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
                src="@if(count($product->media) > 0) {{$product->media[0]->getUrl()}}@endif"
                class="h-20 w-20 mt-4 {{ count($product->media) > 0 ? '' : 'hidden' }}"
                alt="image"
            >

            <x-input-error :messages="$errors->get('image')" class="mt-2" />
        </div>

        <div class="space-x-2">
            <x-primary-button class="mt-4" type="submit">
                Update
            </x-primary-button>
        </div>

        <x-input-error :messages="$errors->get('redirect')" class="mt-2"/>
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
