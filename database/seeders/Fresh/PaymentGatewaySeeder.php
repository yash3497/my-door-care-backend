<?php

namespace Database\Seeders\Fresh;

use App\Models\Admin\PaymentGateway;
use App\Models\Admin\PaymentGatewayCurrency;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaymentGatewaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $payment_gateways = array(
            array('id' => '1', 'slug' => 'money-out', 'code' => '105', 'type' => 'MANUAL', 'name' => 'bKash', 'title' => 'bKash Gateway', 'alias' => 'bkash', 'image' => 'c00c38a3-a0bd-437a-b346-cc5d4ac4d3ba.webp', 'credentials' => NULL, 'supported_currencies' => '["BDT"]', 'crypto' => '0', 'desc' => '<p>tttt</p>', 'input_fields' => '[{"type":"text","label":"Bank AC","name":"bank_ac","required":true,"validation":{"max":"30","mimes":[],"min":"0","options":[],"required":true}}]', 'status' => '1', 'last_edit_by' => '1', 'created_at' => NULL, 'updated_at' => '2023-06-23 14:31:39'),
            array('id' => '5', 'slug' => 'add-money', 'code' => '120', 'type' => 'AUTOMATIC', 'name' => 'Paypal', 'title' => 'Global Setting for paypal in bellow', 'alias' => 'paypal', 'image' => 'da2f51be-ce7f-4294-b612-11bfd240acbb.webp', 'credentials' => '[{"label":"Client ID","placeholder":"Enter Client ID","name":"client-id","value":""},{"label":"Secret Key","placeholder":"Enter Secret Key","name":"secret-key","value":""}]', 'supported_currencies' => '["USD"]', 'crypto' => '0', 'desc' => NULL, 'input_fields' => NULL, 'status' => '1', 'last_edit_by' => '1', 'created_at' => '2023-06-04 05:49:14', 'updated_at' => '2023-06-05 00:26:53'),
            array('id' => '8', 'slug' => 'sell-coin', 'code' => '125', 'type' => 'MANUAL', 'name' => 'PayPal', 'title' => 'PayPal Gateway', 'alias' => 'paypal', 'image' => 'a8454ad4-97d5-41b4-b011-07f89fe23c05.webp', 'credentials' => NULL, 'supported_currencies' => '["USD"]', 'crypto' => '0', 'desc' => '<p>Please confirm your withdraw coin to our PayPal account. Our PayPal account: paypal@appdevs.net&nbsp;<br>If you have sell coin the click <strong>Proceed</strong> &amp; if you haven\'t sell coin then click <strong>Cancel</strong> button.</p><p style="margin-left:-5px;"><br>&nbsp;</p>', 'input_fields' => '[{"type":"text","label":"Bank AC","name":"bank_ac","required":true,"validation":{"max":"30","mimes":[],"min":"0","options":[],"required":true}},{"type":"file","label":"image","name":"image","required":true,"validation":{"max":"10","mimes":["jpg","png"],"min":0,"options":[],"required":true}},{"type":"text","label":"Tiktok Order ID","name":"tiktok_order_id","required":true,"validation":{"max":"30","mimes":[],"min":"0","options":[],"required":true}}]', 'status' => '1', 'last_edit_by' => '1', 'created_at' => NULL, 'updated_at' => '2023-06-23 14:33:46'),
            array('id' => '13', 'slug' => 'money-out', 'code' => '130', 'type' => 'MANUAL', 'name' => 'DBBL', 'title' => 'DBBL Gateway', 'alias' => 'dbbl', 'image' => 'a2421db6-1a0b-45e9-81e9-7ac0c7b50af0.webp', 'credentials' => NULL, 'supported_currencies' => '["BDT"]', 'crypto' => '0', 'desc' => '<p>Instruction here</p>', 'input_fields' => '[{"type":"text","label":"Transaction ID","name":"transaction_id","required":true,"validation":{"max":"30","mimes":[],"min":"0","options":[],"required":true}}]', 'status' => '1', 'last_edit_by' => '1', 'created_at' => NULL, 'updated_at' => '2023-06-23 14:32:20'),
            array('id' => '14', 'slug' => 'add-money', 'code' => '135', 'type' => 'MANUAL', 'name' => 'AdPay', 'title' => 'AdPay Gateway', 'alias' => 'adpay', 'image' => 'e31f9c77-502b-43d8-b6f0-1ac088291402.webp', 'credentials' => NULL, 'supported_currencies' => '["USD"]', 'crypto' => '0', 'desc' => NULL, 'input_fields' => '[{"type":"text","label":"Transaction ID","name":"transaction_id","required":true,"validation":{"max":"30","mimes":[],"min":"0","options":[],"required":true}}]', 'status' => '1', 'last_edit_by' => '1', 'created_at' => NULL, 'updated_at' => '2023-06-23 14:29:47'),
            array('id' => '15', 'slug' => 'add-money', 'code' => '140', 'type' => 'AUTOMATIC', 'name' => 'Stripe', 'title' => 'Stripe Gateway', 'alias' => 'stripe', 'image' => '8c8b6841-9e18-45e9-ad24-326e9e6251a6.webp', 'credentials' => '[{"label":"Publishable Key","placeholder":"Enter Publishable Key","name":"publishable-key","value":""},{"label":"Secret Key","placeholder":"Enter Secret Key","name":"secret-key","value":""}]', 'supported_currencies' => '["USD"]', 'crypto' => '0', 'desc' => NULL, 'input_fields' => NULL, 'status' => '1', 'last_edit_by' => '1', 'created_at' => '2023-06-23 14:47:35', 'updated_at' => '2023-06-23 14:49:17')
        );

        PaymentGateway::insert($payment_gateways);

        $payment_gateway_currencies = array(
            array('id' => '1', 'payment_gateway_id' => '1', 'name' => 'bKash BDT', 'alias' => 'bkash-bdt-manual', 'currency_code' => 'BDT', 'currency_symbol' => '৳', 'image' => NULL, 'min_limit' => '0.00000000', 'max_limit' => '1000.00000000', 'percent_charge' => '2.00000000', 'fixed_charge' => '1.00000000', 'rate' => '107.89000000', 'created_at' => '2023-05-22 23:22:14', 'updated_at' => '2023-06-13 05:36:25'),
            array('id' => '5', 'payment_gateway_id' => '5', 'name' => 'Paypal USD', 'alias' => 'paypal-usd-automatic', 'currency_code' => 'USD', 'currency_symbol' => NULL, 'image' => '7fe824cd-c9ac-48c4-b907-efefa599f092.webp', 'min_limit' => '0.00000000', 'max_limit' => '1000.00000000', 'percent_charge' => '2.00000000', 'fixed_charge' => '1.00000000', 'rate' => '1.00000000', 'created_at' => '2023-06-04 05:49:36', 'updated_at' => '2023-06-13 05:37:03'),
            array('id' => '19', 'payment_gateway_id' => '8', 'name' => 'PayPal USD', 'alias' => 'paypal-usd-manual', 'currency_code' => 'USD', 'currency_symbol' => '$', 'image' => NULL, 'min_limit' => '0.00000000', 'max_limit' => '15000.00000000', 'percent_charge' => '2.00000000', 'fixed_charge' => '1.00000000', 'rate' => '1.00000000', 'created_at' => '2023-06-06 05:24:34', 'updated_at' => '2023-06-23 14:46:01'),
            array('id' => '25', 'payment_gateway_id' => '13', 'name' => 'DBBL BDT', 'alias' => 'dbbl-bdt-manual', 'currency_code' => 'BDT', 'currency_symbol' => '৳', 'image' => NULL, 'min_limit' => '0.00000000', 'max_limit' => '1000.00000000', 'percent_charge' => '4.00000000', 'fixed_charge' => '1.00000000', 'rate' => '100.00000000', 'created_at' => '2023-06-13 06:28:05', 'updated_at' => '2023-06-13 06:28:05'),
            array('id' => '26', 'payment_gateway_id' => '14', 'name' => 'AdPay USD', 'alias' => 'adpay-usd-manual', 'currency_code' => 'USD', 'currency_symbol' => '$', 'image' => NULL, 'min_limit' => '0.00000000', 'max_limit' => '50000.00000000', 'percent_charge' => '0.00000000', 'fixed_charge' => '1.00000000', 'rate' => '1.00000000', 'created_at' => '2023-06-16 23:35:31', 'updated_at' => '2023-06-16 23:35:31'),
            array('id' => '31', 'payment_gateway_id' => '15', 'name' => 'Stripe USD', 'alias' => 'stripe-usd-automatic', 'currency_code' => 'USD', 'currency_symbol' => '$', 'image' => NULL, 'min_limit' => '1.00000000', 'max_limit' => '1000.00000000', 'percent_charge' => '0.00000000', 'fixed_charge' => '0.00000000', 'rate' => '1.00000000', 'created_at' => '2023-06-23 14:50:35', 'updated_at' => '2023-06-23 14:50:35')
        );

        PaymentGatewayCurrency::insert($payment_gateway_currencies);
    }
}
