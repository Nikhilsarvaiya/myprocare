@extends('layouts.app')

@section('main')
    <!-- Heading -->
    <div class="flex justify-between">
        <h1 class="mb-3 text-xl font-semibold dark:text-white">Centers Create</h1>

        <a href="{{ route('admin.centers.index') }}">
            <x-secondary-button>
                <i class="fa-solid fa-arrow-left"></i>
            </x-secondary-button>
        </a>
    </div>

    <form method="POST" enctype="multipart/form-data" action="{{ route('admin.centers.store') }}">
        @csrf

        <div>
            <x-input-label for="name" :value="__('Name')"/>

            <x-text-input
                id="name"
                name="name"
                type="text"
                :value="old('name')"
                class="block mt-1 w-full"
                autofocus
            />

            <x-input-error :messages="$errors->get('name')" class="mt-2"/>
        </div>

        <div>
            <x-input-label class="mt-2" for="capacity" :value="__('Capacity')"/>

            <x-text-input
                id="capacity"
                name="capacity"
                type="number"
                :value="old('capacity') ?? 0"
                class="block mt-1 w-full"
                min="0"
                autofocus
            />

            <x-input-error :messages="$errors->get('capacity')" class="mt-2"/>
        </div>

        <div>
            <x-input-label class="mt-2" for="goal" :value="__('Goal')"/>

            <x-text-input
                id="goal"
                name="goal"
                type="number"
                :value="old('goal') ?? 0"
                class="block mt-1 w-full"
                min="0"
                max="100"
                autofocus
            />

            <x-input-error :messages="$errors->get('goal')" class="mt-2"/>
        </div>

        <x-primary-button class="mt-4" type="submit">
            {{ __('Save') }}
        </x-primary-button>
    </form>
@endsection

@push('script')
    <script type="module">
    </script>
@endpush
