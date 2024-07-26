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
            $table->string('nama_lengkap');
            $table->string('email');
            $table->string('no_telp', 20);
            $table->string('akun_sosmed');
            $table->text('alamat');
            $table->string('penyewa');
            $table->foreignId('motor_id');
            $table->datetime('tanggal_mulai');
            $table->integer('durasi');
            $table->datetime('tanggal_selesai');
            $table->string('keperluan_menyewa');
            $table->string('penerimaan_motor');
            $table->string('nama_kontak_darurat');
            $table->string('nomor_kontak_darurat', 20);
            $table->string('hubungan_dengan_kontak_darurat');
            $table->foreignId('diskon_id')->nullable();
            $table->string('metode_pembayaran');
            $table->integer('total_pembayaran');
            $table->string('status_history');
            $table->foreignId('ulasan_id')->nullable();
            $table->date('tanggal_pembatalan')->nullable();
            $table->string('alasan_pembatalan')->nullable();
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
