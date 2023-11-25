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
        Schema::create('start_driver', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id');
            $table->foreignId('driver_id');
            $table->char('from_zip_code', 9);
            $table->char('to_zip_code', 9);
            $table->boolean('distance_client', 255);
            $table->char('running', 1)->default(0);
            $table->char('finished', 1)->default(0);
            $table->softDeletes();
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('start_driver', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
};
