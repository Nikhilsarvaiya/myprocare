<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDepositWalletTransactionRequest;
use App\Http\Requests\StoreSendWalletTransactionRequest;
use App\Http\Requests\StoreWithdrawWalletTransactionRequest;
use App\Http\Resources\WalletTransactionResource;
use App\Models\Business;
use App\Models\BusinessOffer;
use App\Models\User;
use App\Models\WalletTransaction;
use Illuminate\Http\Request;

class WalletTransactionController extends Controller
{
    public function index()
    {
        $wallet_transactions = WalletTransaction::query()
            ->with(['business'])
            ->where('user_id', \Auth::id())
            ->latest()
            ->paginate(10);

        return WalletTransactionResource::collection($wallet_transactions);
    }

    public function deposit(StoreDepositWalletTransactionRequest $request)
    {
        $customer = User::query()->findOrFail($request->user_id);

        $business = Business::query()
            ->where([
                'id' => $request->business_id,
                'user_id' => \Auth::id(),
            ])
            ->firstOrFail();

        $walletTransaction = $customer->deposit($request->reward_point, $business->id);

        return new WalletTransactionResource($walletTransaction);
    }

    public function withdraw(StoreWithdrawWalletTransactionRequest $request)
    {
        $customer = User::query()->findOrFail($request->user_id);

        $business = Business::query()
            ->where([
                'id' => $request->business_id,
                'user_id' => \Auth::id(),
            ])
            ->firstOrFail();

        $business_offer = BusinessOffer::query()
            ->where([
                'id' => $request->business_offer_id,
                'business_id' => $business->id
            ])
            ->firstOrFail();

        $walletTransaction = $customer->withdraw($business_offer->reward_point, $business->id);

        return new WalletTransactionResource($walletTransaction);
    }

    public function send(StoreSendWalletTransactionRequest $request)
    {
        $to_user = User::query()->findOrFail($request->user_id);

        $walletTransaction = \Auth::user()->transfer($to_user, $request->reward_point);

        return new WalletTransactionResource($walletTransaction);
    }
}
