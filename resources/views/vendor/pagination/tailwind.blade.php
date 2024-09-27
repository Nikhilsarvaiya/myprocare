@php
    $linkClass = "px-3 py-2 leading-tight border border-gray-300 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400";
    $linkActiveClass = "px-3 py-2 leading-tight border border-gray-300 bg-gray-200 dark:bg-gray-600 dark:border-gray-700 dark:text-gray-400";
    $linkDisableClass = "cursor-default px-3 py-2 leading-tight border border-gray-300 text-gray-500 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-500 "
@endphp

@if ($paginator->hasPages())
    <nav class="flex justify-center">
        <ul class="lg:hidden flex space-x-2">
            @if ($paginator->onFirstPage())
                <li>
                    <a
                        href="#"
                        class="{{ $linkDisableClass }}"
                    >
                        {!! __('pagination.previous') !!}
                    </a>
                </li>
            @else
                <li>
                    <a
                        href="{{ $paginator->previousPageUrl() }}"
                        class="{{ $linkClass }}"
                    >
                        {!! __('pagination.previous') !!}
                    </a>
                </li>
            @endif

                {{-- Next Page Link --}}
                @if ($paginator->hasMorePages())
                    <li>
                        <a
                            href="{{ $paginator->nextPageUrl() }}"
                            class="{{ $linkClass }}"
                        >
                            {!! __('pagination.next') !!}
                        </a>
                    </li>
                @else
                    <li>
                        <a
                            href="#"
                            class="{{ $linkDisableClass }}"
                        >
                            {!! __('pagination.next') !!}
                        </a>
                    </li>
                @endif
        </ul>


        <ul class="hidden lg:inline-flex my-4 -space-x-px">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li>
                    <a
                        href="#"
                        class="{{ $linkDisableClass }}"
                    >
                        {!! __('pagination.previous') !!}
                    </a>
                </li>
            @else
                <li>
                    <a
                        href="{{ $paginator->previousPageUrl() }}"
                        class="{{ $linkClass }}"
                    >
                        {!! __('pagination.previous') !!}
                    </a>
                </li>
            @endif

            {{-- "Pagination Elements" ---}}
            @foreach($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li>
                        <a href="#" class="{{ $linkClass }}">{{ $element }}</a>
                    </li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li>
                                <a
                                    href="#"
                                    class="{{ $linkActiveClass }}"
                                >
                                    {{ $page }}
                                </a>
                            </li>
                        @else
                            <li>
                                <a
                                    href="{{ $url }}"
                                    class="{{ $linkClass }}"
                                    aria-label="{{ __('Go to page :page', ['page' => $page]) }}"
                                >
                                    {{ $page }}
                                </a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li>
                    <a
                        href="{{ $paginator->nextPageUrl() }}"
                        class="{{ $linkClass }}"
                    >
                        {!! __('pagination.next') !!}
                    </a>
                </li>
            @else
                <li>
                    <a
                        href="#"
                        class="{{ $linkDisableClass }}"
                    >
                        {!! __('pagination.next') !!}
                    </a>
                </li>
            @endif
        </ul>
    </nav>
@endif
