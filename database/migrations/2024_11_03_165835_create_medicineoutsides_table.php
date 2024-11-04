<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('medicineoutsides', function (Blueprint $table) {
             $table->id();

             $table->unsignedBigInteger('admin_id');
             $table->foreign('admin_id')->references('id')->on('users');

             $table->unsignedBigInteger('appointment_id');
             $table->foreign('appointment_id')->references('id')->on('appointments');
 
             $table->unsignedBigInteger('member_id');
             $table->foreign('member_id')->references('id')->on('members');

             $table->string('medicine_name');
             $table->string('total_day');
             $table->string('eating_time');
             $table->string('eating_status');
             
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
             
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medicineoutsides');
    }
};
