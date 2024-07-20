<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Midtrans extends Model
{
    use HasFactory;

    protected $table = 'midtrans';

    protected $fillable = [
        'history_id',
        'no_pemesanan',
        'tanggal_pemesanan',
        'tanggal_pembayaran',
        'metode_pembayaran',
        'status_pembayaran',
        'total_pemesanan',
    ];

    public function user() {
        return $this->belongsTo(User::class, 'pengguna_id');
    }

    public function history() {
        return $this->belongsTo(History::class, 'history_id');
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
