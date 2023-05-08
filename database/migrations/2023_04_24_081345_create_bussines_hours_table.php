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
        Schema::create('bussines_hours', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('doctorclinic_id');
            $table->string('day');
            $table->time('from');
            $table->time('to');
            $table->unsignedInteger('step')->default(60);
            $table->boolean('off')->default(false);
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
        Schema::dropIfExists('bussines_hours');
    }
};
