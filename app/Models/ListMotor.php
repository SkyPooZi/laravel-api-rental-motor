<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListMotor extends Model
{
    use HasFactory;

    protected $table = 'list_motors';

    protected $fillable = [
        'gambar_motor',
        'nama_motor',
        'tipe_motor',
        'merk_motor',
        'stok_motor',
        'harga_motor_per_1_hari',
        'harga_motor_per_1_minggu',
        'status_motor',
        'tanggal_mulai_tidak_tersedia',
        'tanggal_selesai_tidak_tersedia',
    ];
}
