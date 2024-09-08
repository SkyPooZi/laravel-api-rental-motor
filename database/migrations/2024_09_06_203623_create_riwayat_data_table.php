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
        Schema::create('riwayat_data', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengguna_id')->nullable();
            $table->foreignId('history_id')->nullable();
            $table->text('data_sebelum');
            $table->text('data_sesudah');
            $table->datetime('datetime');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('riwayat_data');
    }
};
