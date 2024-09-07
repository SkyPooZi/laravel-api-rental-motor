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
        Schema::create('keuangans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('history_id');
            $table->integer('total_harga_motor');
            $table->integer('total_biaya_overtime')->default(0);
            $table->integer('total_biaya_diantar')->default(0);
            $table->integer('total_potongan_point')->default(0);
            $table->integer('total_biaya_diskon');
            $table->integer('total_biaya_admin');
            $table->integer('total_biaya_reschedule')->nullable();
            $table->integer('total_pembayaran');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('keuangans');
    }
};
