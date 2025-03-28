<?php

namespace Database\Seeders\Nanny;

use App\Models\Nanny;
use App\Models\NannyKycData;
use App\Models\NannyProfession;
use App\Models\NannyWallet;
use Illuminate\Database\Seeder;

class NannySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $nannies = array(
            array('id' => '1', 'firstname' => 'Nanny', 'lastname' => 'Test', 'username' => 'nannytest', 'email' => 'nanny@appdevs.net', 'mobile_code' => NULL, 'mobile' => '01765561008', 'full_mobile' => NULL, 'password' => '$2y$10$WmayRCdmy9gwFRan47TGeOy2k220qWs8z1kv2/v4xJwDDVhGBgX2S', 'refferal_user_id' => NULL, 'image' => '221cad44-4ed7-4e72-a70a-9d1b6d2df08c.webp', 'status' => '1', 'address' => '{"country":"Bangladesh","state":"","city":"","zip":"","address":""}', 'email_verified' => '1', 'sms_verified' => '0', 'kyc_verified' => '1', 'profession_submitted' => '1', 'ver_code' => NULL, 'ver_code_send_at' => NULL, 'two_factor_verified' => '0', 'two_factor_status' => '0', 'two_factor_secret' => NULL, 'device_id' => NULL, 'email_verified_at' => NULL, 'remember_token' => NULL, 'deleted_at' => NULL, 'created_at' => '2023-07-13 11:32:56', 'updated_at' => '2024-02-14 11:50:31')
        );
        Nanny::insert($nannies);

        $nanny_wallets = array(
            array('id' => '1', 'nanny_id' => '1', 'currency_id' => '1', 'balance' => '1000.00000000', 'status' => '1', 'created_at' => '2024-01-30 14:39:25', 'updated_at' => NULL),
        );
        NannyWallet::insert($nanny_wallets);

        $nanny_professions = array(
            array('id' => '1', 'nanny_id' => '1', 'profession_type' => '1', 'profession_type_details' => '{"baby_gender":"Male","baby_age":"o - 6 Month","baby_number":"Single"}', 'work_experience' => 'o - 6 Month', 'work_capability' => '12 - 24 Hours', 'service_area' => 'dhaka', 'charge' => 'Hourly', 'amount' => '10', 'bio' => 'This is my bio', 'status' => '1', 'created_at' => '2023-07-15 14:52:40', 'updated_at' => '2023-07-15 14:52:40'),
        );
        NannyProfession::insert($nanny_professions);

        $nanny_kyc_data = array(
            array('id' => '1', 'nanny_id' => '1', 'data' => '[{"type":"file","label":"Backend","name":"backend","required":true,"validation":{"max":"10","mimes":["jpg","png","jpeg"],"min":0,"options":[],"required":true},"value":"9f860830-7c7c-4614-8c6e-83948412ba9e.webp"},{"type":"file","label":"Frontend","name":"frontend","required":true,"validation":{"max":"10","mimes":["jpg","png","jpeg"],"min":0,"options":[],"required":true},"value":"fc449f04-b4a0-4f72-a01d-cd59680d84f0.webp"},{"type":"select","label":"ID Type","name":"id_type","required":true,"validation":{"max":0,"min":0,"mimes":[],"options":["NID"," Driving License"," Passport"],"required":true},"value":"NID"}]', 'reject_reason' => NULL, 'created_at' => '2023-11-12 15:56:12', 'updated_at' => NULL),
        );

        NannyKycData::insert($nanny_kyc_data);
    }
}
