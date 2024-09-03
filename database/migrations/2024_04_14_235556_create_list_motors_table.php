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
        Schema::create('list_motors', function (Blueprint $table) {
            $table->id();
            $table->string('gambar_motor');
            $table->string('nama_motor');
            $table->string('tipe_motor');
            $table->string('merk_motor');
            $table->integer('stok_motor');
            $table->integer('harga_motor_per_1_hari');
            $table->integer('harga_motor_per_1_minggu');
            $table->string('status_motor');
            $table->datetime('tanggal_mulai_tidak_tersedia')->nullable();
            $table->datetime('tanggal_selesai_tidak_tersedia')->nullable();
            $table->boolean('is_hidden')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('list_motors');
    }
};
