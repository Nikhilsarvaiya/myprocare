@extends('layouts.app')

@section('main')
    <!-- Heading -->
    <h1 class="mb-3 text-xl font-semibold dark:text-white">Students</h1>

    <div class="lg:flex lg:justify-between items-center">
        <!-- Search Bar -->
        <x-web.table-search-bar :url="route('admin.students.index')" />

        <div class="mb-3 flex items-center space-x-3">
            <a href="{{ route('admin.students.index') }}">
                <x-secondary-button>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                         stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99"/>
                    </svg>
                </x-secondary-button>
            </a>
            <a href="{{ route('api-call-report') }}">
                
                <form action="{{ route('api-call-report') }}" method="Post"
                onclick="return confirm('Are you sure you want to fetch the data manually ? It will automatically store the data on a weekly basis.')">
                @csrf
                @method('GET')
                    <x-secondary-button type="submit">
                        Featch Data Manully
                    </x-secondary-button>
              </form>
            </a>
        </div>
    </div>

    @php
        $columns = [
            ['name' => 'id', 'label' => 'Id', 'sortable' => true],
            ['name' => 'fname', 'label' => 'First Name', 'sortable' => true],
            ['name' => 'lname', 'label' => 'Last Name', 'sortable' => true],
            ['name' => 'room', 'label' => 'Room', 'sortable' => true],
            ['name' => 'enrollment_status', 'label' => 'Enrollment Status', 'sortable' => false],
            ['name' => 'type', 'label' => 'Type', 'sortable' => true],
            ['name' => 'address', 'label' => 'Address', 'sortable' => true],
            ['name' => 'adminssion_date', 'label' => 'Adminssion Date', 'sortable' => true],
            ['name' => 'graduation_date', 'label' => 'Graduation Date', 'sortable' => true],
            ['name' => 'created_at', 'label' => 'Created At', 'sortable' => true],
            // ['name' => 'updated_at', 'label' => 'Updated At', 'sortable' => true],
        ];
    @endphp

    <x-table.main :columns="$columns">
        @foreach($students as $user)
            <x-table.tr>
                <x-table.td :th="true">{{ $user->id }}</x-table.td>
                <x-table.td>{{ $user->fname }}</x-table.td>
                <x-table.td>{{ $user->lname }}</x-table.td>
                <x-table.td>{{ $user->room }}</x-table.td>
                <x-table.td>{{ $user->enrollment_status }}</x-table.td>
                <x-table.td>{{ $user->type }}</x-table.td>
                <x-table.td>{{ $user->address }}, {{ $user->city }}, {{ $user->country_code }}, {{ $user->zip }}</x-table.td>
                <x-table.td>{{ $user->adminssion_date ? date('Y-m-d ', strtotime($user->adminssion_date)) : "-" }}</x-table.td>
                <x-table.td>{{ $user->graduation_date ? date('Y-m-d ', strtotime($user->graduation_date)) : "-" }}</x-table.td>
                <x-table.td>{{ $user->created_at->diffForHumans() }}</x-table.td>
                {{-- <x-table.td>{{ $user->updated_at->diffForHumans() }}</x-table.td> --}}
            </x-table.tr>
        @endforeach
    </x-table.main>

    <div class="py-4">
        {{ $students->links() }}
    </div>
@endsection
