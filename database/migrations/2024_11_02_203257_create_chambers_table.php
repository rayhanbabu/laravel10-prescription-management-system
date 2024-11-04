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
        Schema::create('chambers', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('admin_id');
            $table->foreign('admin_id')->references('id')->on('users');

            $table->string('chamber_name');
            $table->string('chamber_address');
            $table->string('chamber_phone');
            $table->string('image')->nullable();
            $table->string('image1')->nullable();
            $table->string('chamber_status')->default(1);
          
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chambers');
    }
};
