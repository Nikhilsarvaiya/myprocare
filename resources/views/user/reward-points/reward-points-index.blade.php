@extends('layouts.app')

@section('main')
    <!-- Heading -->
    <h1 class="mb-3 text-xl font-semibold dark:text-white">Reward Points</h1>

    <div class="lg:flex lg:justify-between items-center">
        <!-- Search Bar -->
        <x-web.table-search-bar :url="route('user.reward-points.index')" />

        <div class="mb-3 flex items-center space-x-3">
            <a href="{{ route('user.reward-points.index') }}">
                <x-secondary-button>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                         stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99"/>
                    </svg>
                </x-secondary-button>
            </a>
            <a href="{{ route('user.reward-points.create') }}">
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
            ['name' => 'email', 'label' => 'Email', 'sortable' => true],
            ['name' => 'created_at', 'label' => 'Created At', 'sortable' => true],
            ['name' => 'updated_at', 'label' => 'Updated At', 'sortable' => true],
            ['name' => 'action', 'label' => 'Action', 'sortable' => false],
        ];
    @endphp

    <x-table.main :columns="$columns">
        @foreach($reward_points as $reward_point)
            <x-table.tr>
                <x-table.td :th="true">{{ $reward_point->id }}</x-table.td>
                <x-table.td>{{ $reward_point->name }}</x-table.td>
                <x-table.td>{{ $reward_point->email }}</x-table.td>
                <x-table.td>{{ $reward_point->created_at->diffForHumans() }}</x-table.td>
                <x-table.td>{{ $reward_point->updated_at->diffForHumans() }}</x-table.td>
            </x-table.tr>
        @endforeach
    </x-table.main>

    <div class="py-4">
        {{ $reward_points->links() }}
    </div>
@endsection
