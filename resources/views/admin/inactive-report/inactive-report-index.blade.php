@extends('layouts.app')

@section('main')
    <!-- Heading -->
    <h1 class="mb-3 text-xl font-semibold dark:text-white">In Active Child Database Report</h1>

    @php
        $columns = [
            ['name' => 'room', 'label' => 'Room', 'sortable' => false],
            ['name' => 'name', 'label' => 'Count of Room', 'sortable' => false],
        ];
    @endphp

    <x-table.main :columns="$columns">
        <x-table.tr>
            <x-table.td>Preschool</x-table.td>
            <x-table.td>{{ $data['preschool'] }}</x-table.td>
        </x-table.tr>
        <x-table.tr>
            <x-table.td>Preschool Flex</x-table.td>
            <x-table.td>{{ $data['preschool_flex'] }}</x-table.td>
        </x-table.tr>
        <x-table.tr>
            <x-table.td>School Age</x-table.td>
            <x-table.td>{{ $data['school_age'] }}</x-table.td>
        </x-table.tr>
        <x-table.tr>
            <x-table.td>Toddlers</x-table.td>
            <x-table.td>{{ $data['toddlers'] }}</x-table.td>
        </x-table.tr>
        <x-table.tr>
            <x-table.td>Grand Total</x-table.td>
            <x-table.td>{{ $data['grand_total'] }}</x-table.td>
        </x-table.tr>
    </x-table.main>



    <!-- Heading - 2 -->
    <h2 class="mb-3 mt-4 text-xl font-semibold dark:text-white"></h2>

    @php
        $columns = [
            ['name' => 'room', 'label' => 'Enrollment Status', 'sortable' => false],
            ['name' => 'name', 'label' => 'Count of Enrollment Status', 'sortable' => false],
        ];
    @endphp

    <x-table.main :columns="$columns">
        <x-table.tr>
            <x-table.td>-</x-table.td>
            <x-table.td>{{ $data['enrollment_status_null'] }}</x-table.td>
        </x-table.tr>
        <x-table.tr>
            <x-table.td>Full-Time</x-table.td>
            <x-table.td>{{ $data['enrollment_status_full_time'] }}</x-table.td>
        </x-table.tr>
        <x-table.tr>
            <x-table.td>Part-Time</x-table.td>
            <x-table.td>{{ $data['enrollment_status_part_time'] }}</x-table.td>
        </x-table.tr>
        <x-table.tr>
            <x-table.td>Grand Total</x-table.td>
            <x-table.td>{{ $data['enrollment_status_grand_total'] }}</x-table.td>
        </x-table.tr>
    </x-table.main>
@endsection
