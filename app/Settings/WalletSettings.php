<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class WalletSettings extends Settings
{
    public int $max_deposit_per_customer_by_all_business = 500;
    public int $max_deposit_per_customer_by_single_business = 500;

    public static function group(): string
    {
        return 'wallet';
    }
}
