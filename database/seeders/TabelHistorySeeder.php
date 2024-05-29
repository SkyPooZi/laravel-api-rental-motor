<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\History;
use Illuminate\Database\Seeder;

class TabelHistorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        History::create([
            'nama_lengkap' => 'A',
            'email' => 'a@gmail.com',
            'no_telp' => '+62',
            'akun_sosmed' => 'a ig, fb, yt',
            'alamat' => 'Kudus',
            'penyewa' => 'Diri Sendiri',
            'motor_id' => 2,
            'tanggal_booking' => 2024-05-25-2024-05-30,
            'keperluan_menyewa' => 'Jalan-Jalan ke Rahtawu',
            'penerimaan_motor' => 'Diambil',
            'nama_kontak_darurat' => 'ab',
            'nomor_kontak_darurat' => '+62',
            'hubungan_dengan_kontak_darurat' => 'Saudara',
            'diskon_id' => 1,
            'metode_pembayaran' => 'Cashless',
            'total_pembayaran' => '700000',
            'status_history' => 'Menunggu Pembayaran',
        ]);

        History::create([
            'nama_lengkap' => 'B',
            'email' => 'b@gmail.com',
            'no_telp' => '+62',
            'akun_sosmed' => 'b ig, fb, yt',
            'alamat' => 'Kudus',
            'penyewa' => 'Orang Lain',
            'motor_id' => 5,
            'tanggal_booking' => 2024-06-25-2024-07-01,
            'keperluan_menyewa' => 'Jalan-Jalan ke Muria',
            'penerimaan_motor' => 'Diantar',
            'nama_kontak_darurat' => 'bb',
            'nomor_kontak_darurat' => '+62',
            'hubungan_dengan_kontak_darurat' => 'Saudara',
            'diskon_id' => 2,
            'metode_pembayaran' => 'Cashless',
            'total_pembayaran' => '840000',
            'status_history' => 'Menunggu Pembayaran',
        ]);

        History::create([
            'nama_lengkap' => 'C',
            'email' => 'c@gmail.com',
            'no_telp' => '+62',
            'akun_sosmed' => 'c ig, fb, yt',
            'alamat' => 'Kudus',
            'penyewa' => 'Diri Sendiri',
            'motor_id' => 12,
            'tanggal_booking' => 2024-06-15-2024-06-22,
            'keperluan_menyewa' => 'Jalan-Jalan ke Museum Jenang',
            'penerimaan_motor' => 'Diambil',
            'nama_kontak_darurat' => 'cb',
            'nomor_kontak_darurat' => '+62',
            'hubungan_dengan_kontak_darurat' => 'Saudara',
            'diskon_id' => 3,
            'metode_pembayaran' => 'Tunai',
            'total_pembayaran' => '1200000',
            'status_history' => 'Menunggu Pembayaran',
        ]);
    }
}
