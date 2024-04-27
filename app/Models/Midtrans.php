<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Midtrans extends Model
{
    use HasFactory;

    protected $table = 'midtrans';

    protected $fillable = [
        'no_pemesanan',
        'tanggal_pemesanan',
        'pengguna_id',
        'tanggal_pembayaran',
        'metode_pembayaran',
        'total_pembayaran_midtrans',
        'motor_id',
        'diskon_id',
        'history_id',
    ];
}
