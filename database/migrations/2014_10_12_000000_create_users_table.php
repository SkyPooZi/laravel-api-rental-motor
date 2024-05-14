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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('gambar')->nullable();
            $table->string('nama_pengguna');
            $table->string('nama_lengkap')->nullable();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('nomor_hp', 20)->nullable();
            $table->text('alamat')->nullable();
            $table->string('peran')->default('user');
            $table->string('kode', 5)->unique();
            $table->integer('point')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
