<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    use HasFactory;

    protected $table = 'histories';

    protected $fillable = [
        'pengguna_id',
        'akun_sosmed',
        'penyewa',
        'motor_id',
        'tanggal_booking',
        'keperluan_menyewa',
        'penerimaan_motor',
        'nama_kontak_darurat',
        'nomor_kontak_darurat',
        'hubungan_dengan_kontak_darurat',
        'diskon_id',
        'metode_pembayaran',
        'total_pembayaran',
    ];
    
    public function user() {
        return $this->belongsTo(User::class);
    }

    public function listMotor() {
        return $this->belongsTo(ListMotor::class);
    }
}
