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
        Schema::create('midtrans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('history_id');
            $table->integer('no_pemesanan');
            $table->date('tanggal_pemesanan');
            $table->date('tanggal_pembayaran');
            $table->string('metode_pembayaran');
            $table->string('status_pembayaran');
            $table->integer('total_pemesanan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('midtrans');
    }
};
