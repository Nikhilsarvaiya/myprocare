@extends('layouts.app')

@section('main')
    <div class="lg:flex lg:justify-between items-center">
        <x-web.page-title :title="'Business Transactions'"/>

        <div class="mb-3 flex items-center space-x-3">
            <a href="{{ route('user.businesses.wallet-transactions.scan', \App\Enums\WalletTransactionTypeEnum::WITHDRAW) }}">
                <x-secondary-button>
                    Redeem
                </x-secondary-button>
            </a>
            <a href="{{ route('user.businesses.wallet-transactions.scan', \App\Enums\WalletTransactionTypeEnum::DEPOSIT) }}">
                <x-secondary-button>
                    Send
                </x-secondary-button>
            </a>
        </div>
    </div>

    @php
        $columns = [
            ['name' => 'id', 'label' => 'Id', 'sortable' => false],
            ['name' => 'user_id', 'label' => 'Customer', 'sortable' => false],
            ['name' => 'business_id', 'label' => 'Business', 'sortable' => false],
            ['name' => 'reward_point', 'label' => 'Reward Point', 'sortable' => false],
            ['name' => 'created_at', 'label' => 'Created At', 'sortable' => false],
        ];
    @endphp

    <x-table.main :columns="$columns">
        @foreach($wallet_transactions as $wallet_transaction)
            <x-table.tr>
                <x-table.td :th="true">{{ $wallet_transaction->id }}</x-table.td>
                <x-table.td>{{ $wallet_transaction->user->name }}</x-table.td>
                <x-table.td>{{ $wallet_transaction->business->name }}</x-table.td>
                <x-table.td>
                    @if($wallet_transaction->type === \App\Enums\WalletTransactionTypeEnum::DEPOSIT->value)
                        <span class="text-green-500">{{ $wallet_transaction->reward_point }}</span>
                    @else
                        <span class="text-red-500">{{ $wallet_transaction->reward_point }}</span>
                    @endif
                </x-table.td>
                <x-table.td>{{ $wallet_transaction->created_at->diffForHumans() }}</x-table.td>
            </x-table.tr>
        @endforeach
    </x-table.main>

    <div class="py-4">
        {{ $wallet_transactions->links() }}
    </div>
@endsection
