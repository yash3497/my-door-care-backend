<?php

namespace Database\Seeders\Fresh;

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
            array('id' => '1', 'web_version' => '1.2.0', 'site_name' => 'SitterHub', 'site_title' => 'Baby and Pet Sitting Services Platform', 'base_color' => '#FF735F', 'secondary_color' => '#ea5455', 'otp_exp_seconds' => '3600', 'timezone' => 'Asia/Dhaka', 'user_registration' => '1', 'secure_password' => '1', 'agree_policy' => '1', 'force_ssl' => '1', 'email_verification' => '1', 'sms_verification' => '1', 'email_notification' => '1', 'push_notification' => '1', 'kyc_verification' => '1', 'site_logo_dark' => 'seeder/logo.webp', 'site_logo' => 'seeder/logo.webp', 'site_fav_dark' => 'seeder/fav-icon.webp', 'site_fav' => 'seeder/fav-icon.webp', 'mail_config' => '{"method":"","host":"","port":"","encryption":"","username":"","password":"","from":"","app_name":"SitterHub"}', 'mail_activity' => NULL, 'push_notification_config' => '{"method":"pusher","instance_id":"","primary_key":""}', 'push_notification_activity' => NULL, 'broadcast_config' => '{"method":"pusher","app_id":"","primary_key":"","secret_key":"","cluster":""}', 'broadcast_activity' => NULL, 'sms_config' => NULL, 'sms_activity' => NULL, 'created_at' => '2023-05-16 05:59:38', 'updated_at' => '2023-07-09 11:04:04')
        );
        BasicSettings::insert($basic_settings);
    }
}
