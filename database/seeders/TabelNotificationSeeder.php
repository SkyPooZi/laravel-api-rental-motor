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
            'history_id' => 2,
            'status_history' => 'Menunggu Pembayaran',
            'pesan' => 'Halo A, Anda memiliki waktu 2 jam lagi untuk menyelesaikan pembayaran untuk pesanan Anda. Jika tidak, pesanan Anda akan otomatis dibatalkan.'
        ]);

        Notification::create([
            'history_id' => 3,
            'status_history' => 'Menunggu Pembayaran',
            'pesan' => 'Halo B, Anda memiliki waktu 2 jam lagi untuk menyelesaikan pembayaran untuk pesanan Anda. Jika tidak, pesanan Anda akan otomatis dibatalkan.'
        ]);

        Notification::create([
            'history_id' => 4,
            'status_history' => 'Dipesan',
            'pesan' => 'Halo C, motor yang Anda pesan akan segera siap dalam 2 jam. Mohon bersiap untuk mengambil atau menerima motor Anda.'
        ]);

        Notification::create([
            'history_id' => 5,
            'status_history' => 'Sedang Digunakan',
            'pesan' => 'Halo D, motor yang Anda gunakan harus dikembalikan dalam 2 jam. Jika Anda melebihi waktu yang ditentukan, Anda akan dikenakan biaya tambahan sebesar 1 hari sesuai dengan motor yang Anda booking.'
        ]);

        Notification::create([
            'history_id' => 6,
            'status_history' => 'Sedang Digunakan',
            'pesan' => 'Halo E, motor yang Anda gunakan harus dikembalikan dalam 2 jam. Jika Anda melebihi waktu yang ditentukan, Anda akan dikenakan biaya tambahan sebesar 1 hari sesuai dengan motor yang Anda booking.'
        ]);
    }
}
