<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    use HasFactory;

    protected $table = 'histories';

    protected $fillable = [
        'nama_lengkap',
        'email',
        'no_telp',
        'akun_sosmed',
        'alamat',
        'penyewa',
        'motor_id',
        'tanggal_mulai',
        'tanggal_selesai',
        'keperluan_menyewa',
        'penerimaan_motor',
        'nama_kontak_darurat',
        'nomor_kontak_darurat',
        'hubungan_dengan_kontak_darurat',
        'diskon_id',
        'metode_pembayaran',
        'total_pembayaran',
        'status_history',
    ];

    public function listMotor() {
        return $this->belongsTo(ListMotor::class, 'motor_id');
    }

    public function diskon() {
        return $this->belongsTo(Diskon::class, 'diskon_id');
    }
}
