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
        Schema::create('user_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('nanny_id')->constrained('nannies')->cascadeOnDelete();
            $table->foreignId('add_baby_pet_id')->constrained('add_baby_pats')->cascadeOnDelete();
            $table->date('started_date');
            $table->date('end_date');
            $table->integer('service_type')->comment('1:baby setter, 2:pet setter');
            $table->integer('service_day');
            $table->integer('daily_working_hour');
            $table->integer('total_hour');
            $table->integer('nanny_charge');
            $table->time('started_time');
            $table->integer('total');
            $table->decimal('service_charge')->nullable();
            $table->decimal('payable');
            $table->string('currency_code');
            $table->string('trx');
            $table->string('address');
            $table->integer('status')->default(0)->comment('0:Pending,1:Accept,2:Reject,4:task complete,5:payment,6:review');
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
        Schema::dropIfExists('user_requests');
    }
};
