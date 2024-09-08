<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Keuangan extends Model
{
    use HasFactory;

    protected $table = 'keuangans';

    protected $fillable = [
        'history_id',
        'total_harga_motor',
        'total_biaya_overtime',
        'total_biaya_diantar',
        'total_potongan_point',
        'total_biaya_diskon',
        'total_biaya_admin',
        'total_biaya_reschedule',
        'total_pembayaran',
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
