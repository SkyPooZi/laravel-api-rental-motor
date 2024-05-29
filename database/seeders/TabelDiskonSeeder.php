<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Diskon;
use Illuminate\Database\Seeder;

class TabelDiskonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       Diskon::create([
            'gambar' => 'images/diskon_awal_tahun.jpg',
            'nama_diskon' => 'Diskon Awal Tahun',
            'potongan_harga' => 10,
            'tanggal_mulai' => '2024-01-01',
            'tanggal_selesai' => '2024-01-31',
        ]);

        Diskon::create([
            'gambar' => 'images/diskon_idul_fitri.jpg',
            'nama_diskon' => 'Diskon Hari Raya Idul Fitri',
            'potongan_harga' => 15,
            'tanggal_mulai' => '2024-06-01',
            'tanggal_selesai' => '2024-06-30',
        ]);

        Diskon::create([
            'gambar' => 'images/diskon_akhir_tahun.jpg',
            'nama_diskon' => 'Diskon Akhir Tahun',
            'potongan_harga' => 20,
            'tanggal_mulai' => '2024-12-01',
            'tanggal_selesai' => '2024-12-31',
        ]);
    }
}
