<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Diskon extends Model
{
    use HasFactory;

    protected $table = 'diskons';
    
    protected $fillable = [
        'gambar',
        'kode_diskon',
        'nama_diskon',
        'potongan_harga',
        'tanggal_mulai',
        'tanggal_selesai',
        'is_hidden',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($diskon) {
            $diskon->kode_diskon = self::generateRandomCode();
        });
    }

    public static function generateRandomCode()
    {
        $letters = '';
        for ($i = 0; $i < 5; $i++) {
            $letters .= chr(rand(65, 90));
        }

        $numbers = rand(100, 999);

        return $letters . $numbers;
    }
}
