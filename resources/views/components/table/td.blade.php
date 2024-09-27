@props(['value','th'])

@php
    $classes = ($th ?? false)
                ? 'px-6 py-4 whitespace-nowrap font-medium text-gray-900 dark:text-white'
                : 'px-6 py-4';
@endphp

<td {{ $attributes->merge(['class' => $classes]) }}>
    {{ $value ?? $slot }}
</td>
