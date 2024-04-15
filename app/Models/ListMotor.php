<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListMotor extends Model
{
    use HasFactory;

    protected $table = 'list_motors';

    protected $fillable = [
        'tipe_motor',
        'merk_motor',
        'nama_motor',
        'stok_motor',
        'status_motor',
        'harga_motor_per_1_hari',
        'harga_motor_per_1_minggu',
    ];
}
