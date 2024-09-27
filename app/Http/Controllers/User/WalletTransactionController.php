<?php

namespace App\Http\Controllers\User;

use App\Enums\WalletTransactionTypeEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDepositWalletTransactionRequest;
use App\Http\Requests\StoreSendWalletTransactionRequest;
use App\Models\Business;
use App\Models\BusinessOffer;
use App\Models\Wallet;
use App\Models\WalletTransaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class WalletTransactionController extends Controller
{
    public function index()
    {
        $wallet = \Auth::user()->wallet;

        $wallet_transactions = WalletTransaction::query()
            ->with(['sender', 'business'])
            ->where('user_id', \Auth::id())
            ->latest()
            ->paginate(10);

        return view('user.wallet-transactions.index', compact('wallet', 'wallet_transactions'));
    }

    public function scan(Request $request, $type)
    {
        $data['type'] = $type;
        $validator = Validator::make($data, [
            'type' => [Rule::in(['send'])]
        ]);

        if ($validator->fails()){
            abort(404);
        }

        return view('user.wallet-transactions.scan');
    }

    public function create(Request $request, User $user, $type)
    {
        if ($type !== "send" || $user->id === \Auth::id()){
            abort(404);
        }

        return view('user.wallet-transactions.create-send', compact('user'));
    }

    public function send(StoreSendWalletTransactionRequest $request)
    {
        $to_user = User::query()->findOrFail($request->user_id);

        \Auth::user()->transfer($to_user, $request->reward_point);

        return redirect()->route('user.wallet-transactions.index');
    }
}
