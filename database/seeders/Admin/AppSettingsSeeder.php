<?php

namespace Database\Seeders\Admin;

use App\Models\Admin\AppOnboardScreens;
use App\Models\Admin\AppSettings;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AppSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $app_settings = array(
            array('id' => '1', 'version' => '1.2.0', 'splash_screen_image' => '6882c134-ade3-4485-b8d5-2c2888ece44e.webp', 'url_title' => 'App Title', 'android_url' => 'https://play.google.com/store', 'iso_url' => 'https://www.apple.com/app-store/', 'created_at' => '2023-05-16 05:59:38', 'updated_at' => '2023-12-13 16:23:07')
        );

        AppSettings::insert($app_settings);

        $app_onboard_screens = array(
            array('id' => '1', 'title' => 'Make Every Second Count', 'sub_title' => 'Earn money by selling sitter hub using sitter hub application', 'image' => '5fd14c85-6433-4a31-99f2-a0bed6845e6e.webp', 'status' => '1', 'last_edit_by' => '1', 'created_at' => '2023-06-23 16:35:09', 'updated_at' => '2023-12-13 16:23:44'),
            array('id' => '2', 'title' => 'Make Every Second Count', 'sub_title' => 'Earn money by selling sitter hub using sitter hub application', 'image' => '965ca8b7-e19f-4734-8a88-c67afe064bc9.webp', 'status' => '1', 'last_edit_by' => '1', 'created_at' => '2023-10-14 11:54:20', 'updated_at' => '2023-12-13 16:23:31')
        );



        AppOnboardScreens::insert($app_onboard_screens);
    }
}
