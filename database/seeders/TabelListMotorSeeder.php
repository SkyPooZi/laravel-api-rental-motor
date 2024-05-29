<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\ListMotor;
use Illuminate\Database\Seeder;

class TabelListMotorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Sport

        ListMotor::create([
            'gambar_motor' => 'images/crf.jpg',
            'nama_motor' => 'CRF',
            'tipe_motor' => 'Sport',
            'merk_motor' => 'Honda',
            'stok_motor' => 1,
            'harga_motor_per_1_hari' => (200000 * 0.25) + 200000,
            'harga_motor_per_1_minggu' => (1200000 * 0.25) + 1200000,
            'fasilitas_motor' => '2 Helm dan 2 Jas Hujan',
            'status_motor' => 'Tersedia',
        ]);

        ListMotor::create([
            'gambar_motor' => 'images/xsr.jpg',
            'nama_motor' => 'XSR',
            'tipe_motor' => 'Sport',
            'merk_motor' => 'Yamaha',
            'stok_motor' => 2,
            'harga_motor_per_1_hari' => (200000 * 0.25) + 200000,
            'harga_motor_per_1_minggu' => (1200000 * 0.25) + 1200000,
            'fasilitas_motor' => '2 Helm dan 2 Jas Hujan',
            'status_motor' => 'Tersedia',
        ]);

        //Premium Matic

        ListMotor::create([
            'gambar_motor' => 'images/vespa_sprint.jpg',
            'nama_motor' => 'Vespa Sprint',
            'tipe_motor' => 'Premium Matic',
            'merk_motor' => 'Vespa',
            'stok_motor' => 2,
            'harga_motor_per_1_hari' => (200000 * 0.25) + 200000,
            'harga_motor_per_1_minggu' => (1200000 * 0.25) + 1200000,
            'fasilitas_motor' => '2 Helm dan 2 Jas Hujan',
            'status_motor' => 'Tersedia',
        ]);

        ListMotor::create([
            'gambar_motor' => 'images/xmax.jpg',
            'nama_motor' => 'XMAX',
            'tipe_motor' => 'Premium Matic',
            'merk_motor' => 'Yamaha',
            'stok_motor' => 2,
            'harga_motor_per_1_hari' => (200000 * 0.25) + 200000,
            'harga_motor_per_1_minggu' => (1200000 * 0.25) + 1200000,
            'fasilitas_motor' => '2 Helm dan 2 Jas Hujan',
            'status_motor' => 'Tersedia',
        ]);

        ListMotor::create([
            'gambar_motor' => 'images/pcx.jpg',
            'nama_motor' => 'PCX',
            'tipe_motor' => 'Premium Matic',
            'merk_motor' => 'Honda',
            'stok_motor' => 2,
            'harga_motor_per_1_hari' => (175000 * 0.25) + 175000,
            'harga_motor_per_1_minggu' => (1050000 * 0.25) + 1050000,
            'fasilitas_motor' => '2 Helm dan 2 Jas Hujan',
            'status_motor' => 'Tersedia',
        ]);

        ListMotor::create([
            'gambar_motor' => 'images/nmax.jpg',
            'nama_motor' => 'NMAX',
            'tipe_motor' => 'Premium Matic',
            'merk_motor' => 'Yamaha',
            'stok_motor' => 2,
            'harga_motor_per_1_hari' => (175000 * 0.25) + 175000,
            'harga_motor_per_1_minggu' => (1050000 * 0.25) + 1050000,
            'fasilitas_motor' => '2 Helm dan 2 Jas Hujan',
            'status_motor' => 'Tersedia',
        ]);

        //Matic

        ListMotor::create([
            'gambar_motor' => 'images/vario_160.jpg',
            'nama_motor' => 'Vario 160',
            'tipe_motor' => 'Matic',
            'merk_motor' => 'Honda',
            'stok_motor' => 2,
            'harga_motor_per_1_hari' => (160000 * 0.25) + 160000,
            'harga_motor_per_1_minggu' => (960000 * 0.25) + 960000,
            'fasilitas_motor' => '2 Helm dan 2 Jas Hujan',
            'status_motor' => 'Tersedia',
        ]);

        ListMotor::create([
            'gambar_motor' => 'images/vario_150.jpg',
            'nama_motor' => 'Vario 125/150',
            'tipe_motor' => 'Matic',
            'merk_motor' => 'Honda',
            'stok_motor' => 2,
            'harga_motor_per_1_hari' => (150000 * 0.25) + 150000,
            'harga_motor_per_1_minggu' => (900000 * 0.25) + 900000,
            'fasilitas_motor' => '2 Helm dan 2 Jas Hujan',
            'status_motor' => 'Tersedia',
        ]);

        ListMotor::create([
            'gambar_motor' => 'images/scoopy_new.jpg',
            'nama_motor' => 'Scoopy New',
            'tipe_motor' => 'Matic',
            'merk_motor' => 'Honda',
            'stok_motor' => 2,
            'harga_motor_per_1_hari' => (150000 * 0.25) + 150000,
            'harga_motor_per_1_minggu' => (900000 * 0.25) + 900000,
            'fasilitas_motor' => '2 Helm dan 2 Jas Hujan',
            'status_motor' => 'Tersedia',
        ]);

        ListMotor::create([
            'gambar_motor' => 'images/scoopy_fi.jpg',
            'nama_motor' => 'Scoopy Fi',
            'tipe_motor' => 'Matic',
            'merk_motor' => 'Honda',
            'stok_motor' => 2,
            'harga_motor_per_1_hari' => (110000 * 0.25) + 110000,
            'harga_motor_per_1_minggu' => (750000 * 0.25) + 750000,
            'fasilitas_motor' => '2 Helm dan 2 Jas Hujan',
            'status_motor' => 'Tersedia',
        ]);

        ListMotor::create([
            'gambar_motor' => 'images/beat.jpg',
            'nama_motor' => 'Beat',
            'tipe_motor' => 'Matic',
            'merk_motor' => 'Honda',
            'stok_motor' => 2,
            'harga_motor_per_1_hari' => (125000 * 0.25) + 125000,
            'harga_motor_per_1_minggu' => (750000 * 0.25) + 750000,
            'fasilitas_motor' => '2 Helm dan 2 Jas Hujan',
            'status_motor' => 'Tersedia',
        ]);

        ListMotor::create([
            'gambar_motor' => 'images/xeon.jpg',
            'nama_motor' => 'Xeon',
            'tipe_motor' => 'Matic',
            'merk_motor' => 'Yamaha',
            'stok_motor' => 2,
            'harga_motor_per_1_hari' => (100000 * 0.25) + 100000,
            'harga_motor_per_1_minggu' => (600000 * 0.25) + 600000,
            'fasilitas_motor' => '2 Helm dan 2 Jas Hujan',
            'status_motor' => 'Tersedia',
        ]);

        ListMotor::create([
            'gambar_motor' => 'images/soul_gt.jpg',
            'nama_motor' => 'Soul GT',
            'tipe_motor' => 'Matic',
            'merk_motor' => 'Yamaha',
            'stok_motor' => 2,
            'harga_motor_per_1_hari' => (100000 * 0.25) + 100000,
            'harga_motor_per_1_minggu' => (600000 * 0.25) + 600000,
            'fasilitas_motor' => '2 Helm dan 2 Jas Hujan',
            'status_motor' => 'Tersedia',
        ]);

        ListMotor::create([
            'gambar_motor' => 'images/mio_j.jpg',
            'nama_motor' => 'Mio J',
            'tipe_motor' => 'Matic',
            'merk_motor' => 'Yamaha',
            'stok_motor' => 2,
            'harga_motor_per_1_hari' => (100000 * 0.25) + 100000,
            'harga_motor_per_1_minggu' =>(600000 * 0.25) + 600000,
            'fasilitas_motor' => '2 Helm dan 2 Jas Hujan',
            'status_motor' => 'Tersedia',
        ]);

        ListMotor::create([
            'gambar_motor' => 'images/mio_sporty.jpg',
            'nama_motor' => 'Mio Sporty',
            'tipe_motor' => 'Matic',
            'merk_motor' => 'Yamaha',
            'stok_motor' => 2,
            'harga_motor_per_1_hari' => (80000 * 0.25) + 80000,
            'harga_motor_per_1_minggu' =>(500000 * 0.25) + 500000,
            'fasilitas_motor' => '2 Helm dan 2 Jas Hujan',
            'status_motor' => 'Tersedia',
        ]);
    }
}
