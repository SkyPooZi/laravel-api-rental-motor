<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\UserReview;
use Illuminate\Database\Seeder;

class TabelReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        UserReview::create([
            'gambar' => 'images/review4.jpg',
            'pengguna_id' => 1,
            'penilaian' => 5,
            'komentar' => 'Webnya bagus sekali, mempermudah saya dalam menyewa motor!'
        ]);

        UserReview::create([
            'gambar' => 'images/review2.jpg',
            'pengguna_id' => 2,
            'penilaian' => 3,
            'komentar' => 'Cukup mempermudah pengguna yang ingin menyewa motor, tetapi masih ada beberapa fitur yang perlu diperbaiki.'
        ]);

        UserReview::create([
            'gambar' => 'images/review1.jpg',
            'pengguna_id' => 3,
            'penilaian' => 4,
            'komentar' => 'Webnya ada sedikit kendala, seperti terlalu berat untuk di jalankan di smartphone.'
        ]);

        UserReview::create([
            'gambar' => 'images/review3.jpg',
            'pengguna_id' => 4,
            'penilaian' => 5,
            'komentar' => 'Webnya Sangat Bagus dan Motornya Sangat Nyaman.'
        ]);

        UserReview::create([
            'gambar' => 'images/review5.jpg',
            'pengguna_id' => 5,
            'penilaian' => 5,
            'komentar' => 'Motornya sangat bagus dan terawat, pelayanannya sangat ramah dan jelas!'
        ]);
        
        UserReview::create([
            'gambar' => 'images/review5.jpg',
            'pengguna_id' => 6,
            'penilaian' => 5,
            'komentar' => 'Fitur yang sangat lengkap membuat saya ingin menyewa kembali!'
        ]);

        UserReview::create([
            'gambar' => 'images/review5.jpg',
            'pengguna_id' => 7,
            'penilaian' => 5,
            'komentar' => 'Pembayaran bisa menggunakan QRIS mempermudah saya dalam pemesanan.'
        ]);
    }
}
