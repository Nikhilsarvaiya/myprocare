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
                <!-- Toggle sidebar -->
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

                <a href="/" class="flex items-center justify-between">
                    <x-application-logo class="mr-3 w-10 h-10 fill-current text-gray-500"/>
                    <span class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white">
                        My Procare
                    </span>
                </a>
            </div>
            <div class="flex items-center lg:order-2 space-x-4">
                <div class="hidden md:block">
                    <div class="flex items-baseline space-x-4">
                        @php
                            $navigations = [
                                [ 'title' => 'Home', 'url' => route('welcome'), 'active' => request()->routeIs('welcome')],
                                [ 'title' => 'Blog', 'url' => '#', 'active' => false],
                                [ 'title' => 'About', 'url' => '#', 'active' => false],
                                [ 'title' => 'Contact', 'url' => '#', 'active' => false],
                             ];
                        @endphp
                        @foreach($navigations as $navigation)
                            <a href="{{ $navigation['url'] }}"
                               class="hover:text-blue-700 dark:hover:text-white {{ $navigation['active'] ? 'text-blue-700 dark:text-white' : 'text-gray-700 dark:text-gray-400' }}">
                                {{ $navigation['title'] }}
                            </a>
                        @endforeach
                    </div>
                </div>

                <x-toogle-theme/>

                @if(!\Illuminate\Support\Facades\Auth::check())
                    <a href="{{ route('login') }}">
                        <x-secondary-button>
                            Login
                        </x-secondary-button>
                    </a>
                @endif

                @if(\Illuminate\Support\Facades\Auth::check())
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button
                                type="button"
                                class="flex text-sm bg-gray-800 rounded-full md:mr-0 focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600"
                                id="user-menu-button"
                                aria-expanded="false"
                                data-dropdown-toggle="dropdown"
                            >
                                <span class="sr-only">Open user menu</span>
                                <x-user-avatar :name="\Illuminate\Support\Facades\Auth::user()->name"
                                               class="!h-8 !w-8"/>
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
                                            href="{{ route('user.dashboard') }}"
                                            class="block py-2 px-4 text-sm hover:bg-gray-100 dark:hover:bg-gray-600"
                                        >Dashboard
                                        </a>
                                    </li>
                                    @if(\Illuminate\Support\Facades\Auth::user()->hasRole('admin'))
                                        <li>
                                            <a
                                                href="{{ route('admin.dashboard') }}"
                                                class="block py-2 px-4 text-sm hover:bg-gray-100 dark:hover:bg-gray-600"
                                            >Admin Dashboard
                                            </a>
                                        </li>
                                    @endif
                                    <li>
                                        <a
                                            href="#"
                                            class="block py-2 px-4 text-sm hover:bg-gray-100 dark:hover:bg-gray-600"
                                        >My profile</a>
                                    </li>
                                    <li>
                                        <a
                                            href="#"
                                            class="block py-2 px-4 text-sm hover:bg-gray-100 dark:hover:bg-gray-600"
                                        >Account settings</a>
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
                @endif
            </div>
        </div>
    </nav>

    <!-- Sidebar -->
    <aside
        id="drawer-navigation"
        class="-translate-x-full fixed top-0 left-0 z-40 w-64 h-screen pt-14 transition-transform bg-white border-r border-gray-200 dark:bg-gray-800 dark:border-gray-700"
        aria-label="Sidenav"
    >
        <div class="overflow-y-auto py-5 px-3 h-full bg-white dark:bg-gray-800">
            <ul class="space-y-2">
                <x-web.sidebar-menu :label="'Home'" :href="'#'" active="false">
                    <i class="fa-solid fa-house fa-lg"></i>
                </x-web.sidebar-menu>
                <x-web.sidebar-menu :label="'Contact'" :href="'#'" :active="false">
                    <i class="fa-solid fa-contact-card fa-lg"></i>
                </x-web.sidebar-menu>
                <x-web.sidebar-menu :label="'About'" :href="'#'" :active="false">
                    <i class="fa-solid fa-user fa-lg ms-1"></i>
                </x-web.sidebar-menu>
            </ul>
        </div>
    </aside>

    <main class="pt-20 pb-2 h-full min-h-screen">
        @yield('main')
    </main>
</div>
@stack('script')
</body>
</html>
