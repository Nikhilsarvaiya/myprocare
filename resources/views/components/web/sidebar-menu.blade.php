@props([
    'href',
    'active',
    'label',
    'dropdownItems' => null
])

@if($dropdownItems)
    @php
        $active = collect($dropdownItems)->contains('active', true);
    @endphp
    <li x-data="{show: {{ json_encode($active) }} }">
        <button
            type="button"
            class="flex items-center p-2 w-full rounded-lg text-base font-medium text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 group"
            @click="show = !show"
        >
            <span
                class="transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"
            >
                {{ $slot }}
            </span>
            <span
                class="flex-1 ml-3 text-left group-hover:text-gray-900 dark:group-hover:text-white"
            >
                {{ $label }}
            </span>
            <i class="fa-solid fa-angle-down fa-lg"></i>
        </button>
        <ul x-show="show" id="dropdown-pages" class="py-2 space-y-2">
            @foreach($dropdownItems as $dropdownItem)
                <li>
                    <a
                        href="{{ $dropdownItem->href }}"
                        class="flex items-center p-2 pl-11 rounded-lg text-base font-medium text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 group {{ $dropdownItem->active ? 'bg-gray-100 dark:bg-gray-700' : '' }}"
                    >
                        <span
                            class="group-hover:text-gray-900 dark:group-hover:text-white"
                        >
                            {{ $dropdownItem->label }}
                        </span>
                    </a>
                </li>
            @endforeach
        </ul>
    </li>
@else
    <li>
        <a
            href="{{ $href }}"
            class="flex items-center p-2 rounded-lg text-base font-medium text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 group {{ $active ? 'bg-gray-100 dark:bg-gray-700' : '' }}"
        >
            <span
                class="transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"
            >
                {{ $slot }}
            </span>
            <span
                class="ml-3 group-hover:text-gray-900 dark:group-hover:text-white"
            >
                {{ $label }}
            </span>
        </a>
    </li>
@endif
