<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('wallet.max_deposit_per_customer_by_all_business', 500);
        $this->migrator->add('wallet.max_deposit_per_customer_by_single_business', 500);
    }

    public function down(): void
    {
        $this->migrator->delete('wallet.max_deposit_per_customer_by_all_business');
        $this->migrator->delete('wallet.max_deposit_per_customer_by_single_business');
    }
};
