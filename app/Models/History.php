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
        'nama_lengkap',
        'email',
        'nomor_hp',
        'akun_sosmed',
        'alamat',
        'penyewa',
        'motor_id',
        'tanggal_mulai',
        'durasi',
        'tanggal_selesai',
        'keperluan_menyewa',
        'penerimaan_motor',
        'nama_kontak_darurat',
        'nomor_kontak_darurat',
        'hubungan_dengan_kontak_darurat',
        'point',
        'diskon_id',
        'metode_pembayaran',
        'total_pembayaran',
        'status_history',
        'ulasan_id',
        'tanggal_pembatalan',
        'alasan_pembatalan',
    ];

    public function user() {
        return $this->belongsTo(User::class, 'pengguna_id');
    }

    public function listMotor() {
        return $this->belongsTo(ListMotor::class, 'motor_id');
    }

    public function diskon() {
        return $this->belongsTo(Diskon::class, 'diskon_id');
    }

    public function ulasan() {
        return $this->belongsTo(UserReview::class, 'ulasan_id');
    }
}
