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
        Schema::create('nanny_kyc_data', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("nanny_id");
            $table->text("data", 5000);
            $table->text("reject_reason", 2000)->nullable();
            $table->timestamps();

            $table->foreign("nanny_id")->references("id")->on("nannies")->onDelete("cascade")->onUpdate("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('nanny_kyc_data');
    }
};
