<?php

namespace Database\Seeders\Admin;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Admin\SetupKyc;
use App\Models\NannyKycData;

class SetupKycSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $setup_kycs = array(
            array('id' => '2', 'slug' => 'nanny', 'user_type' => 'NANNY', 'fields' => '[{"type":"file","label":"Backend","name":"backend","required":true,"validation":{"max":"10","mimes":["jpg","png","jpeg"],"min":0,"options":[],"required":true}},{"type":"file","label":"Frontend","name":"frontend","required":true,"validation":{"max":"10","mimes":["jpg","png","jpeg"],"min":0,"options":[],"required":true}},{"type":"select","label":"ID Type","name":"id_type","required":true,"validation":{"max":0,"min":0,"mimes":[],"options":["NID"," Driving License"," Passport"],"required":true}}]', 'status' => '1', 'last_edit_by' => '1', 'created_at' => '2023-07-10 10:09:15', 'updated_at' => '2023-11-12 15:53:24')
        );
        SetupKyc::insert($setup_kycs);
    }
}
