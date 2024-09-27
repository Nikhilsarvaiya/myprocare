@extends('layouts.app')

@section('main')
    <!-- Heading -->
    <h1 class="mb-3 text-xl font-semibold dark:text-white">Businesses</h1>

    <div class="lg:flex lg:justify-between items-center">
        <!-- Search Bar -->
        <x-web.table-search-bar :url="route('admin.businesses.index')"/>

        <div class="mb-3 flex items-center space-x-3">
            <a href="{{ route('admin.businesses.index') }}">
                <x-secondary-button>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                         stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99"/>
                    </svg>
                </x-secondary-button>
            </a>
            <a href="{{ route('admin.businesses.basic_details.create') }}">
                <x-secondary-button>
                    Add
                </x-secondary-button>
            </a>
        </div>
    </div>

    @php
        $columns = [
            ['name' => 'id', 'label' => 'Id', 'sortable' => true],
            ['name' => 'profile', 'label' => 'Profile', 'sortable' => false],
            ['name' => 'name', 'label' => 'Name', 'sortable' => false],
            ['name' => 'user_id', 'label' => 'Owner', 'sortable' => true],
            ['name' => 'sell_food_beverage', 'label' => 'Sell Food & Beverages', 'sortable' => false],
            ['name' => 'step_completed', 'label' => 'Steps', 'sortable' => false],
            ['name' => 'approved', 'label' => 'Approved', 'sortable' => true],
            ['name' => 'updated_at', 'label' => 'Updated At', 'sortable' => true],
            ['name' => 'action', 'label' => 'Action', 'sortable' => false],
        ];
    @endphp

    <x-table.main :columns="$columns">
        @foreach($businesses as $business)
            <x-table.tr>
                <x-table.td :th="true">{{ $business->id }}</x-table.td>
                <x-table.td>
                    <x-web.table-image-thumb :media="$business->media"/>
                </x-table.td>
                <x-table.td>{{ $business->name }}</x-table.td>
                <x-table.td>
                   {{ $business->user->name ?? '-' }}
                </x-table.td>
                <x-table.td>
                    @if($business->businessType->sell_food_beverage === 1) Yes @else No @endif
                </x-table.td>
                <x-table.td>
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
                </x-table.td>
                <x-table.td class="whitespace-nowrap">
                    @if($business->approved)
                        <span
                            class="bg-green-700 text-white text-xs font-medium mr-2 px-2.5 py-1 rounded"
                        >
                            approved
                        </span>
                    @else
                        <form
                            action="{{ route('admin.businesses.approve', $business->id) }}"
                            method="post"
                        >
                            @csrf

                            <button
                                type="submit"
                                class="{{ $business->approved ? 'bg-green-700' : 'bg-yellow-600' }} text-white text-xs font-medium mr-2 px-2.5 py-1 rounded"
                                onclick="return confirm('Are you sure you want to approve business?')"
                            >
                                {{ $business->approved ? 'approved' : 'pending' }}
                                <i class="fa fa-circle-check ms-1"></i>
                            </button>
                        </form>
                    @endif
                </x-table.td>
                <x-table.td>{{ $business->updated_at->diffForHumans() }}</x-table.td>
                <x-table.td>
                    @php
                        if ($business->step_completed < 2){
                            $editUrl = route('admin.businesses.opening_hours.edit', $business->id);
                        }elseif ($business->step_completed < 3){
                            $editUrl = route('admin.businesses.links.edit', $business->id);
                        }elseif ($business->step_completed < 4){
                            $editUrl = route('admin.businesses.media.edit', $business->id);
                        }elseif ($business->step_completed < 5 && $business->businessType->sell_food_beverage){
                            $editUrl = route('admin.businesses.restaurant_type.edit', $business->id);
                        }elseif ($business->step_completed < 6 && $business->businessType->sell_food_beverage){
                            $editUrl = route('admin.businesses.menus.edit.index', $business->id);
                        }elseif ($business->step_completed < 5 && !$business->businessType->sell_food_beverage){
                            $editUrl = route('admin.businesses.products.edit.index', $business->id);
                        }else{
                            $editUrl = route('admin.businesses.basic_details.edit', $business->id);
                        }
                    @endphp
                    <a
                        href="{{ route('admin.businesses.show', $business->id) }}"
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
                    <form action="{{ route('admin.businesses.destroy',$business->id) }}" method="Post"
                          onclick="return confirm('Are you sure you want to delete user?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-500 hover:underline">Delete</button>
                    </form>
                </x-table.td>
            </x-table.tr>
        @endforeach
    </x-table.main>

    <div class="py-4">
        {{ $businesses->links() }}
    </div>
@endsection
