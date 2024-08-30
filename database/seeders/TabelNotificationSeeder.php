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
            'diskon_id' => 1,
            'history_id' => null,
            'status_history' => null,
            'pesan' => "
🔥 Penawaran Spesial! Diskon 10% untuk Diskon Awal Tahun! 🔥
Diskon berlaku mulai 2024-01-01 hingga 2024-01-31.
"
        ]);

        Notification::create([
            'pengguna_id' => 3,
            'diskon_id' => 2,
            'history_id' => null,
            'status_history' => null,
            'pesan' => "
🔥 Diskon 15% untuk Diskon Hari Raya Idul Fitri! 🔥
Diskon berlaku mulai 2024-06-01 hingga 2024-06-30.
"
        ]);

        Notification::create([
            'pengguna_id' => null,
            'diskon_id' => null,
            'history_id' => 1,
            'status_history' => 'Menunggu Pembayaran',
            'pesan' => 'Halo B, Anda memiliki waktu 2 jam lagi untuk menyelesaikan pembayaran untuk pesanan Anda. Jika tidak, pesanan Anda akan otomatis dibatalkan.'
        ]);

        Notification::create([
            'pengguna_id' => null,
            'diskon_id' => null,
            'history_id' => 2,
            'status_history' => 'Dipesan',
            'pesan' => 'Halo C, motor yang Anda pesan akan segera siap dalam 2 jam. Mohon bersiap untuk mengambil atau menerima motor Anda.'
        ]);

        Notification::create([
            'pengguna_id' => null,
            'diskon_id' => null,
            'history_id' => 3,
            'status_history' => 'Sedang Digunakan',
            'pesan' => 'Halo D, motor yang Anda gunakan harus dikembalikan dalam 2 jam. Jika Anda melebihi waktu yang ditentukan, Anda akan dikenakan biaya tambahan sebesar 1 hari sesuai dengan motor yang Anda booking.'
        ]);
    }
}
