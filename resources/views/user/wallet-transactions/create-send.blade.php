@extends('layouts.app')

@section('main')
    <!-- Heading -->
    <div class="flex justify-between">
        <x-web.page-title :title="'Send Reward Point'"/>

        <a href="{{ route('user.wallet-transactions.index') }}">
            <x-secondary-button>
                <i class="fa-solid fa-arrow-left"></i>
            </x-secondary-button>
        </a>
    </div>

    <form method="POST" enctype="multipart/form-data" action="{{ route('user.wallet-transactions.send') }}">
        @csrf

        <input type="hidden" name="user_id" value="{{ $user->id }}">

        <div>
            <h3 class="dark:text-gray-300">
                <span class="font-semibold">User Name: </span>
                {{ $user->name }}
            </h3>
            <x-input-error :messages="$errors->get('user_id')" class="mt-2"/>
        </div>

        <div class="mt-4">
            <x-input-label for="reward_point" :value="__('Reward Point')"/>

            <x-text-input
                id="reward_point"
                name="reward_point"
                type="number"
                :value="old('reward_point')"
                class="block mt-1 w-full"
                required
            />

            <x-input-error :messages="$errors->get('reward_point')" class="mt-2"/>
        </div>

        <x-primary-button class="mt-4" type="submit">
            {{ __('Save') }}
        </x-primary-button>
    </form>
@endsection
