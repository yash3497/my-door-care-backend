<?php

namespace Database\Seeders\User;

use App\Models\UserRequest;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserRequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user_requests = array(
            array('id' => '1', 'user_id' => '11', 'nanny_id' => '9', 'add_baby_pet_id' => '1', 'started_date' => '2023-07-27', 'end_date' => '2023-07-27', 'service_type' => '1', 'service_day' => '1', 'daily_working_hour' => '1', 'total_hour' => '1', 'nanny_charge' => '10', 'started_time' => '17:01:00', 'total' => '10', 'service_charge' => '2', 'payable' => '12', 'currency_code' => 'USD', 'address' => 'address', 'status' => '0', 'created_at' => '2023-07-27 17:01:29', 'updated_at' => '2023-07-27 17:01:29'),
            array('id' => '2', 'user_id' => '11', 'nanny_id' => '9', 'add_baby_pet_id' => '1', 'started_date' => '2023-07-27', 'end_date' => '2023-07-27', 'service_type' => '1', 'service_day' => '1', 'daily_working_hour' => '1', 'total_hour' => '1', 'nanny_charge' => '10', 'started_time' => '17:53:00', 'total' => '10', 'service_charge' => '2', 'payable' => '12', 'currency_code' => 'USD', 'address' => 'address', 'status' => '0', 'created_at' => '2023-07-27 17:53:49', 'updated_at' => '2023-07-27 17:53:49')
        );

        UserRequest::insert($user_requests);
    }
}
