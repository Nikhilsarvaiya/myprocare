@props(['value'])

<tr {{ $attributes->merge(['class' => 'border-b bg-white dark:border-gray-700 dark:bg-gray-800']) }}>
    {{ $value ?? $slot }}
</tr>
