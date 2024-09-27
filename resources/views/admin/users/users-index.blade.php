@extends('layouts.app')

@section('main')
    <!-- Heading -->
    <h1 class="mb-3 text-xl font-semibold dark:text-white">Users</h1>

    <div class="lg:flex lg:justify-between items-center">
        <!-- Search Bar -->
        <x-web.table-search-bar :url="route('admin.users.index')" />

        <div class="mb-3 flex items-center space-x-3">
            <a href="{{ route('admin.users.index') }}">
                <x-secondary-button>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                         stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99"/>
                    </svg>
                </x-secondary-button>
            </a>
            <a href="{{ route('admin.users.create') }}">
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
            ['name' => 'role', 'label' => 'Role', 'sortable' => false],
            ['name' => 'created_at', 'label' => 'Created At', 'sortable' => true],
            ['name' => 'updated_at', 'label' => 'Updated At', 'sortable' => true],
            ['name' => 'action', 'label' => 'Action', 'sortable' => false],
        ];
    @endphp

    <x-table.main :columns="$columns">
        @foreach($users as $user)
            <x-table.tr>
                <x-table.td :th="true">{{ $user->id }}</x-table.td>
                <x-table.td>{{ $user->name }}</x-table.td>
                <x-table.td>{{ $user->email }}</x-table.td>
                <x-table.td>
                    @foreach($user->roles as $role)
                        <span
                            class="bg-blue-100 text-blue-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300"
                        >
                            {{ $role->name }}
                        </span>
                    @endforeach
                </x-table.td>
                <x-table.td>{{ $user->created_at->diffForHumans() }}</x-table.td>
                <x-table.td>{{ $user->updated_at->diffForHumans() }}</x-table.td>
                <x-table.td>
                    <a href="{{ route('admin.users.edit', $user->id) }}"
                       class="mr-2 text-blue-500 hover:underline">Edit</a>
                    <form action="{{ route('admin.users.destroy',$user->id) }}" method="Post"
                          onclick="return confirm('Are you sure you want to delete user?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-500 hover:underline">Delete</button>
                    </form>
                </x-table.td>
            </x-table.tr>
        @endforeach
    </x-table.main>

    <div class="py-4">
        {{ $users->links() }}
    </div>
@endsection
