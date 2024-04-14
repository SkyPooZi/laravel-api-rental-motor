<?php

namespace Database\Seeders;

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
            'user_foreign_key' => 'digarap zidan',
            'rating' => 4.5,
            'komentar' => 'Webnya bagus sekali, mempermudah saya dalam menyewa motor!'
        ]);

        UserReview::create([
            'user_foreign_key' => 'digarap zidan',
            'rating' => 3.5,
            'komentar' => 'Cukup mempermudah pengguna yang ingin menyewa motor, tetapi masih ada beberapa fitur yang perlu diperbaiki.'
        ]);
    }
}
