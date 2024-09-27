@props(['name'])

<div {!! $attributes->merge(['class' => 'relative inline-flex items-center justify-center h-12 w-12 overflow-hidden bg-gray-100 rounded-full dark:bg-gray-600']) !!}>
    <span class="font-semibold uppercase text-gray-600 dark:text-gray-300">{{ \Illuminate\Support\Str::charAt($name, 0) }}</span>
</div>
