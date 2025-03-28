<?php

namespace Database\Seeders\Admin;

use App\Models\Admin\ServiceArea;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServiceAreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $service_areas = array(
            array('id' => '1', 'service_area' => 'Dhaka', 'slug' => 'dhaka', 'created_at' => '2023-07-10 10:02:18', 'updated_at' => '2023-07-10 10:05:00'),
            array('id' => '2', 'service_area' => 'Chicago', 'slug' => 'chicago', 'created_at' => '2023-07-10 10:02:18', 'updated_at' => '2023-07-10 10:05:00'),
            array('id' => '3', 'service_area' => 'New York', 'slug' => 'new-york', 'created_at' => '2023-07-10 10:02:18', 'updated_at' => '2023-07-10 10:05:00'),
        );

        ServiceArea::insert($service_areas);
    }
}
