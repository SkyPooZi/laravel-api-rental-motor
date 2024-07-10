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
            $table->string('nama_lengkap');
            $table->string('email');
            $table->string('no_telp', 20);
            $table->string('akun_sosmed');
            $table->text('alamat');
            $table->string('penyewa');
            $table->foreignId('motor_id');
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->string('keperluan_menyewa');
            $table->string('penerimaan_motor');
            $table->string('nama_kontak_darurat');
            $table->string('nomor_kontak_darurat', 20);
            $table->string('hubungan_dengan_kontak_darurat');
            $table->foreignId('diskon_id');
            $table->string('metode_pembayaran');
            $table->integer('total_pembayaran');
            $table->string('status_history');
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
