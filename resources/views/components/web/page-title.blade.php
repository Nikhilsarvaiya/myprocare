@props(['title'])

<h1 class="mb-3 text-xl font-semibold dark:text-white">{{ $title ?? $slot }}</h1>
