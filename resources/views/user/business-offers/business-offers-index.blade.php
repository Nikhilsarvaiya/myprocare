@extends('layouts.app')

@section('main')
    <x-web.page-title :title="'Business Offers'"/>

    <div class="lg:flex lg:justify-between items-center">
        <!-- Search Bar -->
        <x-web.table-search-bar :url="route('user.business-offers.index')"/>

        <div class="mb-3 flex items-center space-x-3">
            <a href="{{ route('user.business-offers.index') }}">
                <x-secondary-button>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                         stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99"/>
                    </svg>
                </x-secondary-button>
            </a>
            <a href="{{ route('user.business-offers.create') }}">
                <x-secondary-button @click="showAddCategoryModal = true" type="button">
                    Add
                </x-secondary-button>
            </a>
        </div>
    </div>

    <!-- Table -->
    <div class="relative overflow-x-auto shadow-md rounded-lg">
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
                        Image
                    </button>
                </th>
                <th scope="col" class="px-6 py-3">
                    <button onclick="MyApp.sortData('title')" class="flex items-center">
                        Title
                        <svg xmlns="http://www.w3.org/2000/svg" class="ml-1 h-3 w-3" aria-hidden="true"
                             fill="currentColor" viewBox="0 0 320 512">
                            <path
                                d="M27.66 224h264.7c24.6 0 36.89-29.78 19.54-47.12l-132.3-136.8c-5.406-5.406-12.47-8.107-19.53-8.107c-7.055 0-14.09 2.701-19.45 8.107L8.119 176.9C-9.229 194.2 3.055 224 27.66 224zM292.3 288H27.66c-24.6 0-36.89 29.77-19.54 47.12l132.5 136.8C145.9 477.3 152.1 480 160 480c7.053 0 14.12-2.703 19.53-8.109l132.3-136.8C329.2 317.8 316.9 288 292.3 288z"/>
                        </svg>
                    </button>
                </th>
                <th scope="col" class="px-6 py-3">
                    <button class="flex items-center">
                        Description
                    </button>
                </th>
                <th scope="col" class="px-6 py-3">
                    <button onclick="MyApp.sortData('reward_point')" class="flex items-center">
                        Reward Point
                        <svg xmlns="http://www.w3.org/2000/svg" class="ml-1 h-3 w-3" aria-hidden="true"
                             fill="currentColor" viewBox="0 0 320 512">
                            <path
                                d="M27.66 224h264.7c24.6 0 36.89-29.78 19.54-47.12l-132.3-136.8c-5.406-5.406-12.47-8.107-19.53-8.107c-7.055 0-14.09 2.701-19.45 8.107L8.119 176.9C-9.229 194.2 3.055 224 27.66 224zM292.3 288H27.66c-24.6 0-36.89 29.77-19.54 47.12l132.5 136.8C145.9 477.3 152.1 480 160 480c7.053 0 14.12-2.703 19.53-8.109l132.3-136.8C329.2 317.8 316.9 288 292.3 288z"/>
                        </svg>
                    </button>
                </th>
                <th scope="col" class="px-6 py-3">
                    <button onclick="MyApp.sortData('reward_point')" class="flex items-center">
                        Business
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
            @foreach($business_offers as $business_offer)
                <tr class="border-b bg-white dark:border-gray-700 dark:bg-gray-800">
                    <th scope="row" class="whitespace-nowrap px-6 py-4 font-medium text-gray-900 dark:text-white">
                        {{ $business_offer->id }}
                    </th>
                    <td class="px-6 py-4">
                        @if(count($business_offer->media) > 0)
                            <img src="{{ $business_offer->media[0]->getUrl() }}"
                                 class="!max-w-none h-20 w-20 object-fit">
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        {{ $business_offer->title }}
                    </td>
                    <td class="px-6 py-4">
                        {{ $business_offer->description }}
                    </td>
                    <td class="px-6 py-4">
                        {{ $business_offer->reward_point }}
                    </td>
                    <td class="px-6 py-4">
                        {{ $business_offer->business->name }}
                    </td>
                    <td class="px-6 py-4">
                        {{ $business_offer->created_at->diffForHumans() }}
                    </td>
                    <td class="px-6 py-4">
                        {{ $business_offer->updated_at->diffForHumans() }}
                    </td>
                    <td class="px-6 py-4">
                        <a href="{{ route('user.business-offers.edit', $business_offer->id) }}"
                           class="mr-2 text-blue-500 hover:underline">Edit</a>
                        <form action="{{ route('user.business-offers.destroy',$business_offer->id) }}" method="Post"
                              onclick="return confirm('Are you sure you want to delete business_offer?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:underline">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <div class="py-4">
        {{ $business_offers->links() }}
    </div>
@endsection
