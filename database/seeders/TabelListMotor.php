<?php

namespace Database\Seeders;

use App\Models\ListMotor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TabelListMotor extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Sport

        ListMotor::create([
            'tipe_motor' => 'Sport',
            'merk_motor' => 'Honda',
            'nama_motor' => 'CRF',
            'stok_motor' => 1,
            'status_motor' => 'Tersedia',
            'harga_motor_per_1_hari' => (200000 * 0.25) + 200000,
            'harga_motor_per_1_minggu' =>(1200000 * 0.25) + 1200000,
        ]);

        ListMotor::create([
            'tipe_motor' => 'Sport',
            'merk_motor' => 'Yamaha',
            'nama_motor' => 'XSR',
            'stok_motor' => 2,
            'status_motor' => 'Tersedia',
            'harga_motor_per_1_hari' => (200000 * 0.25) + 200000,
            'harga_motor_per_1_minggu' =>(1200000 * 0.25) + 1200000,
        ]);

        //Premium Matic

        ListMotor::create([
            'tipe_motor' => 'Premium Matic',
            'merk_motor' => 'Vespa',
            'nama_motor' => 'Vespa Sprint',
            'stok_motor' => 2,
            'status_motor' => 'Tersedia',
            'harga_motor_per_1_hari' => (200000 * 0.25) + 200000,
            'harga_motor_per_1_minggu' =>(1200000 * 0.25) + 1200000,
        ]);

        ListMotor::create([
            'tipe_motor' => 'Premium Matic',
            'merk_motor' => 'Yamaha',
            'nama_motor' => 'XMAX',
            'stok_motor' => 2,
            'status_motor' => 'Tersedia',
            'harga_motor_per_1_hari' => (200000 * 0.25) + 200000,
            'harga_motor_per_1_minggu' =>(1200000 * 0.25) + 1200000,
        ]);

        ListMotor::create([
            'tipe_motor' => 'Premium Matic',
            'merk_motor' => 'Honda',
            'nama_motor' => 'PCX',
            'stok_motor' => 2,
            'status_motor' => 'Tersedia',
            'harga_motor_per_1_hari' => (175000 * 0.25) + 175000,
            'harga_motor_per_1_minggu' =>(1050000 * 0.25) + 1050000,
        ]);

        ListMotor::create([
            'tipe_motor' => 'Premium Matic',
            'merk_motor' => 'Yamaha',
            'nama_motor' => 'NMAX',
            'stok_motor' => 2,
            'status_motor' => 'Tersedia',
            'harga_motor_per_1_hari' => (175000 * 0.25) + 175000,
            'harga_motor_per_1_minggu' =>(1050000 * 0.25) + 1050000,
        ]);

        //Matic

        ListMotor::create([
            'tipe_motor' => 'Matic',
            'merk_motor' => 'Honda',
            'nama_motor' => 'Vario 160',
            'stok_motor' => 2,
            'status_motor' => 'Tersedia',
            'harga_motor_per_1_hari' => (160000 * 0.25) + 160000,
            'harga_motor_per_1_minggu' =>(960000 * 0.25) + 960000,
        ]);

        ListMotor::create([
            'tipe_motor' => 'Matic',
            'merk_motor' => 'Honda',
            'nama_motor' => 'Vario 125/150',
            'stok_motor' => 2,
            'status_motor' => 'Tersedia',
            'harga_motor_per_1_hari' => (150000 * 0.25) + 150000,
            'harga_motor_per_1_minggu' =>(900000 * 0.25) + 900000,
        ]);

        ListMotor::create([
            'tipe_motor' => 'Matic',
            'merk_motor' => 'Honda',
            'nama_motor' => 'Scoopy New',
            'stok_motor' => 2,
            'status_motor' => 'Tersedia',
            'harga_motor_per_1_hari' => (150000 * 0.25) + 150000,
            'harga_motor_per_1_minggu' =>(900000 * 0.25) + 900000,
        ]);

        ListMotor::create([
            'tipe_motor' => 'Matic',
            'merk_motor' => 'Honda',
            'nama_motor' => 'Scoopy FI',
            'stok_motor' => 2,
            'status_motor' => 'Tersedia',
            'harga_motor_per_1_hari' => (110000 * 0.25) + 110000,
            'harga_motor_per_1_minggu' =>(750000 * 0.25) + 750000,
        ]);

        ListMotor::create([
            'tipe_motor' => 'Matic',
            'merk_motor' => 'Honda',
            'nama_motor' => 'Beat',
            'stok_motor' => 2,
            'status_motor' => 'Tersedia',
            'harga_motor_per_1_hari' => (125000 * 0.25) + 125000,
            'harga_motor_per_1_minggu' =>(750000 * 0.25) + 750000,
        ]);

        ListMotor::create([
            'tipe_motor' => 'Matic',
            'merk_motor' => 'Yamaha',
            'nama_motor' => 'Xeon',
            'stok_motor' => 2,
            'status_motor' => 'Tersedia',
            'harga_motor_per_1_hari' => (100000 * 0.25) + 100000,
            'harga_motor_per_1_minggu' =>(600000 * 0.25) + 600000,
        ]);

        ListMotor::create([
            'tipe_motor' => 'Matic',
            'merk_motor' => 'Yamaha',
            'nama_motor' => 'Soul GT',
            'stok_motor' => 2,
            'status_motor' => 'Tersedia',
            'harga_motor_per_1_hari' => (100000 * 0.25) + 100000,
            'harga_motor_per_1_minggu' =>(600000 * 0.25) + 600000,
        ]);

        ListMotor::create([
            'tipe_motor' => 'Matic',
            'merk_motor' => 'Yamaha',
            'nama_motor' => 'Mio J',
            'stok_motor' => 2,
            'status_motor' => 'Tersedia',
            'harga_motor_per_1_hari' => (100000 * 0.25) + 100000,
            'harga_motor_per_1_minggu' =>(600000 * 0.25) + 600000,
        ]);

        ListMotor::create([
            'tipe_motor' => 'Matic',
            'merk_motor' => 'Yamaha',
            'nama_motor' => 'Mio Sporty',
            'stok_motor' => 2,
            'status_motor' => 'Tersedia',
            'harga_motor_per_1_hari' => (80000 * 0.25) + 80000,
            'harga_motor_per_1_minggu' =>(500000 * 0.25) + 500000,
        ]);
    }
}
