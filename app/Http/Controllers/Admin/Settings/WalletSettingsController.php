<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateWalletSettingsRequest;
use App\Settings\WalletSettings;

class WalletSettingsController extends Controller
{
    public function edit(WalletSettings $walletSettings)
    {
        return view('admin.settings.wallet-settings-edit', compact('walletSettings'));
    }

    public function update(UpdateWalletSettingsRequest $request, WalletSettings $walletSettings)
    {
        $walletSettings->max_deposit_per_customer_by_all_business = $request->max_deposit_per_customer_by_all_business;
        $walletSettings->max_deposit_per_customer_by_single_business = $request->max_deposit_per_customer_by_single_business;
        $walletSettings->save();

        return redirect()->route('admin.settings.wallet.edit');
    }
}
