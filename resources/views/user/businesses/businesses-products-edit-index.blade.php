@extends('layouts.app')

@section('main')
    <!-- Heading -->
    <div class="flex justify-between">
        <h1 class="mb-3 text-xl font-semibold dark:text-white">Edit Business Products</h1>

        <a href="{{ route('user.businesses.media.edit', request()->route('business')) }}">
            <x-secondary-button>
                <i class="fa-solid fa-arrow-left"></i>
            </x-secondary-button>
        </a>
    </div>

    <form method="POST" enctype="multipart/form-data" action="{{ route('user.businesses.products.store', request()->route('business')) }}">
        @csrf
        @method('PUT')

        <!-- Product Name -->
        <div>
            <x-input-label for="name" :value="__('Product Name')"/>

            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required/>

            <x-input-error :messages="$errors->get('name')" class="mt-2"/>
        </div>

        <!-- Product Description -->
        <div class="mt-4">
            <x-input-label for="description" :value="__('Product Description')" />

            <x-text-input id="description" class="block mt-1 w-full" type="text" name="description" :value="old('description')" required />

            <x-input-error :messages="$errors->get('description')" class="mt-2" />
        </div>

        <!-- Product Price -->
        <div class="mt-4">
            <x-input-label for="price" :value="__('Product Price')"/>

            <x-text-input id="price" class="block mt-1 w-full" type="number" step="any" name="price" :value="old('price')" required/>

            <x-input-error :messages="$errors->get('price')" class="mt-2"/>
        </div>

        <div class="mt-4">
            <x-input-label for="image" :value="__('Image (optional)')"/>

            <x-text-input
                id="image"
                name="image"
                type="file"
                accept="image/*"
                class="block mt-1 w-full"
                multiple
            />

            <img id="preview-image" src="#" class="h-20 w-20 mt-4 hidden" alt="image">

            <x-input-error :messages="$errors->get('image')" class="mt-2"/>
        </div>

        <div class="space-x-2">
            <x-primary-button class="mt-4" type="submit">
                Add
            </x-primary-button>

            <a href="{{ route('user.businesses.index') }}">
                <x-primary-button class="mt-4 !bg-blue-500 !text-white" type="button">
                    Complete
                </x-primary-button>
            </a>
        </div>
    </form>

    <!-- Menu Products Table -->
    @if(count($products) > 0)
        <div class="mt-4 relative overflow-x-auto shadow-md rounded-lg">
            <table class="w-full text-left text-sm text-gray-500 dark:text-gray-400">
                <thead class="bg-gray-100 text-xs uppercase text-gray-700 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        Id
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Image
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Name
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Description
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Price
                    </th>
                    <th scope="col" class="px-6 py-3">
                        <span>Action</span>
                    </th>
                </tr>
                </thead>
                <tbody>
                @foreach($products as $product)
                    <tr class="border-b bg-white dark:border-gray-700 dark:bg-gray-800">
                        <th scope="row" class="whitespace-nowrap px-6 py-4 font-medium text-gray-900 dark:text-white">
                            {{ $product->id }}
                        </th>
                        <td class="px-6 py-4">
                            <x-web.table-image-thumb :media="$product->media"/>
                        </td>
                        <td class="px-6 py-4">
                            {{ $product->name }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $product->description }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $product->price }}
                        </td>
                        <td class="px-6 py-4">
                            <a href="{{ route('user.businesses.products.edit', ['business' => request()->route('business'), 'product' => $product->id, 'redirect' => 'edit']) }}" class="mr-2 text-blue-500 hover:underline">Edit</a>
                            <form
                                action="{{ route('user.businesses.products.destroy',['business' => request()->route('business'), 'product' => $product->id]) }}"
                                method="Post"
                                onclick="return confirm('Are you sure you want to delete user?')"
                            >
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="redirect_route" value="edit">
                                <button type="submit" class="text-red-500 hover:underline">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    @endif
@endsection
