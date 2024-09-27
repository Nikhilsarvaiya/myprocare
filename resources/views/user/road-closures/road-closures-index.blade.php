@extends('layouts.app')

@section('main')
    <x-web.page-title :title="'Road Closures'"/>

    <div class="lg:flex lg:justify-between items-center">
        <!-- Search Bar -->
        <x-web.table-search-bar :url="route('user.road-closures.index')"/>

        <div class="mb-3 flex items-center space-x-3">
            <a href="{{ route('user.road-closures.index') }}">
                <x-secondary-button>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                         stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99"/>
                    </svg>
                </x-secondary-button>
            </a>
            <a href="{{ route('user.road-closures.create') }}">
                <x-secondary-button @click="showAddCategoryModal = true" type="button">
                    Add
                </x-secondary-button>
            </a>
        </div>
    </div>

    @php
        $columns = [
            ['name' => 'id', 'label' => 'Id', 'sortable' => true],
            ['name' => 'user_id', 'label' => 'User', 'sortable' => false],
            ['name' => 'title', 'label' => 'Title', 'sortable' => true],
            ['name' => 'start_time', 'label' => 'Start Time', 'sortable' => true],
            ['name' => 'end_time', 'label' => 'End Time', 'sortable' => true],
            ['name' => 'updated_at', 'label' => 'Updated At', 'sortable' => true],
            ['name' => 'action', 'label' => 'Action', 'sortable' => false],
        ];
    @endphp

    <x-table.main :columns="$columns">
        @foreach($road_closures as $road_closure)
            <x-table.tr>
                <x-table.td :th="true">{{ $road_closure->id }}</x-table.td>
                <x-table.td>{{ $road_closure->user->name }}</x-table.td>
                <x-table.td>{{ $road_closure->title }}</x-table.td>
                <x-table.td>{{ $road_closure->start_time->format('d-m-Y H:i') }}</x-table.td>
                <x-table.td>{{ $road_closure->end_time->format('d-m-Y H:i') }}</x-table.td>
                <x-table.td>{{ $road_closure->updated_at->diffForHumans() }}</x-table.td>
                <x-table.td>
                    <a href="{{ route('user.road-closures.edit', $road_closure->id) }}" class="mr-2 text-blue-500 hover:underline">Edit</a>
                    <form action="{{ route('user.road-closures.destroy',$road_closure->id) }}" method="Post"
                          onclick="return confirm('Are you sure you want to delete road closure?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-500 hover:underline">Delete</button>
                    </form>
                </x-table.td>
            </x-table.tr>
        @endforeach
    </x-table.main>

    <div class="py-4">
        {{ $road_closures->links() }}
    </div>
@endsection
