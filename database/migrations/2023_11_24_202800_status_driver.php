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
        Schema::create('status_driver', function (Blueprint $table) {
            $table->id();
            $table->foreignId('driver_id')->constrained('driver');
            $table->char('zip_code', 9);
            $table->boolean('active');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('status_driver', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
};
