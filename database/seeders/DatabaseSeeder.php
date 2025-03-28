<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;
use Database\Seeders\User\BlogSeeder;
use Database\Seeders\User\UserSeeder;
use Database\Seeders\Admin\RoleSeeder;
use Database\Seeders\Admin\AdminSeeder;
use Database\Seeders\Nanny\NannySeeder;
use Database\Seeders\Admin\AddCoinSeeder;
use Database\Seeders\Admin\CurrencySeeder;
use Database\Seeders\Admin\SetupKycSeeder;
use Database\Seeders\Admin\SetupSeoSeeder;
use Database\Seeders\Admin\ExtensionSeeder;
use Database\Seeders\Admin\SetupPageSeeder;
use Database\Seeders\User\AddBabyPetSeeder;
use Database\Seeders\Admin\SetupEmailSeeder;
use Database\Seeders\Admin\AppSettingsSeeder;
use Database\Seeders\Admin\ServiceAreaSeeder;
use Database\Seeders\Admin\UsefullLinkSeeder;
use Database\Seeders\Admin\AdminHasRoleSeeder;
use Database\Seeders\Admin\SiteSectionsSeeder;
use Database\Seeders\Admin\BasicSettingsSeeder;
use Database\Seeders\Admin\FeesAndChargesSeeder;
use Database\Seeders\Admin\PaymentGatewaySeeder;
use Database\Seeders\Admin\SystemMaintenanceSeeder;
use Database\Seeders\Admin\TransactionSettingSeeder;
use Database\Seeders\Fresh\ExtensionSeeder as FreshExtensionSeeder;
use Database\Seeders\Fresh\SetupEmailSeeder as FreshSetupEmailSeeder;
use Database\Seeders\Fresh\BasicSettingsSeeder as FreshBasicSettingsSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        // Demo
        // $this->call([
        //     AdminSeeder::class,
        //     RoleSeeder::class,
        //     TransactionSettingSeeder::class,
        //     CurrencySeeder::class,
        //     BasicSettingsSeeder::class,
        //     SetupSeoSeeder::class,
        //     AppSettingsSeeder::class,
        //     SiteSectionsSeeder::class,
        //     ExtensionSeeder::class,
        //     AdminHasRoleSeeder::class,
        //     UserSeeder::class,
        //     SetupPageSeeder::class,
        //     AddCoinSeeder::class,
        //     PaymentGatewaySeeder::class,
        //     SetupEmailSeeder::class,
        //     UsefullLinkSeeder::class,
        //     LanguageSeeder::class,
        //     ServiceAreaSeeder::class,
        //     SetupKycSeeder::class,
        //     NannySeeder::class,
        //     AddBabyPetSeeder::class,
        //     BlogSeeder::class,
        //     SystemMaintenanceSeeder::class,
        // ]);

        // Fresh
        $this->call([
            AdminSeeder::class,
            RoleSeeder::class,
            TransactionSettingSeeder::class,
            CurrencySeeder::class,
            FreshBasicSettingsSeeder::class,
            SetupSeoSeeder::class,
            AppSettingsSeeder::class,
            SiteSectionsSeeder::class,
            SetupKycSeeder::class,
            FreshExtensionSeeder::class,
            AdminHasRoleSeeder::class,
            SetupPageSeeder::class,
            FeesAndChargesSeeder::class,
            PaymentGatewaySeeder::class,
            FreshSetupEmailSeeder::class,
            UsefullLinkSeeder::class,
            LanguageSeeder::class,
            BlogSeeder::class,
            SystemMaintenanceSeeder::class,
        ]);
    }
}
