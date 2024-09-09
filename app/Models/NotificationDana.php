<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationDana extends Model
{
    use HasFactory;

    protected $table = 'notification_danas';
    
    protected $fillable = [
        'pengguna_id',
        'riwayat_id',
        'pesan',
        'datetime',
        'is_hidden',
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

    public function riwayatData() {
        return $this->belongsTo(RiwayatData::class, 'riwayat_id');
    }
}
