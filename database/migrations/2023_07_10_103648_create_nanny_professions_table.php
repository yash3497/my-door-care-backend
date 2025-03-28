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
        Schema::create('nanny_professions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('nanny_id')->constrained('nannies')->onDelete('cascade');
            $table->integer('profession_type')->comment('1=Baby Sitter,2=Pet Sitter');
            $table->text('profession_type_details');
            $table->string('work_experience');
            $table->string('work_capability');
            $table->string('service_area');
            $table->string('charge');
            $table->decimal('amount', 16, 4);
            $table->text('bio');
            $table->integer('status')->default(1);
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
        Schema::dropIfExists('nanny_professions');
    }
};
