<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Notification;
use Illuminate\Database\Seeder;

class TabelNotificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Notification::create([
            'pengguna_id' => 2,
            'pesan' => 'A ingin menyewa motor NMAX, apakah anda menyetujui pemintaan ini? '
        ]);

        Notification::create([
            'pengguna_id' => 3,
            'pesan' => 'B ingin menyewa motor PCX, apakah anda menyetujui pemintaan ini? '
        ]);

        Notification::create([
            'pengguna_id' => 4,
            'pesan' => 'C ingin menyewa motor Vario 160, apakah anda menyetujui pemintaan ini? '
        ]);

        Notification::create([
            'pengguna_id' => 5,
            'pesan' => 'D ingin menyewa motor Vario 150, apakah anda menyetujui pemintaan ini? '
        ]);

        Notification::create([
            'pengguna_id' => 6,
            'pesan' => 'E ingin menyewa motor XSR, apakah anda menyetujui pemintaan ini? '
        ]);
    }
}
