@extends('layouts.app')

@section('main')
    <!-- Heading -->
    <div class="flex justify-between">
        <h1 class="mb-3 text-xl font-semibold dark:text-white">Centers Edit</h1>

        <a href="{{ route('admin.centers.index') }}">
            <x-secondary-button>
                <i class="fa-solid fa-arrow-left"></i>
            </x-secondary-button>
        </a>
    </div>

    <form method="POST" enctype="multipart/form-data" action="{{ route('admin.centers.update', $center->id) }}">
        @csrf
        @method('PUT')

            <x-text-input
                type="hidden"
                name="id"
                :value="old('id') ?? $center->id"
            />

        <div>
            <x-input-label for="name" :value="__('Name')"/>

            <x-text-input
                id="name"
                class="block mt-1 w-full"
                type="text"
                name="name"
                :value="old('name') ?? $center->name"
                required
                autofocus
            />

            <x-input-error :messages="$errors->get('name')" class="mt-2"/>
        </div>

        <div>
            <x-input-label class="mt-2" for="capacity" :value="__('Capacity')"/>

            <x-text-input
                id="capacity"
                class="block mt-1 w-full"
                type="number"
                name="capacity"
                :value="old('capacity') ?? $center->capacity"
                min="0"
                required
                autofocus
            />

            <x-input-error :messages="$errors->get('capacity')" class="mt-2"/>
        </div>

        <div>
            <x-input-label class="mt-2" for="goal" :value="__('Goal')"/>

            <x-text-input
                id="goal"
                class="block mt-1 w-full"
                type="number"
                name="goal"
                :value="old('goal') ?? $center->goal"
                min="0"
                max="100"
                required
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
