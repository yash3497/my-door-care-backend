<?php

namespace Database\Seeders\Admin;

use App\Models\Admin\Currency;
use Illuminate\Database\Seeder;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            'admin_id'  => 1,
            'flag' => 'accee254-fefb-4a1f-89fa-ad087ed2889b.webp',
            'country'   => "United States",
            'name'      => "United States dollar",
            'code'      => "USD",
            'symbol'    => "$",
            'type'      => "FIAT",
            'sender'    => true,
            'receiver'  => true,
            'default'   => true,
            'status'    => true,
        ];

        Currency::firstOrCreate($data);
    }
}
