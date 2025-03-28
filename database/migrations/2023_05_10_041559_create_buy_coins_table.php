<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('buy_coins', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('trx_id');
            $table->string('login_vender');
            $table->string('username_or_email');
            $table->string('password');
            $table->string('coin');
            $table->string('price');
            $table->string('charge');
            $table->string('total_amount');
            $table->tinyInteger('status')->default(1)->comment("1:Pending, 2:Success, 3:Reject, 4:Hold");
            $table->longText('reject_reason')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('buy_coins');
    }
};
