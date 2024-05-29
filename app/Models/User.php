<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, HasApiTokens, Notifiable;

    protected $table = 'users';

    protected $fillable = [
        'gambar',
        'nama_pengguna',
        'nama_lengkap',
        'email',
        'password',
        'google_id',
        'facebook_id',
        'nomor_hp',
        'alamat',
        'peran',
        'kode',
        'point',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            $user->kode = static::generateRandomCode();
            $user->point = 0;
        });
    }

    public static function generateRandomCode()
    {
        return mt_rand(10000, 99999);
    }
}
