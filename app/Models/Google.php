<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Google extends Model
{
    use HasFactory;

    protected $table = 'googles';

    protected $fillable = [
        'access_token',
        'pengguna_id',
        'tanggal_masuk',
    ];

    public function user() {
        return $this->belongsTo(User::class, 'pengguna_id');
    }
}
