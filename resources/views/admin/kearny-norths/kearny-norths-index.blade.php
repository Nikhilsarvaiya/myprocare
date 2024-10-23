@extends('layouts.app')

@section('main')
    <!-- Heading -->
    <h1 class="mb-3 text-xl font-semibold dark:text-white">Kearny North</h1>

    @php
        $columns = [
            ['name' => 'id', 'label' => 'Q2 QTD', 'sortable' => false],
            ['name' => 'name', 'label' => 'Kearny North', 'sortable' => false],
        ];
    @endphp

    <x-table.main :columns="$columns">
        <x-table.tr>
            <x-table.td>Active Student</x-table.td>
            <x-table.td>{{ $data['active_student'] }}</x-table.td>
        </x-table.tr>
        <x-table.tr>
            <x-table.td>Unactive Students</x-table.td>
            <x-table.td>{{ $data['inactive_student'] }}</x-table.td>
        </x-table.tr>
        <x-table.tr>
            <x-table.td>Total Students</x-table.td>
            <x-table.td>{{ $data['total_student'] }}</x-table.td>
        </x-table.tr>
        <x-table.tr>
            <x-table.td>Retention Rate</x-table.td>
            <x-table.td>{{ round($data['retention_rate'], 2) }} %</x-table.td>
        </x-table.tr>
        <x-table.tr>
            <x-table.td>Center Capacity</x-table.td>
            <x-table.td>{{ $data['center_capacity'] }}</x-table.td>
        </x-table.tr>
        <x-table.tr>
            <x-table.td>Percent to Capacity</x-table.td>
            <x-table.td>{{ round($data['percent_capacity'], 2) }} %</x-table.td>
        </x-table.tr>
        <x-table.tr>
            <x-table.td>Goal</x-table.td>
            <x-table.td>{{ round($data['goal'], 2) }} %</x-table.td>
        </x-table.tr>
        <x-table.tr>
            <x-table.td>Total Score</x-table.td>
            <x-table.td>{{ round($data['total_score'], 2) }}%</x-table.td>
        </x-table.tr>
    </x-table.main>
@endsection
