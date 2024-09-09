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
        Schema::create('notification_danas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengguna_id')->nullable();
            $table->foreignId('riwayat_id')->nullable();
            $table->string('pesan');
            $table->datetime('datetime');
            $table->boolean('is_hidden')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notification_danas');
    }
};
