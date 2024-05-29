<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(TabelUserSeeder::class);
        $this->call(TabelListMotorSeeder::class);
        $this->call(TabelDiskonSeeder::class);
        $this->call(TabelHistorySeeder::class);
        $this->call(TabelReviewSeeder::class);
        $this->call(TabelNotificationSeeder::class);
    }
}
