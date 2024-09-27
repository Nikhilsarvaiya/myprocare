@extends('layouts.front')

@section('main')
    <div class="max-w-7xl mx-auto px-2">
        <h1 class="mb-6 text-3xl font-bold text-gray-900 lg:text-4xl dark:text-white">Account Delete Request</h1>
        <p class="text-lg text-gray-600 dark:text-gray-400">
            send account delete request with reason.
        </p>

        <hr class="my-4 border-gray-200 dark:border-gray-800">

        <form method="POST" action="{{ route('account_delete.store') }}">
            @csrf

            <!-- Name -->
            <div>
                <x-input-label for="name" :value="__('Name')"/>
                <x-text-input
                    id="name"
                    name="name"
                    type="text"
                    :value="old('name')"
                    class="block mt-1 w-full"
                    required
                    autofocus
                />
                <x-input-error :messages="$errors->get('name')" class="mt-2"/>
            </div>

            <!-- Email Address -->
            <div class="mt-4">
                <x-input-label for="email" :value="__('Email')"/>
                <x-text-input
                    id="email"
                    name="email"
                    type="email"
                    :value="old('email')"
                    class="block mt-1 w-full"
                    required
                />
                <x-input-error :messages="$errors->get('email')" class="mt-2"/>
            </div>

            <!-- Phone -->
            <div class="mt-4">
                <x-input-label for="phone" :value="__('Phone')"/>

                <x-text-input
                    id="phone"
                    class="block mt-1 w-full"
                    type="text"
                    name="phone"
                    :value="old('phone')"
                    required
                />

                <x-input-error :messages="$errors->get('phone')" class="mt-2"/>
            </div>

            <!-- Message -->
            <div class="mt-4">
                <x-input-label for="message" :value="__('Reason For Account Delete')"/>
                <x-textarea-input
                    id="message"
                    class="block mt-1 w-full"
                    type="text"
                    name="message"
                    :value="old('message')"
                    required
                />
                <x-input-error :messages="$errors->get('message')" class="mt-2"/>
            </div>

            <div class="mt-4 flex items-center gap-4">
                <x-primary-button>{{ __('Send') }}</x-primary-button>

                @if (session('status') === 'request-send')
                    <p
                        x-data="{ show: true }"
                        x-show="show"
                        x-transition
                        x-init="setTimeout(() => show = false, 4000)"
                        class="text-sm text-green-600"
                    >{{ __('account delete request send to admin successfully.') }}</p>
                @endif
            </div>
        </form>
    </div>
@endsection
