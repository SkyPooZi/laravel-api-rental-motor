<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatData extends Model
{
    use HasFactory;

    protected $table = 'riwayat_data';

    protected $fillable = [
        'pengguna_id',
        'motor_id',
        'history_id',
        'data_sebelum',
        'data_sesudah',
        'datetime',
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
