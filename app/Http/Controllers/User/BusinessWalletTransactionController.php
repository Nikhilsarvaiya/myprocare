<?php

namespace App\Http\Controllers\User;

use App\Enums\WalletTransactionTypeEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDepositWalletTransactionRequest;
use App\Http\Requests\StoreWithdrawWalletTransactionRequest;
use App\Models\Business;
use App\Models\BusinessOffer;
use App\Models\User;
use App\Models\WalletTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class BusinessWalletTransactionController extends Controller
{
    public function index()
    {
        $businesses = Business::query()->select(['id'])->where('user_id', \Auth::id())->toBase()->get()->pluck('id');

        $wallet_transactions = WalletTransaction::query()
            ->with(['user', 'business'])
            ->whereIn('business_id', $businesses)
            ->latest()
            ->paginate(10);

        return view('user.businesses.wallet-transactions.index', compact('wallet_transactions'));
    }

    public function scan(Request $request, $type)
    {
        $data['type'] = $type;
        $validator = Validator::make($data, [
            'type' => [Rule::enum(WalletTransactionTypeEnum::class)]
        ]);

        if ($validator->fails()){
            abort(404);
        }

        return view('user.businesses.wallet-transactions.scan');
    }

    public function create(Request $request, User $user, $type)
    {
        $data['type'] = $type;
        $validator = Validator::make($data, [
            'type' => [Rule::enum(WalletTransactionTypeEnum::class)]
        ]);

        if ($validator->fails()){
            abort(404);
        }

        $businesses = Business::query()->select(['id', 'name'])->where('user_id', \Auth::id())->toBase()->get();

        if ($type == WalletTransactionTypeEnum::DEPOSIT->value) {
            return view('user.businesses.wallet-transactions.create-deposit', compact('user', 'businesses'));
        } else {
            $businessOffers = BusinessOffer::query()->whereIn('business_id', $businesses->pluck('id'))->get();

            return view('user.businesses.wallet-transactions.create-withdraw', compact('user', 'businesses', 'businessOffers'));
        }
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

        $customer->deposit($request->reward_point, $business->id);

        return redirect()->route('user.businesses.wallet-transactions.index');
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

        $customer->withdraw($business_offer->reward_point, $business->id);

        return redirect()->route('user.businesses.wallet-transactions.index');
    }
}
