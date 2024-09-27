@extends('layouts.app')

@section('main')
    <!-- Heading -->
    <h1 class="mb-3 text-xl font-semibold dark:text-white">Businesses</h1>

    <div class="lg:flex lg:justify-between items-center">
        <!-- Search Bar -->
        <x-web.table-search-bar :url="route('user.businesses.index')"/>

        <div class="mb-3 flex items-center space-x-3">
            <a href="{{ route('user.businesses.index') }}">
                <x-secondary-button>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                         stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99"/>
                    </svg>
                </x-secondary-button>
            </a>
            <a href="{{ route('user.businesses.basic_details.create') }}">
                <x-secondary-button>
                    Add
                </x-secondary-button>
            </a>
        </div>
    </div>

    <!-- Data Table -->
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-left text-sm text-gray-500 dark:text-gray-400">
            <thead class="bg-gray-100 text-xs uppercase text-gray-700 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">
                    <button onclick="MyApp.sortData('id')" class="flex items-center">
                        Id
                        <svg xmlns="http://www.w3.org/2000/svg" class="ml-1 h-3 w-3" aria-hidden="true"
                             fill="currentColor" viewBox="0 0 320 512">
                            <path
                                d="M27.66 224h264.7c24.6 0 36.89-29.78 19.54-47.12l-132.3-136.8c-5.406-5.406-12.47-8.107-19.53-8.107c-7.055 0-14.09 2.701-19.45 8.107L8.119 176.9C-9.229 194.2 3.055 224 27.66 224zM292.3 288H27.66c-24.6 0-36.89 29.77-19.54 47.12l132.5 136.8C145.9 477.3 152.1 480 160 480c7.053 0 14.12-2.703 19.53-8.109l132.3-136.8C329.2 317.8 316.9 288 292.3 288z"/>
                        </svg>
                    </button>
                </th>
                <th scope="col" class="px-6 py-3">
                    <button class="flex items-center">
                        Profile
                    </button>
                </th>
                <th scope="col" class="px-6 py-3">
                    <button onclick="MyApp.sortData('name')" class="flex items-center">
                        Name
                        <svg xmlns="http://www.w3.org/2000/svg" class="ml-1 h-3 w-3" aria-hidden="true"
                             fill="currentColor" viewBox="0 0 320 512">
                            <path
                                d="M27.66 224h264.7c24.6 0 36.89-29.78 19.54-47.12l-132.3-136.8c-5.406-5.406-12.47-8.107-19.53-8.107c-7.055 0-14.09 2.701-19.45 8.107L8.119 176.9C-9.229 194.2 3.055 224 27.66 224zM292.3 288H27.66c-24.6 0-36.89 29.77-19.54 47.12l132.5 136.8C145.9 477.3 152.1 480 160 480c7.053 0 14.12-2.703 19.53-8.109l132.3-136.8C329.2 317.8 316.9 288 292.3 288z"/>
                        </svg>
                    </button>
                </th>
                <th scope="col" class="px-6 py-3">
                    <button onclick="MyApp.sortData('about')" class="flex items-center">
                        About
                        <svg xmlns="http://www.w3.org/2000/svg" class="ml-1 h-3 w-3" aria-hidden="true"
                             fill="currentColor" viewBox="0 0 320 512">
                            <path
                                d="M27.66 224h264.7c24.6 0 36.89-29.78 19.54-47.12l-132.3-136.8c-5.406-5.406-12.47-8.107-19.53-8.107c-7.055 0-14.09 2.701-19.45 8.107L8.119 176.9C-9.229 194.2 3.055 224 27.66 224zM292.3 288H27.66c-24.6 0-36.89 29.77-19.54 47.12l132.5 136.8C145.9 477.3 152.1 480 160 480c7.053 0 14.12-2.703 19.53-8.109l132.3-136.8C329.2 317.8 316.9 288 292.3 288z"/>
                        </svg>
                    </button>
                </th>
                <th scope="col" class="px-6 py-3">
                    <button onclick="MyApp.sortData('sell_food_beverage')" class="flex items-center">
                        Sell Food & Beverages
                        <svg xmlns="http://www.w3.org/2000/svg" class="ml-1 h-3 w-3" aria-hidden="true"
                             fill="currentColor" viewBox="0 0 320 512">
                            <path
                                d="M27.66 224h264.7c24.6 0 36.89-29.78 19.54-47.12l-132.3-136.8c-5.406-5.406-12.47-8.107-19.53-8.107c-7.055 0-14.09 2.701-19.45 8.107L8.119 176.9C-9.229 194.2 3.055 224 27.66 224zM292.3 288H27.66c-24.6 0-36.89 29.77-19.54 47.12l132.5 136.8C145.9 477.3 152.1 480 160 480c7.053 0 14.12-2.703 19.53-8.109l132.3-136.8C329.2 317.8 316.9 288 292.3 288z"/>
                        </svg>
                    </button>
                </th>
                <th scope="col" class="px-6 py-3">
                    <button onclick="MyApp.sortData('step_completed')" class="flex items-center">
                        Steps
                        <svg xmlns="http://www.w3.org/2000/svg" class="ml-1 h-3 w-3" aria-hidden="true"
                             fill="currentColor" viewBox="0 0 320 512">
                            <path
                                d="M27.66 224h264.7c24.6 0 36.89-29.78 19.54-47.12l-132.3-136.8c-5.406-5.406-12.47-8.107-19.53-8.107c-7.055 0-14.09 2.701-19.45 8.107L8.119 176.9C-9.229 194.2 3.055 224 27.66 224zM292.3 288H27.66c-24.6 0-36.89 29.77-19.54 47.12l132.5 136.8C145.9 477.3 152.1 480 160 480c7.053 0 14.12-2.703 19.53-8.109l132.3-136.8C329.2 317.8 316.9 288 292.3 288z"/>
                        </svg>
                    </button>
                </th>
                <th scope="col" class="px-6 py-3">
                    <button onclick="MyApp.sortData('created_at')" class="flex items-center">
                        Created At
                        <svg xmlns="http://www.w3.org/2000/svg" class="ml-1 h-3 w-3" aria-hidden="true"
                             fill="currentColor" viewBox="0 0 320 512">
                            <path
                                d="M27.66 224h264.7c24.6 0 36.89-29.78 19.54-47.12l-132.3-136.8c-5.406-5.406-12.47-8.107-19.53-8.107c-7.055 0-14.09 2.701-19.45 8.107L8.119 176.9C-9.229 194.2 3.055 224 27.66 224zM292.3 288H27.66c-24.6 0-36.89 29.77-19.54 47.12l132.5 136.8C145.9 477.3 152.1 480 160 480c7.053 0 14.12-2.703 19.53-8.109l132.3-136.8C329.2 317.8 316.9 288 292.3 288z"/>
                        </svg>
                    </button>
                </th>
                <th scope="col" class="px-6 py-3">
                    <button onclick="MyApp.sortData('updated_at')" class="flex items-center">
                        Updated At
                        <svg xmlns="http://www.w3.org/2000/svg" class="ml-1 h-3 w-3" aria-hidden="true"
                             fill="currentColor" viewBox="0 0 320 512">
                            <path
                                d="M27.66 224h264.7c24.6 0 36.89-29.78 19.54-47.12l-132.3-136.8c-5.406-5.406-12.47-8.107-19.53-8.107c-7.055 0-14.09 2.701-19.45 8.107L8.119 176.9C-9.229 194.2 3.055 224 27.66 224zM292.3 288H27.66c-24.6 0-36.89 29.77-19.54 47.12l132.5 136.8C145.9 477.3 152.1 480 160 480c7.053 0 14.12-2.703 19.53-8.109l132.3-136.8C329.2 317.8 316.9 288 292.3 288z"/>
                        </svg>
                    </button>
                </th>
                <th scope="col" class="px-6 py-3">
                    <span>Action</span>
                </th>
            </tr>
            </thead>
            <tbody>
            @forelse($businesses as $business)
                <tr class="border-b bg-white dark:border-gray-700 dark:bg-gray-800">
                    <th scope="row" class="whitespace-nowrap px-6 py-4 font-medium text-gray-900 dark:text-white">
                        {{ $business->id }}
                    </th>
                    <td class="px-6 py-4">
                        @if(count($business->media) > 0 && $business->getFirstMediaUrl('profile'))
                            <img
                                src="{{ $business->getFirstMediaUrl('profile') }}"
                                class="!max-w-none h-20 w-20 object-fit"
                                alt="business-logo"
                            >
                        @else
                            <div class="h-20 w-20 flex justify-center items-center bg-gray-500 rounded-md">
                                <i class="fa-solid fa-image fa-2x text-gray-300"></i>
                            </div>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        {{ $business->name }}
                    </td>
                    <td class="px-6 py-4">
                        {{ $business->about }}
                    </td>
                    <td class="px-6 py-4">
                        @if($business->businessType->sell_food_beverage === 1) Yes @else No @endif
                    </td>
                    <td class="px-6 py-4">
                        <div
                            class="inline-flex items-center justify-center"
                            x-data="{ circumference: 2 * 22 / 7 * 18}"
                        >
                            <svg class="transform -rotate-90 w-16 h-16">
                                <circle cx="32" cy="32" r="18" stroke="currentColor" stroke-width="5"
                                        fill="transparent"
                                        class="text-gray-400 dark:text-gray-700"/>
                                <circle cx="32" cy="32" r="18" stroke="currentColor" stroke-width="5"
                                        fill="transparent"
                                        :stroke-dasharray="circumference"
                                        :stroke-dashoffset="circumference - ({{ $business->step_completed }}/{{ $business->total_steps }}) * 100 / 100 * circumference"
                                        class="text-blue-500 "
                                />
                            </svg>
                            <span class="absolute dark:text-white">{{ $business->step_completed }}/{{ $business->total_steps }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        {{ $business->created_at->diffForHumans() }}
                    </td>
                    <td class="px-6 py-4">
                        {{ $business->updated_at->diffForHumans() }}
                    </td>
                    <td class="px-6 py-4">
                        @php
                            if ($business->step_completed < 2){
                                $editUrl = route('user.businesses.opening_hours.edit', $business->id);
                            }elseif ($business->step_completed < 3){
                                $editUrl = route('user.businesses.links.edit', $business->id);
                            }elseif ($business->step_completed < 4){
                                $editUrl = route('user.businesses.media.edit', $business->id);
                            }elseif ($business->step_completed < 5 && $business->businessType->sell_food_beverage){
                                $editUrl = route('user.businesses.restaurant_type.edit', $business->id);
                            }elseif ($business->step_completed < 6 && $business->businessType->sell_food_beverage){
                                $editUrl = route('user.businesses.menus.edit.index', $business->id);
                            }elseif ($business->step_completed < 5 && !$business->businessType->sell_food_beverage){
                                $editUrl = route('user.businesses.products.edit.index', $business->id);
                            }else{
                                $editUrl = route('user.businesses.basic_details.edit', $business->id);
                            }
                        @endphp
                        <a
                            href="{{ route('user.businesses.show', $business->id) }}"
                            class="text-blue-500 hover:underline"
                        >
                            Show
                        </a>
                        <br>
                        <a
                            href="{{ $editUrl }}"
                            class="text-yellow-500 hover:underline"
                        >
                            Edit
                        </a>
                        <form action="{{ route('user.businesses.destroy',$business->id) }}" method="Post"
                              onclick="return confirm('Are you sure you want to delete user?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:underline">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td class="px-6 py-4 text-center" colspan="9">
                        <p>No Business Found. Create your first business by click below button.</p>
                        <a href="{{ route('user.businesses.basic_details.create') }}">
                            <x-secondary-button class="mt-4">
                                Add
                            </x-secondary-button>
                        </a>
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <div class="py-4">
        {{ $businesses->links() }}
    </div>
@endsection
