@extends('layouts.app')

@section('main')
    <!-- Heading -->
    <h1 class="mb-3 text-xl font-semibold dark:text-white">Centers</h1>

    <div class="lg:flex lg:justify-between items-center">
        <!-- Search Bar -->
        <x-web.table-search-bar :url="route('admin.centers.index')" />

        <div class="mb-3 flex items-center space-x-3">
            <a href="{{ route('admin.centers.index') }}">
                <x-secondary-button>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                         stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99"/>
                    </svg>
                </x-secondary-button>
            </a>
            <a href="{{ route('admin.centers.create') }}">
                <x-secondary-button @click="showAddCategoryModal = true" type="button">
                    Add
                </x-secondary-button>
            </a>
        </div>
    </div>

    @php
        $columns = [
            ['name' => 'id', 'label' => 'Id', 'sortable' => true],
            ['name' => 'name', 'label' => 'Name', 'sortable' => true],
            ['name' => 'capacity', 'label' => 'Capacity', 'sortable' => true],
            ['name' => 'goal', 'label' => 'Goal', 'sortable' => true],
            ['name' => 'created_at', 'label' => 'Created At', 'sortable' => true],
            ['name' => 'updated_at', 'label' => 'Updated At', 'sortable' => true],
            ['name' => 'action', 'label' => 'Action', 'sortable' => false],
        ];
    @endphp

    <x-table.main :columns="$columns">
        @foreach($centers as $center)
            <x-table.tr>
                <x-table.td :th="true">{{ $center->id }}</x-table.td>
                <x-table.td>{{ $center->name }}</x-table.td>
                <x-table.td>{{ $center->capacity ?? '-' }}</x-table.td>
                <x-table.td>{{ $center->goal.' %' ?? '0 %' }}</x-table.td>
                <x-table.td>{{ $center->created_at->diffForHumans() }}</x-table.td>
                <x-table.td>{{ $center->updated_at->diffForHumans() }}</x-table.td>
                <x-table.td>
                    <a href="{{ route('admin.centers.edit', $center->id) }}"
                       class="mr-2 text-blue-500 hover:underline">Edit</a>
                    <form action="{{ route('admin.centers.destroy',$center->id) }}" method="Post"
                          onclick="return confirm('Are you sure you want to delete center?')">
                        @csrf
                        @method('DELETE')
                        <x-text-input
                            type="hidden"
                            name="id"
                            :value="$center->id"
                        />
                        <button type="submit" class="text-red-500 hover:underline">Delete</button>
                    </form>
                </x-table.td>
            </x-table.tr>
        @endforeach
    </x-table.main>

    <div class="py-4">
        {{ $centers->links() }}
    </div>
@endsection
