@extends('layouts.app')

@section('main')
    {{-- InActive Students --}}
    <h1 class="mb-3 mt-4 text-xl font-semibold dark:text-white">Inactive Students</h1>

    @php
        $columns_inactive_students = [
            ['name' => 'created_at_date', 'label' => 'Date', 'sortable' => false],
            ['name' => 'part_time', 'label' => 'Part-Time Students', 'sortable' => false],
            ['name' => 'full_time', 'label' => 'Full-Time Students', 'sortable' => false],
            ['name' => 'total', 'label' => 'Total', 'sortable' => false],
        ];
    @endphp

    <x-table.main :columns="$columns_inactive_students">
        @foreach($inactive_students as $inactive_student_room)
            <x-table.tr>
                <x-table.td :th="true">{{ $inactive_student_room->created_at_date ? date('Y-m-d ', strtotime($inactive_student_room->created_at_date)) : "-" }}</x-table.td>
                <x-table.td>{{ $inactive_student_room->part_time }}</x-table.td>
                <x-table.td>{{ $inactive_student_room->full_time }}</x-table.td>
                <x-table.td>{{ $inactive_student_room->total }}</x-table.td>
            </x-table.tr>
        @endforeach
    </x-table.main>

    <div class="py-4">
        {{ $inactive_students->links() }}
    </div>
@endsection
