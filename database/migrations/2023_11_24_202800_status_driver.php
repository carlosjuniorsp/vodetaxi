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
            $table->text('active')->default(1);
            $table->text('in_running', 1);
            $table->text('distance', 255);
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
