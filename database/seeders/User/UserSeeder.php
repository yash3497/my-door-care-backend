<?php

namespace Database\Seeders\User;

use App\Models\User;
use App\Models\UserWallet;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = array(
            array('id' => '11', 'firstname' => 'User', 'lastname' => 'Test', 'username' => 'usertest', 'email' => 'user@appdevs.net', 'mobile_code' => NULL, 'mobile' => NULL, 'full_mobile' => NULL, 'password' => '$2y$10$ZZp6im9W2j5ixkSMUGFj3.Wy/mj10gadirAGaQOsB88nOA5Hzakte', 'refferal_user_id' => NULL, 'image' => NULL, 'status' => '1', 'address' => '{"country":"Bangladesh","state":"Mirpur","city":"dhaka","town":"Dhaka","address":"Road-7"}', 'email_verified' => '1', 'sms_verified' => '1', 'kyc_verified' => '0', 'ver_code' => NULL, 'ver_code_send_at' => NULL, 'two_factor_verified' => '1', 'two_factor_status' => '0', 'two_factor_secret' => 'TW3R6OWQQCQFGSPH', 'device_id' => NULL, 'email_verified_at' => NULL, 'remember_token' => NULL, 'deleted_at' => NULL, 'created_at' => '2023-07-19 09:17:48', 'updated_at' => '2023-08-06 13:40:00')
        );
        User::insert($users);

        $user_wallets = array(
            array('id' => '1','user_id' => '11','currency_id' => '1','balance' => '0.00000000','status' => '1','created_at' => '2023-10-09 11:04:55','updated_at' => NULL)
          );
          UserWallet::insert($user_wallets);
    }
}
