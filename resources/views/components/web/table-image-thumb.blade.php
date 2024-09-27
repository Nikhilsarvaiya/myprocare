@props(['media'])

<div>
    @if(count($media) > 0 && $media[0]->getUrl())
        <img
            src="{{ $media[0]->getUrl() }}"
            class="!max-w-none h-20 w-20 object-fit"
            alt="business-logo"
        >
    @else
        <div class="h-20 w-20 flex justify-center items-center bg-gray-500 rounded-md">
            <i class="fa-solid fa-image fa-2x text-gray-300"></i>
        </div>
    @endif
</div>
