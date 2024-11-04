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
        Schema::create('appointments', function (Blueprint $table) {

            $table->id(); 

            $table->unsignedBigInteger('admin_id');
            $table->foreign('admin_id')->references('id')->on('users');

            $table->unsignedBigInteger('chamber_id');
            $table->foreign('chamber_id')->references('id')->on('chambers');

            $table->unsignedBigInteger('member_id');
            $table->foreign('member_id')->references('id')->on('members');
            
            
            $table->string('age');
            $table->string('advice')->nullable(); 
            $table->string('disease_problem')->nullable(); 

            $table->integer('appointment_status')->nullable(); 

            $table->date('date');
            $table->integer('year');
            $table->integer('month');
            $table->integer('day');
            $table->string('image')->nullable(); 
            $table->integer('payment_amount');

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
        Schema::dropIfExists('appointments');
    }
};
