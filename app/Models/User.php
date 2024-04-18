<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory;

    protected $table = 'users';

    protected $fillable = [
        'nama_pengguna',
        'email',
        'password',
        'gambar',
        'nama_lengkap',
        'nomor_hp',
        'alamat',
        'role',
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
