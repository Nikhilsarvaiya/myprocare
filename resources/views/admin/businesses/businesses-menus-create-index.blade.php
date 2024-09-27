@extends('layouts.app')

@section('main')
    <!-- Heading -->
    <div class="flex justify-between">
        <h1 class="mb-3 text-xl font-semibold dark:text-white">Business Menus</h1>

        <a href="{{ route('admin.businesses.index') }}">
            <x-secondary-button>
                <i class="fa-solid fa-arrow-left"></i>
            </x-secondary-button>
        </a>
    </div>

    <x-forms.menu-create-edit
        :url="route('admin.businesses.menus.store', request()->route('business'))"
    />

    @if(count($menuItems) > 0)
        @php
            $columns = [
                ['name' => 'id', 'label' => 'Id', 'sortable' => false],
                ['name' => 'image', 'label' => 'Image', 'sortable' => false],
                ['name' => 'name', 'label' => 'Name', 'sortable' => false],
                ['name' => 'description', 'label' => 'Description', 'sortable' => false],
                ['name' => 'price', 'label' => 'price', 'sortable' => false],
                ['name' => 'action', 'label' => 'Action', 'sortable' => false],
            ];
        @endphp

        <div class="mt-4">
            <x-table.main :columns="$columns">
                @foreach($menuItems as $menuItem)
                    <x-table.tr>
                        <x-table.td :th="true">{{ $menuItem->id }}</x-table.td>
                        <x-table.td>
                            <x-web.table-image-thumb :media="$menuItem->media"/>
                        </x-table.td>
                        <x-table.td>{{ $menuItem->name }}</x-table.td>
                        <x-table.td>{{ $menuItem->description }}</x-table.td>
                        <x-table.td>{{ $menuItem->price }}</x-table.td>
                        <x-table.td>
                            <a href="{{ route('admin.businesses.menus.edit', ['business' => request()->route('business'), 'menu' => $menuItem->id, 'redirect' => 'create']) }}" class="mr-2 text-blue-500 hover:underline">Edit</a>
                            <form action="{{ route('admin.businesses.menus.destroy',['business' => request()->route('business'), 'menu' => $menuItem->id]) }}" method="Post"
                                  onclick="return confirm('Are you sure you want to delete user?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:underline">Delete</button>
                            </form>
                        </x-table.td>
                    </x-table.tr>
                @endforeach
            </x-table.main>
        </div>
    @endif
@endsection
