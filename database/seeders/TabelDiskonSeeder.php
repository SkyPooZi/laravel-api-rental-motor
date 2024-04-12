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
            'kode_diskon' => 'ABC123',
            'nama_diskon' => 'Diskon Awal Tahun',
            'persentase_diskon' => 10,
            'tanggal_mulai' => '2024-01-01',
            'tanggal_berakhir' => '2024-01-31'
        ]);

        Diskon::create([
            'kode_diskon' => 'DEF456',
            'nama_diskon' => 'Diskon Akhir Tahun',
            'persentase_diskon' => 20,
            'tanggal_mulai' => '2024-12-01',
            'tanggal_berakhir' => '2024-12-31'
        ]);
    }
}
