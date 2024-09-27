@props(['business','backUrl'])

<!-- Heading -->
<div class="mb-3 flex justify-between">
    <h1 class="text-xl font-semibold dark:text-white">Business Details</h1>

    <a href="{{ $backUrl }}">
        <x-secondary-button>
            <i class="fa-solid fa-arrow-left"></i>
        </x-secondary-button>
    </a>
</div>

<div class="rounded bg-white dark:bg-gray-800">
    <div class="h-52 w-full relative bg-gray-600">
        @if($business->getFirstMediaUrl('banner'))
            <img
                src="{{ $business->getFirstMediaUrl('banner') }}"
                class="w-full h-full object-cover rounded-md"
                alt="business-logo"
            >
        @else
            <div class="w-full h-full flex justify-center items-center rounded-md">
                <i class="fa-solid fa-image fa-2x text-gray-300"></i>
            </div>
        @endif

        <div class="h-20 w-20 absolute bottom-4 left-4">
            @if($business->getFirstMediaUrl('profile'))
                <img
                    src="{{ $business->getFirstMediaUrl('profile') }}"
                    class="w-full h-full object-cover rounded-md"
                    alt="business-logo"
                >
            @else
                <div class="w-full h-full flex justify-center items-center bg-gray-500 rounded-md">
                    <i class="fa-solid fa-image fa-2x text-gray-300"></i>
                </div>
            @endif

        </div>
    </div>

    <div class="p-2">
        <h1 class="dark:text-white font-semibold text-3xl">{{ $business->name }}</h1>
        <p class="dark:text-gray-300 mt-1">
            <i class="fa-solid fa-fw fa-store w-4 h-4"></i>
            <span class="ms-1">{{ $business->businessType->name }}</span>
        </p>
        <p class="dark:text-gray-300 mt-1">
            <i class="fa-solid fa-fw fa-location-dot w-4 h-4"></i>
            <span class="ms-1">{{ $business->address }}</span>
            <a href="https://www.google.com/maps/dir/?api=1&destination={{ $business->latitude }},{{ $business->longitude }}">
                <i class="fa-solid fa-diamond-turn-right ms-1"></i>
            </a>
        </p>
        <p class="dark:text-gray-300 mt-1">
            <i class="fa-solid fa-fw fa-phone w-4 h-4"></i>
            <span class="ms-1">{{ $business->phone }}</span>
        </p>
        <p class="dark:text-gray-300 mt-1">{{ $business->about }}</p>
    </div>
</div>

<div class="mt-2 p-2 rounded bg-white dark:bg-gray-800">
    <h1 class="dark:text-gray-300 font-semibold text-2xl">Opening Hours</h1>

    <div class="mt-2">
        @forelse($business->openingHours as $openingHour)
            <p class="dark:text-gray-300">
                {{ \Illuminate\Support\Carbon::getDays()[$openingHour->day] }}:
                @if($openingHour->start_time && $openingHour->end_time)
                    {{ $openingHour->start_time->format('h:i A') }} - {{ $openingHour->end_time->format('h:i A') }}
                @else
                    closed
                @endif
            </p>
        @empty
            <p class="dark:text-gray-300">Not set opening hours by business.</p>
        @endforelse
    </div>
</div>

@if($business->businessType->sell_food_beverage)
    <div class="mt-2 p-2 rounded bg-white dark:bg-gray-800">
        <h3 class="dark:text-gray-300">
            <span class="font-semibold">Restaurant Type: </span>
            {{ $business->restaurantType?->name ?? 'Not set by business' }}
        </h3>
        <h3 class="dark:text-gray-300">
            <span class="font-semibold">Food Type: </span>
            {{ $business->foodType?->name ?? 'Not set by business' }}
        </h3>
    </div>
@endif

@if($business->businessType->sell_food_beverage)
    <div class="mt-2 p-2 rounded bg-white dark:bg-gray-800">
        <h1 class="dark:text-gray-300 font-semibold text-2xl">Menu</h1>

        <div class="mt-2">
            @forelse($business->menus as $menu)
                <div class="flex justify-between dark:text-gray-300 bg-gray-300 dark:bg-gray-700 my-1 p-1 rounded">
                    <p>{{ $menu->name }}</p>
                    <p>${{ $menu->price }}</p>
                </div>
            @empty
                <p class="dark:text-gray-300">Not added any item in menu by business.</p>
            @endforelse
        </div>
    </div>
@endif

@if(!$business->businessType->sell_food_beverage)
    <div class="mt-2 p-2 rounded bg-white dark:bg-gray-800">
        <h1 class="dark:text-gray-300 font-semibold text-2xl">Products</h1>

        <div class="mt-2">
            @forelse($business->products as $product)
                <div class="flex justify-between dark:text-gray-300 bg-gray-700 my-1 p-1 rounded">
                    <p>{{ $product->name }}</p>
                    <p>${{ $product->price }}</p>
                </div>
            @empty
                <p class="dark:text-gray-300">Not added any product by business.</p>
            @endforelse
        </div>
    </div>
@endif

<div class="mt-2 p-2 rounded bg-white dark:bg-gray-800">
    <h1 class="dark:text-gray-300 font-semibold text-2xl">Online presence at</h1>

    <div class="mt-2">
        <div class="flex space-x-2">
            <a href="{{ $business->website_link }}">
                <i class="fa-solid fa-fw fa-earth-america text-gray-900 dark:text-gray-300 hover:-translate-y-1"></i>
            </a>
            <a href="{{ $business->facebook_link }}">
                <i class="fa-brands fa-fw fa-facebook text-gray-900 dark:text-gray-300 hover:-translate-y-1"></i>
            </a>
            <a href="{{ $business->instagram_link }}">
                <i class="fa-brands fa-fw fa-instagram text-gray-900 dark:text-gray-300 hover:-translate-y-1"></i>
            </a>
            <a href="{{ $business->twitter_link }}">
                <i class="fa-brands fa-fw fa-twitter text-gray-900 dark:text-gray-300 hover:-translate-y-1"></i>
            </a>
            <a href="{{ $business->youtube_link }}">
                <i class="fa-brands fa-fw fa-youtube text-gray-900 dark:text-gray-300 hover:-translate-y-1"></i>
            </a>
            <a href="{{ $business->tiktok_link }}">
                <i class="fa-brands fa-fw fa-tiktok text-gray-900 dark:text-gray-300 hover:-translate-y-1"></i>
            </a>
            <a href="{{ $business->tiktok_link }}">
                <i class="fa-brands fa-fw fa-uber text-gray-900 dark:text-gray-300 hover:-translate-y-1"></i>
            </a>
        </div>
    </div>
</div>

<div class="pt-2"></div>
