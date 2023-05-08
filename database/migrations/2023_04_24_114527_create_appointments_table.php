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
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('doctorclinic_id');

            $table->date('date');
            $table->time('time');
            $table->foreign('user_id')->references('id')->on('users')
                ->onDelete('cascade');
                $table->foreign('doctorclinic_id')
                ->references('id')
                ->on('doctorclinics')
                ->onDelete('cascade');
            $table->timestamps();
            $table->index('doctorclinic_id');
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
