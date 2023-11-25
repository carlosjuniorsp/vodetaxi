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
        Schema::create('start_racer', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained('client');
            $table->char('from_zip_code', 7);
            $table->boolean('to_zip_code', 7);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('start_racer', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
};
