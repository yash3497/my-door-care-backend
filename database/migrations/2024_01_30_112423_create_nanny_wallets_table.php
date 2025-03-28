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
        Schema::create('nanny_wallets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('nanny_id');
            $table->unsignedBigInteger('currency_id');
            $table->decimal('balance', 28, 8);
            $table->boolean('status')->default(true);
            $table->foreign("currency_id")->references("id")->on("currencies")->onDelete("cascade")->onUpdate("cascade");
            $table->foreign("nanny_id")->references("id")->on("nannies")->onDelete("cascade")->onUpdate("cascade");
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
        Schema::dropIfExists('nanny_wallets');
    }
};
