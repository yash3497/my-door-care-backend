<?php

namespace Database\Seeders\Admin;

use App\Models\Admin\BasicSettings;
use Illuminate\Database\Seeder;

class BasicSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $basic_settings = array(
            array('id' => '1', 'site_name' => 'SitterHub', 'site_title' => 'Baby and Pet Sitting Services Platform', 'base_color' => '#FF735F', 'secondary_color' => '#ea5455', 'otp_exp_seconds' => '3600', 'timezone' => 'Asia/Dhaka', 'user_registration' => '1', 'secure_password' => '1', 'agree_policy' => '1', 'force_ssl' => '1', 'email_verification' => '1', 'sms_verification' => '1', 'email_notification' => '1', 'push_notification' => '1', 'kyc_verification' => '1', 'site_logo_dark' => 'seeder/logo.webp', 'site_logo' => 'seeder/logo.webp', 'site_fav_dark' => 'seeder/fav-icon.webp', 'site_fav' => 'seeder/fav-icon.webp', 'mail_config' => '{"method":"smtp","host":"appdevs.net","port":"465","encryption":"ssl","username":"system@appdevs.net","password":"QP2fsLk?80Ac","from":"system@appdevs.net","app_name":"SitterHub"}', 'mail_activity' => NULL, 'push_notification_config' => '{"method":"pusher","instance_id":"fd7360fa-4df7-43b9-b1b5-5a40002250a1","primary_key":"6EEDE8A79C61800340A87C89887AD14533A712E3AA087203423BF01569B13845"}', 'push_notification_activity' => NULL, 'broadcast_config' => '{"method":"pusher","app_id":"1574360","primary_key":"971ccaa6176db78407bf","secret_key":"a30a6f1a61b97eb8225a","cluster":"ap2"}', 'broadcast_activity' => NULL, 'sms_config' => NULL, 'sms_activity' => NULL, 'web_version' => '1.2.0', 'created_at' => '2023-05-16 05:59:38', 'updated_at' => '2023-12-13 09:11:54')
        );

        BasicSettings::insert($basic_settings);
    }
}
