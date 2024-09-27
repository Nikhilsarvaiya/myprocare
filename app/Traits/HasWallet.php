<?php

namespace App\Traits;

use App\Enums\WalletTransactionTypeEnum;
use App\Models\User;
use App\Models\Wallet;
use App\Models\WalletTransaction;
use App\Settings\WalletSettings;
use Illuminate\Support\Carbon;
use Illuminate\Validation\ValidationException;

trait HasWallet
{
    public function getWallet(): Wallet
    {
        if (!$wallet = $this->wallet) {
            $wallet = $this->wallet()->create(['balance' => 0]);
        }

        return $wallet;
    }

    public function deposit(int|string $reward_point, int|string $business_id = null): WalletTransaction
    {
        $wallet = $this->getWallet();

        // Check limit used by business
        if ($business_id){
            $this->checkLimitUsedByBusiness($reward_point, $business_id);
        }

        // Create a deposit transaction
        $walletTransaction = WalletTransaction::query()->create([
            'wallet_id' => $wallet->id,
            'user_id' => $this->id,
            'sender_id' => \Auth::id(),
            'business_id' => $business_id,
            'reward_point' => $reward_point,
            'type' => WalletTransactionTypeEnum::DEPOSIT
        ]);

        // Update the user's wallet balance
        $wallet->balance += $reward_point;
        $wallet->save();

        return $walletTransaction;
    }

    public function withdraw(int|string $reward_point, int|string $business_id = null): WalletTransaction
    {
        $wallet = $this->getWallet();

        // Create a withdrawal transaction
        $walletTransaction = WalletTransaction::query()->create([
            'wallet_id' => $wallet->id,
            'user_id' => $this->id,
            'sender_id' => \Auth::id(),
            'business_id' => $business_id,
            'reward_point' => $reward_point,
            'type' => WalletTransactionTypeEnum::WITHDRAW
        ]);

        // Update the user's wallet balance
        $wallet->balance -= $reward_point;
        $wallet->save();

        return $walletTransaction;
    }

    public function transfer($to_user, $reward_point): WalletTransaction
    {
        $fromWallet = $this->getWallet();
        if ($fromWallet->balance < $reward_point){
            throw ValidationException::withMessages([
                'reward_point' => 'insufficient balance. your wallet balance is '. $fromWallet->balance
            ]);
        }

        // Create a withdrawal transaction
        $fromWalletTransaction = WalletTransaction::query()->create([
            'wallet_id' => $fromWallet->id,
            'user_id' => $this->id,
            'sender_id' => $to_user->id,
            'reward_point' => $reward_point,
            'type' => WalletTransactionTypeEnum::WITHDRAW
        ]);

        // Update the user's wallet balance
        $fromWallet->balance -= $reward_point;
        $fromWallet->save();

        // to user wallet
        $toWallet = $to_user->getWallet();

        // Create a deposit transaction
        WalletTransaction::query()->create([
            'wallet_id' => $toWallet->id,
            'user_id' => $to_user->id,
            'sender_id' => $this->id,
            'reward_point' => $reward_point,
            'type' => WalletTransactionTypeEnum::DEPOSIT
        ]);

        // Update the user's wallet balance
        $toWallet->balance += $reward_point;
        $toWallet->save();

        return $fromWalletTransaction;
    }

    private function checkLimitUsedByBusiness($reward_point, $business_id): void
    {
        $totalRewardPointOfCustomerGetBySelectedBusiness = WalletTransaction::query()
            ->where([
                ['user_id', $this->id],
                ['business_id', $business_id],
            ])
            ->whereDate('created_at', Carbon::today())
            ->sum("reward_point");

        $totalRewardPointOfCustomerGetByAllBusiness = WalletTransaction::query()
            ->where([
                ['user_id', $this->id],
                ['sender_id', \Auth::id()],
                ['business_id', '!=', null]
            ])
            ->whereDate('created_at', Carbon::today())
            ->sum("reward_point");

        $walletSettings = new WalletSettings();

        if ($totalRewardPointOfCustomerGetBySelectedBusiness + $reward_point > $walletSettings->max_deposit_per_customer_by_single_business) {
            $maxSend = $walletSettings->max_deposit_per_customer_by_single_business - $totalRewardPointOfCustomerGetBySelectedBusiness;
            throw ValidationException::withMessages([
                'reward_point' => 'limit reached for send reward point by selected business in one day. you can only send maximum ' . $maxSend . ' reward point to '.$this->name.' today.'
            ]);
        }

        if ($totalRewardPointOfCustomerGetByAllBusiness + $reward_point > $walletSettings->max_deposit_per_customer_by_all_business) {
            $maxSend = $walletSettings->max_deposit_per_customer_by_all_business - $totalRewardPointOfCustomerGetByAllBusiness;

            throw ValidationException::withMessages([
                'reward_point' => 'limit reached for send reward point by all businesses in one day. you can only send maximum ' . $maxSend . ' reward point to '.$this->name.' today.'
            ]);
        }
    }
}
