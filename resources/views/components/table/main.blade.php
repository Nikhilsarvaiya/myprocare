@props(['columns'])

<div class="relative overflow-x-auto shadow-md rounded-lg">
    <table class="w-full text-left text-sm text-gray-500 dark:text-gray-400">
        <thead class="bg-gray-100 text-xs uppercase text-gray-700 dark:bg-gray-700 dark:text-gray-400">
        <tr>
            @foreach($columns as $column)
                <th scope="col" class="px-6 py-3">
                    @if($column['sortable'])
                        <button onclick="MyApp.sortData('{{ $column['name'] }}')" class="flex items-center uppercase">
                            {{ $column['label'] }}
                            <div class="relative flex items-center ms-1">
                                <i class="fa-solid fa-sort-up absolute {{ request('orderKey') === $column['name'] && request('orderDirection') === 'asc' ? 'text-sky-400/100' : '' }}"></i>
                                <i class="fa-solid fa-sort-down absolute {{ request('orderKey') === $column['name'] && request('orderDirection') === 'desc' ? 'text-sky-400/100' : '' }}"></i>
                            </div>
                        </button>
                    @else
                        {{ $column['label'] }}
                    @endif
                </th>
            @endforeach
        </tr>
        </thead>
        <tbody>
        {{ $slot }}
        </tbody>
    </table>
</div>
