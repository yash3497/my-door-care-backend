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
        Schema::create('nanny_notifications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("nanny_id");
            $table->string("type", 100)->nullable();
            $table->text('message', 1000);
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
        Schema::dropIfExists('nanny_notifications');
    }
};
