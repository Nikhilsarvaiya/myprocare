@extends('layouts.app')

@section('main')
    {{-- Active Students --}}
    <h1 class="mb-3 mt-4 text-xl font-semibold dark:text-white">Active Students</h1>

    @php
        $columns_active_students = [
            ['name' => 'created_at_date', 'label' => 'Date', 'sortable' => false],
            ['name' => 'part_time', 'label' => 'Part-Time Students', 'sortable' => false],
            ['name' => 'full_time', 'label' => 'Full-Time Students', 'sortable' => false],
            ['name' => 'total', 'label' => 'Total', 'sortable' => false],
        ];
    @endphp

    <x-table.main :columns="$columns_active_students">
        @foreach($active_students as $active_student_room)
            <x-table.tr>
                <x-table.td :th="true">{{ $active_student_room->created_at_date ? date('Y-m-d ', strtotime($active_student_room->created_at_date)) : "-" }}</x-table.td>
                <x-table.td>{{ $active_student_room->part_time }}</x-table.td>
                <x-table.td>{{ $active_student_room->full_time }}</x-table.td>
                <x-table.td>{{ $active_student_room->total }}</x-table.td>
            </x-table.tr>
        @endforeach
    </x-table.main>

    <div class="py-4">
        {{ $active_students->links() }}
    </div>
@endsection
