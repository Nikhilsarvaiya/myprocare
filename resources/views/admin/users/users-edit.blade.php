@extends('layouts.app')

@section('main')
    <!-- Heading -->
    <div class="flex justify-between">
        <h1 class="mb-3 text-xl font-semibold dark:text-white">Users Edit</h1>

        <a href="{{ route('admin.users.index') }}">
            <x-secondary-button>
                <i class="fa-solid fa-arrow-left"></i>
            </x-secondary-button>
        </a>
    </div>

    <form method="POST" enctype="multipart/form-data" action="{{ route('admin.users.update', $user->id) }}">
        @csrf
        @method('PUT')

        <div>
            <x-input-label for="name" :value="__('Name')"/>

            <x-text-input
                id="name"
                class="block mt-1 w-full"
                type="text"
                name="name"
                :value="old('name') ?? $user->name"
                required
                autofocus
            />

            <x-input-error :messages="$errors->get('name')" class="mt-2"/>
        </div>

        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')"/>

            <x-text-input
                id="email"
                class="block mt-1 w-full"
                type="text"
                name="email"
                :value="old('email') ?? $user->email"
                required
            />

            <x-input-error :messages="$errors->get('email')" class="mt-2"/>
        </div>

        <div class="mt-4">
            <x-input-label for="roles" :value="__('Roles')"/>

            <select
                id="roles"
                name="roles[]"
                multiple
            >
            </select>

            <x-input-error :messages="$errors->get('roles')" class="mt-2"/>
            <x-input-errors :messages="$errors->get('roles.*')"/>
        </div>

        <div class="mt-4">
            <x-input-label for="password" :value="__('New Password')"/>

            <x-text-input
                id="password"
                class="block mt-1 w-full"
                type="password"
                name="password"
            />

            <x-input-error :messages="$errors->get('password')" class="mt-2"/>
        </div>

        <x-primary-button class="mt-4" type="submit">
            {{ __('Save') }}
        </x-primary-button>
    </form>
@endsection

@push('script')
    <script type="module">
        const element = document.querySelector('#roles');

        const choices = new Choices(element, {
            choices: {!! json_encode($roles) !!},
            placeholderValue: "select roles",
            removeItems: true,
            removeItemButton: true,
            duplicateItemsAllowed: false,
        });
    </script>
@endpush
