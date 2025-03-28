<?php

namespace Database\Seeders\User;

use App\Models\AddBabyPat;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AddBabyPetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $add_baby_pats = array(
            array('id' => '1', 'user_id' => '11', 'profession_type' => '1', 'profession_type_details' => '{"baby_name":"Rose","baby_gender":"Female","baby_age":"4 Years","baby_food":"Milk,Sugi"}', 'image' => '4ba17c7a-ea78-45e3-a5a2-61bda3f8aba4.webp', 'status' => '1', 'created_at' => '2023-07-19 09:32:54', 'updated_at' => '2023-07-19 09:32:54'),
            array('id' => '2', 'user_id' => '11', 'profession_type' => '2', 'profession_type_details' => '{"pet_name":"Duke","pet_type":"Dog","pet_breed":"4","pet_gender":"Male","pet_age":"3 Years","pet_weight":"6 Kg","pet_food":"Water,Bread"}', 'image' => 'c23daa71-2f66-4737-8e5b-374cb32057c7.webp', 'status' => '1', 'created_at' => '2023-07-19 09:35:09', 'updated_at' => '2023-07-19 09:35:09')
        );

        AddBabyPat::insert($add_baby_pats);
    }
}
