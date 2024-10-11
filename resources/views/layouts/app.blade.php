<!DOCTYPE html>
<html
    lang="{{ str_replace('_', '-', app()->getLocale()) }}"
    x-data="{ darkMode: localStorage.getItem('dark') === 'true'} "
    x-init="$watch('darkMode', val => localStorage.setItem('dark', val))"
    x-bind:class="{ 'dark': darkMode }"
>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Style -->
    @stack('css')

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">
<div class="antialiased bg-gray-50 dark:bg-gray-900">
    <!-- Navbar -->
    <nav
        class="bg-white border-b border-gray-200 px-2 py-2.5 dark:bg-gray-800 dark:border-gray-700 fixed left-0 right-0 top-0 z-50"
    >
        <div class="flex flex-wrap justify-between items-center">
            <div class="flex justify-start items-center">
                <button
                    class="p-2 mr-2 text-gray-600 rounded-lg cursor-pointer md:hidden hover:text-gray-900 hover:bg-gray-100 focus:bg-gray-100 dark:focus:bg-gray-700 focus:ring-2 focus:ring-gray-100 dark:focus:ring-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"
                    onclick="document.getElementById('drawer-navigation').classList.toggle('-translate-x-full');"
                >
                    <svg
                        aria-hidden="true"
                        class="w-6 h-6"
                        fill="currentColor"
                        viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg"
                    >
                        <path
                            fill-rule="evenodd"
                            d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h6a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                            clip-rule="evenodd"
                        ></path>
                    </svg>
                    <svg
                        aria-hidden="true"
                        class="hidden w-6 h-6"
                        fill="currentColor"
                        viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg"
                    >
                        <path
                            fill-rule="evenodd"
                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                            clip-rule="evenodd"
                        ></path>
                    </svg>
                </button>
                <a href="{{ route('welcome') }}" class="flex items-center justify-between">
                    {{-- <x-application-logo class="mr-3 w-10 h-10 fill-current text-gray-500"/> --}}
                    <span class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white">
                        My Procare
                    </span>
                </a>
            </div>
            <div class="flex items-center lg:order-2 space-x-4">
                <x-toogle-theme/>

                @if(!\Illuminate\Support\Facades\Auth::check())
                    <a href="{{ route('login') }}">
                        <x-secondary-button>
                            Login
                        </x-secondary-button>
                    </a>
                @endif

                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button
                            type="button"
                            class="flex text-sm bg-gray-800 rounded-full md:mr-0 focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-500"
                            id="user-menu-button"
                            aria-expanded="false"
                            data-dropdown-toggle="dropdown"
                        >
                            <span class="sr-only">Open user menu</span>
                            <x-user-avatar :name="\Illuminate\Support\Facades\Auth::user()->name" class="!h-8 !w-8"/>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <!-- Dropdown menu -->
                        <div
                            class="z-50 text-base list-none bg-white rounded divide-y divide-gray-100 dark:bg-gray-700 dark:divide-gray-600 rounded-xl text-gray-900 dark:text-gray-300"
                            id="dropdown"
                        >
                            <div class="py-3 px-4">
                                <span class="block text-sm font-semibold">
                                    {{ \Illuminate\Support\Facades\Auth::user()->name }}
                                </span>
                                <span class="block text-sm truncate">
                                    {{ \Illuminate\Support\Facades\Auth::user()->email }}
                                </span>
                            </div>
                            <ul
                                class="py-1"
                                aria-labelledby="dropdown"
                            >
                                <li>
                                    <a
                                        href="{{ route('profile.edit') }}"
                                        class="block py-2 px-4 text-sm hover:bg-gray-100 dark:hover:bg-gray-600"
                                    >
                                        My profile
                                    </a>
                                </li>
                            </ul>
                            <ul
                                class="pt-1"
                                aria-labelledby="dropdown"
                            >
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button
                                            class="w-full block py-2 px-4 text-sm text-left hover:bg-gray-100 dark:hover:bg-gray-600"
                                            onclick="event.preventDefault(); this.closest('form').submit();"
                                        >
                                            {{ __('Log Out') }}
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </x-slot>
                </x-dropdown>
            </div>
        </div>
    </nav>

    <!-- Sidebar -->
    <aside
        id="drawer-navigation"
        class="-translate-x-full fixed top-0 left-0 z-40 w-64 h-screen pt-14 transition-transform bg-white border-r border-gray-200 md:translate-x-0 dark:bg-gray-800 dark:border-gray-700"
        aria-label="Sidenav"
    >
        <div class="overflow-y-auto py-5 px-3 h-full bg-white dark:bg-gray-800">
            <ul class="space-y-2">
                @if(auth()->user()->hasRole('admin'))
                    <x-web.sidebar-menu
                        :label="'Dashboard'"
                        :href="route('admin.dashboard')"
                        :active="request()->routeIs('admin.dashboard')"
                    >
                        <svg
                            aria-hidden="true"
                            class="w-6 h-6"
                            fill="currentColor"
                            viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg"
                        >
                            <path d="M2 10a8 8 0 018-8v8h8a8 8 0 11-16 0z"></path>
                            <path d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z"></path>
                        </svg>
                    </x-web.sidebar-menu>
                    <x-web.sidebar-menu
                        :label="'Users'"
                        :href="route('admin.users.index')"
                        :active="request()->routeIs('admin.users.index')"
                    >
                        <i class="fa-solid fa-user fa-lg ms-1"></i>
                    </x-web.sidebar-menu>

                    <x-web.sidebar-menu
                        :label="'Students'"
                        :href="route('admin.students.index')"
                        :active="request()->routeIs('admin.students.index')"
                    >
                        <i class="fa-solid fa-user fa-lg ms-1"></i>
                    </x-web.sidebar-menu>

                    {{-- <x-web.sidebar-menu
                        :label="'Events'"
                        :href="route('admin.events.index')"
                        :active="request()->routeIs('admin.events.index')"
                    >
                        <i class="fa-regular fa-calendar fa-lg ms-1"></i>
                    </x-web.sidebar-menu>

                     <x-web.sidebar-menu
                        :label="'Deals'"
                        :href="route('admin.deals.index')"
                        :active="request()->routeIs('admin.deals.index')"
                    >
                        <i class="fa-solid fa-sack-dollar fa-lg ms-1"></i>
                    </x-web.sidebar-menu>

                    <x-web.sidebar-menu
                        :label="'Business Types'"
                        :href="route('admin.business-types.index')"
                        :active="request()->routeIs('admin.business-types.index')"
                    >
                        <i class="fa-solid fa-briefcase fa-lg ms-1"></i>
                    </x-web.sidebar-menu>

                    <x-web.sidebar-menu
                        :label="'Food Types'"
                        :href="route('admin.food-types.index')"
                        :active="request()->routeIs('admin.food-types.index')"
                    >
                        <i class="fa-solid fa-pizza-slice fa-lg ms-1"></i>
                    </x-web.sidebar-menu>

                    <x-web.sidebar-menu
                        :label="'Restaurant Types'"
                        :href="route('admin.restaurant-types.index')"
                        :active="request()->routeIs('admin.restaurant-types.index')"
                    >
                        <i class="fa-solid fa-utensils fa-lg ms-1"></i>
                    </x-web.sidebar-menu>

                    <x-web.sidebar-menu
                        :label="'Businesses'"
                        :href="route('admin.businesses.index')"
                        :active="request()->routeIs('admin.businesses.index')"
                    >
                        <svg
                            class="w-6 h-6"
                            fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"
                            aria-hidden="true">
                            <path
                                d="M5.223 2.25c-.497 0-.974.198-1.325.55l-1.3 1.298A3.75 3.75 0 007.5 9.75c.627.47 1.406.75 2.25.75.844 0 1.624-.28 2.25-.75.626.47 1.406.75 2.25.75.844 0 1.623-.28 2.25-.75a3.75 3.75 0 004.902-5.652l-1.3-1.299a1.875 1.875 0 00-1.325-.549H5.223z"></path>
                            <path clip-rule="evenodd" fill-rule="evenodd"
                                  d="M3 20.25v-8.755c1.42.674 3.08.673 4.5 0A5.234 5.234 0 009.75 12c.804 0 1.568-.182 2.25-.506a5.234 5.234 0 002.25.506c.804 0 1.567-.182 2.25-.506 1.42.674 3.08.675 4.5.001v8.755h.75a.75.75 0 010 1.5H2.25a.75.75 0 010-1.5H3zm3-6a.75.75 0 01.75-.75h3a.75.75 0 01.75.75v3a.75.75 0 01-.75.75h-3a.75.75 0 01-.75-.75v-3zm8.25-.75a.75.75 0 00-.75.75v5.25c0 .414.336.75.75.75h3a.75.75 0 00.75-.75v-5.25a.75.75 0 00-.75-.75h-3z"></path>
                        </svg>
                    </x-web.sidebar-menu>

                    <x-web.sidebar-menu
                        :label="'Advertisements'"
                        :href="route('admin.advertisements.index')"
                        :active="request()->routeIs('admin.advertisements.index')"
                    >
                        <i class="fa-solid fa-rectangle-ad fa-lg"></i>
                    </x-web.sidebar-menu>

                    <x-web.sidebar-menu
                        :label="'Road Closures'"
                        :href="route('admin.road-closures.index')"
                        :active="request()->routeIs('admin.road-closures.index')"
                    >
                        <i class="fa-solid fa-road-circle-exclamation fa-lg"></i>
                    </x-web.sidebar-menu>

                    @php
                        $dropdownItems = [
                            (object)["label" => "Wallet", "href" => route('admin.settings.wallet.edit'), "active" => request()->routeIs('admin.settings.wallet.edit')],
                        ];
                    @endphp

                    <x-web.sidebar-menu
                        :label="'Settings'"
                        :dropdown-items="$dropdownItems"
                    >
                        <i class="fa-solid fa-gear fa-lg"></i>
                    </x-web.sidebar-menu> --}}
                @else
                    <x-web.sidebar-menu
                        :label="'Dashboard'"
                        :href="route('user.dashboard')"
                        :active="request()->routeIs('user.dashboard')"
                    >
                        <svg
                            aria-hidden="true"
                            class="w-6 h-6"
                            fill="currentColor"
                            viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg"
                        >
                            <path d="M2 10a8 8 0 018-8v8h8a8 8 0 11-16 0z"></path>
                            <path d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z"></path>
                        </svg>
                    </x-web.sidebar-menu>

                    {{-- <x-web.sidebar-menu
                        :label="'Events'"
                        :href="route('user.events.index')"
                        :active="request()->routeIs('user.events.index')"
                    >
                        <i class="fa-regular fa-calendar fa-lg ms-1"></i>
                    </x-web.sidebar-menu>

                    <x-web.sidebar-menu
                        :label="'Deals'"
                        :href="route('user.deals.index')"
                        :active="request()->routeIs('user.deals.index')"
                    >
                        <i class="fa-solid fa-sack-dollar fa-lg ms-1"></i>
                    </x-web.sidebar-menu>

                    <x-web.sidebar-menu
                        :label="'Businesses'"
                        :href="route('user.businesses.index')"
                        :active="request()->routeIs('user.businesses.index')"
                    >
                        <svg
                            class="w-6 h-6"
                            fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"
                            aria-hidden="true">
                            <path
                                d="M5.223 2.25c-.497 0-.974.198-1.325.55l-1.3 1.298A3.75 3.75 0 007.5 9.75c.627.47 1.406.75 2.25.75.844 0 1.624-.28 2.25-.75.626.47 1.406.75 2.25.75.844 0 1.623-.28 2.25-.75a3.75 3.75 0 004.902-5.652l-1.3-1.299a1.875 1.875 0 00-1.325-.549H5.223z"></path>
                            <path clip-rule="evenodd" fill-rule="evenodd"
                                  d="M3 20.25v-8.755c1.42.674 3.08.673 4.5 0A5.234 5.234 0 009.75 12c.804 0 1.568-.182 2.25-.506a5.234 5.234 0 002.25.506c.804 0 1.567-.182 2.25-.506 1.42.674 3.08.675 4.5.001v8.755h.75a.75.75 0 010 1.5H2.25a.75.75 0 010-1.5H3zm3-6a.75.75 0 01.75-.75h3a.75.75 0 01.75.75v3a.75.75 0 01-.75.75h-3a.75.75 0 01-.75-.75v-3zm8.25-.75a.75.75 0 00-.75.75v5.25c0 .414.336.75.75.75h3a.75.75 0 00.75-.75v-5.25a.75.75 0 00-.75-.75h-3z"></path>
                        </svg>
                    </x-web.sidebar-menu>

                    <x-web.sidebar-menu
                        :label="'Business Offers'"
                        :href="route('user.business-offers.index')"
                        :active="request()->routeIs('user.business-offers.index')"
                    >
                        <i class="fa-solid fa-sack-dollar fa-lg ms-1"></i>
                    </x-web.sidebar-menu>

                    <x-web.sidebar-menu
                        :label="'Business Transaction'"
                        :href="route('user.businesses.wallet-transactions.index')"
                        :active="request()->routeIs('user.businesses.wallet-transactions.index')"
                    >
                        <i class="fa-solid fa-sack-dollar fa-lg ms-1"></i>
                    </x-web.sidebar-menu>

                    <x-web.sidebar-menu
                        :label="'Road Closures'"
                        :href="route('user.road-closures.index')"
                        :active="request()->routeIs('user.road-closures.index')"
                    >
                        <i class="fa-solid fa-road-circle-exclamation fa-lg"></i>
                    </x-web.sidebar-menu> --}}
                @endif
            </ul>
        </div>
    </aside>

    <main class="px-2 md:px-4 md:ml-64 pt-20 h-full min-h-screen">
        @yield('main')
    </main>
</div>
@stack('script')
</body>
</html>
