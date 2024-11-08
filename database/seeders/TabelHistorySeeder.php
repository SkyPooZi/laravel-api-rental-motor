<?php

namespace Database\Seeders;

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
            'pengguna_id' => 2,
            'nama_lengkap' => 'A',
            'email' => 'a@gmail.com',
            'nomor_hp' => '+62',
            'akun_sosmed' => 'a ig, fb, yt',
            'alamat' => 'Kudus',
            'penyewa' => 'Diri Sendiri',
            'motor_id' => 2,
            'tanggal_mulai' => '2024-07-25 10:50:00',
            'durasi' => 124,
            'tanggal_selesai' => '2024-07-30 15:00:00',
            'keperluan_menyewa' => 'Jalan-Jalan ke Rahtawu',
            'penerimaan_motor' => 'Diambil',
            'nama_kontak_darurat' => 'ab',
            'nomor_kontak_darurat' => '+62',
            'hubungan_dengan_kontak_darurat' => 'Saudara',
            'diskon_id' => 1,
            'metode_pembayaran' => 'Non-Tunai',
            'total_pembayaran' => '700000',
            'status_history' => 'Menunggu Pembayaran',
            'ulasan_id' => null,
            'tanggal_pembatalan' => null,
            'alasan_pembatalan' => null,
        ]);

        History::create([
            'pengguna_id' => 3,
            'nama_lengkap' => 'B',
            'email' => 'b@gmail.com',
            'nomor_hp' => '+62',
            'akun_sosmed' => 'b ig, fb, yt',
            'alamat' => 'Kudus',
            'penyewa' => 'Orang Lain',
            'motor_id' => 5,
            'tanggal_mulai' => '2024-06-25 7:00:00',
            'durasi' => 136,
            'tanggal_selesai' => '2024-07-01 15:30:00',
            'keperluan_menyewa' => 'Jalan-Jalan ke Muria',
            'penerimaan_motor' => 'Diantar',
            'nama_kontak_darurat' => 'bb',
            'nomor_kontak_darurat' => '+62',
            'hubungan_dengan_kontak_darurat' => 'Saudara',
            'diskon_id' => 2,
            'metode_pembayaran' => 'Non-Tunai',
            'total_pembayaran' => '840000',
            'status_history' => 'Dipesan',
            'ulasan_id' => 1,
            'tanggal_pembatalan' => null,
            'alasan_pembatalan' => null,
        ]);

        History::create([
            'pengguna_id' => 4,
            'nama_lengkap' => 'C',
            'email' => 'c@gmail.com',
            'nomor_hp' => '+62',
            'akun_sosmed' => 'c ig, fb, yt',
            'alamat' => 'Kudus',
            'penyewa' => 'Diri Sendiri',
            'motor_id' => 12,
            'tanggal_mulai' => '2024-01-15 09:00:00',
            'durasi' => 177,
            'tanggal_selesai' => '2024-02-22 18:00:00',
            'keperluan_menyewa' => 'Jalan-Jalan ke Museum Jenang',
            'penerimaan_motor' => 'Diambil',
            'nama_kontak_darurat' => 'cb',
            'nomor_kontak_darurat' => '+62',
            'hubungan_dengan_kontak_darurat' => 'Saudara',
            'diskon_id' => null,
            'metode_pembayaran' => 'Tunai',
            'total_pembayaran' => '1200000',
            'status_history' => 'Menunggu Pembayaran',
            'ulasan_id' => null,
            'tanggal_pembatalan' => '2024-06-20',
            'alasan_pembatalan' => 'Ada Kendala Darurat',
        ]);

        History::create([
            'pengguna_id' => 2,
            'nama_lengkap' => 'A',
            'email' => 'a@gmail.com',
            'nomor_hp' => '+62',
            'akun_sosmed' => 'a ig, fb, yt',
            'alamat' => 'Kudus',
            'penyewa' => 'Diri Sendiri',
            'motor_id' => 2,
            'tanggal_mulai' => '2024-09-04 09:00:00',
            'durasi' => 24,
            'tanggal_selesai' => '2024-09-05 09:00:00',
            'keperluan_menyewa' => 'Jalan-Jalan ke Rahtawu',
            'penerimaan_motor' => 'Diambil',
            'nama_kontak_darurat' => 'ab',
            'nomor_kontak_darurat' => '+62',
            'hubungan_dengan_kontak_darurat' => 'Saudara',
            'diskon_id' => null,
            'metode_pembayaran' => 'Non-Tunai',
            'total_pembayaran' => '700000',
            'status_history' => 'Sedang Digunakan',
            'ulasan_id' => null,
            'tanggal_pembatalan' => null,
            'alasan_pembatalan' => null,
        ]);

        History::create([
            'pengguna_id' => 2,
            'nama_lengkap' => 'A',
            'email' => 'a@gmail.com',
            'nomor_hp' => '+62',
            'akun_sosmed' => 'a ig, fb, yt',
            'alamat' => 'Kudus',
            'penyewa' => 'Diri Sendiri',
            'motor_id' => 2,
            'tanggal_mulai' => '2024-09-03 07:00:00',
            'durasi' => 24,
            'tanggal_selesai' => '2024-09-04 07:00:00',
            'keperluan_menyewa' => 'Jalan-Jalan ke Rahtawu',
            'penerimaan_motor' => 'Diambil',
            'nama_kontak_darurat' => 'ab',
            'nomor_kontak_darurat' => '+62',
            'hubungan_dengan_kontak_darurat' => 'Saudara',
            'diskon_id' => null,
            'metode_pembayaran' => 'Non-Tunai',
            'total_pembayaran' => '700000',
            'status_history' => 'Selesai',
            'ulasan_id' => null,
            'tanggal_pembatalan' => null,
            'alasan_pembatalan' => null,
        ]);
    }
}
