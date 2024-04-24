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
        Schema::create('histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengguna_id');
            $table->string('akun_sosmed');
            $table->string('penyewa');
            $table->foreignId('motor_id');
            $table->string('tanggal_booking');
            $table->string('keperluan_menyewa');
            $table->string('penerimaan_motor');
            $table->string('nama_kontak_darurat');
            $table->string('nomor_kontak_darurat', 20);
            $table->string('hubungan_dengan_kontak_darurat');
            $table->foreignId('diskon_id');
            $table->string('metode_pembayaran');
            $table->integer('total_pembayaran');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('histories');
    }
};
