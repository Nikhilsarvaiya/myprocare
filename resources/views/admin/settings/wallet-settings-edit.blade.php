@extends('layouts.app')

@section('main')
    <!-- Heading -->
    <x-web.page-title>Wallet Settings</x-web.page-title>

    <form method="post" action="{{ route('admin.settings.wallet.update') }}">
        @csrf
        @method('put')

        <div>
            <x-input-label for="max_deposit_per_customer_by_all_business" :value="__('Max Deposit Per Customer By All Business')"/>

            <x-text-input
                id="max_deposit_per_customer_by_all_business"
                name="max_deposit_per_customer_by_all_business"
                type="text"
                :value="old('max_deposit_per_customer_by_all_business', $walletSettings->max_deposit_per_customer_by_all_business)"
                class="block mt-1 w-full"
                required
                autofocus
            />

            <x-input-error :messages="$errors->get('max_deposit_per_customer_by_all_business')" class="mt-2"/>
        </div>

        <div class="mt-4">
            <x-input-label for="max_deposit_per_customer_by_single_business" :value="__('Max Deposit Per Customer By Single Business')"/>

            <x-text-input
                id="max_deposit_per_customer_by_single_business"
                name="max_deposit_per_customer_by_single_business"
                type="text"
                :value="old('max_deposit_per_customer_by_single_business', $walletSettings->max_deposit_per_customer_by_single_business)"
                class="block mt-1 w-full"
                required
                autofocus
            />

            <x-input-error :messages="$errors->get('max_deposit_per_customer_by_single_business')" class="mt-2"/>
        </div>

        <x-primary-button class="mt-4" type="submit">
            {{ __('Save') }}
        </x-primary-button>
    </form>
@endsection
