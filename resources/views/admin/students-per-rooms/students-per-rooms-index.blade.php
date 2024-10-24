@extends('layouts.app')

@section('main')
    {{-- Students per room --}}
    <h1 class="mb-3 mt-4 text-xl font-semibold dark:text-white">Students per room</h1>

    @php
        $columns_student_per_room = [
            ['name' => 'created_at_date', 'label' => 'Date', 'sortable' => false],
            ['name' => 'school_age', 'label' => 'School Age', 'sortable' => false],
            ['name' => 'preschool_age', 'label' => 'Preschool', 'sortable' => false],
            ['name' => 'pre_flex_age', 'label' => 'Pre Flex', 'sortable' => false],
            ['name' => 'toddler_room_b_age', 'label' => "Toddler's Room B", 'sortable' => false],
            ['name' => 'school_age_b_age', 'label' => 'School Age B', 'sortable' => false],
            ['name' => 'summer_camp_age', 'label' => 'Summer Camp', 'sortable' => false],
            ['name' => 'total_students', 'label' => 'Total Students', 'sortable' => false],
        ];
    @endphp

    <x-table.main :columns="$columns_student_per_room">
        @foreach($students_per_rooms as $student_room)
            <x-table.tr>
                <x-table.td :th="true">{{ $student_room->created_at_date ? date('Y-m-d ', strtotime($student_room->created_at_date)) : "-" }}</x-table.td>
                <x-table.td>{{ $student_room->school_age }}</x-table.td>
                <x-table.td>{{ $student_room->preschool_age }}</x-table.td>
                <x-table.td>{{ $student_room->pre_flex_age }}</x-table.td>
                <x-table.td>{{ $student_room->toddler_room_b_age }}</x-table.td>
                <x-table.td>{{ $student_room->school_age_b_age }}</x-table.td>
                <x-table.td>{{ $student_room->summer_camp_age }}</x-table.td>
                <x-table.td>{{ $student_room->total_students }}</x-table.td>
            </x-table.tr>
        @endforeach
    </x-table.main>

    <div class="py-4">
        {{ $students_per_rooms->links() }}
    </div>
@endsection
