<?php

namespace Database\Seeders;

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
            'gambar_motor' => 'images/crf.png',
            'nama_motor' => 'CRF',
            'tipe_motor' => 'Sport',
            'merk_motor' => 'Honda',
            'stok_motor' => 1,
            'harga_motor_per_1_hari' => (200000 * 0.25) + 200000,
            'harga_motor_per_1_minggu' => (1200000 * 0.25) + 1200000,
            'harga_motor_diantar' => (200000 * 0.1),
            'status_motor' => 'Tersedia',
            'tanggal_mulai_tidak_tersedia' => null,
            'tanggal_selesai_tidak_tersedia' => null,
            'is_hidden' => false,
        ]);

        ListMotor::create([
            'gambar_motor' => 'images/xsr.png',
            'nama_motor' => 'XSR',
            'tipe_motor' => 'Sport',
            'merk_motor' => 'Yamaha',
            'stok_motor' => 2,
            'harga_motor_per_1_hari' => (200000 * 0.25) + 200000,
            'harga_motor_per_1_minggu' => (1200000 * 0.25) + 1200000,
            'harga_motor_diantar' => (200000 * 0.1),
            'status_motor' => 'Tersedia',
            'tanggal_mulai_tidak_tersedia' => null,
            'tanggal_selesai_tidak_tersedia' => null,
            'is_hidden' => false,
        ]);

        //Premium Matic

        ListMotor::create([
            'gambar_motor' => 'images/vespa_sprint.png',
            'nama_motor' => 'Vespa Sprint',
            'tipe_motor' => 'Premium Matic',
            'merk_motor' => 'Vespa',
            'stok_motor' => 2,
            'harga_motor_per_1_hari' => (200000 * 0.25) + 200000,
            'harga_motor_per_1_minggu' => (1200000 * 0.25) + 1200000,
            'harga_motor_diantar' => (200000 * 0.1),
            'status_motor' => 'Tersedia',
            'tanggal_mulai_tidak_tersedia' => null,
            'tanggal_selesai_tidak_tersedia' => null,
            'is_hidden' => false,
        ]);

        ListMotor::create([
            'gambar_motor' => 'images/xmax.png',
            'nama_motor' => 'XMAX',
            'tipe_motor' => 'Premium Matic',
            'merk_motor' => 'Yamaha',
            'stok_motor' => 2,
            'harga_motor_per_1_hari' => (200000 * 0.25) + 200000,
            'harga_motor_per_1_minggu' => (1200000 * 0.25) + 1200000,
            'harga_motor_diantar' => (200000 * 0.1),
            'status_motor' => 'Tersedia',
            'tanggal_mulai_tidak_tersedia' => null,
            'tanggal_selesai_tidak_tersedia' => null,
            'is_hidden' => false,
        ]);

        ListMotor::create([
            'gambar_motor' => 'images/pcx.png',
            'nama_motor' => 'PCX',
            'tipe_motor' => 'Premium Matic',
            'merk_motor' => 'Honda',
            'stok_motor' => 2,
            'harga_motor_per_1_hari' => (175000 * 0.25) + 175000,
            'harga_motor_per_1_minggu' => (1050000 * 0.25) + 1050000,
            'harga_motor_diantar' => (175000 * 0.1),
            'status_motor' => 'Tersedia',
            'tanggal_mulai_tidak_tersedia' => null,
            'tanggal_selesai_tidak_tersedia' => null,
            'is_hidden' => false,
        ]);

        ListMotor::create([
            'gambar_motor' => 'images/nmax.png',
            'nama_motor' => 'NMAX',
            'tipe_motor' => 'Premium Matic',
            'merk_motor' => 'Yamaha',
            'stok_motor' => 2,
            'harga_motor_per_1_hari' => (175000 * 0.25) + 175000,
            'harga_motor_per_1_minggu' => (1050000 * 0.25) + 1050000,
            'harga_motor_diantar' => (175000 * 0.1),
            'status_motor' => 'Tersedia',
            'tanggal_mulai_tidak_tersedia' => null,
            'tanggal_selesai_tidak_tersedia' => null,
            'is_hidden' => false,
        ]);

        //Matic

        ListMotor::create([
            'gambar_motor' => 'images/vario_160.png',
            'nama_motor' => 'Vario 160',
            'tipe_motor' => 'Matic',
            'merk_motor' => 'Honda',
            'stok_motor' => 2,
            'harga_motor_per_1_hari' => (160000 * 0.25) + 160000,
            'harga_motor_per_1_minggu' => (960000 * 0.25) + 960000,
            'harga_motor_diantar' => (160000 * 0.1),
            'status_motor' => 'Tersedia',
            'tanggal_mulai_tidak_tersedia' => null,
            'tanggal_selesai_tidak_tersedia' => null,
            'is_hidden' => false,
        ]);

        ListMotor::create([
            'gambar_motor' => 'images/vario_150.png',
            'nama_motor' => 'Vario 125/150',
            'tipe_motor' => 'Matic',
            'merk_motor' => 'Honda',
            'stok_motor' => 2,
            'harga_motor_per_1_hari' => (150000 * 0.25) + 150000,
            'harga_motor_per_1_minggu' => (900000 * 0.25) + 900000,
            'harga_motor_diantar' => (150000 * 0.1),
            'status_motor' => 'Tersedia',
            'tanggal_mulai_tidak_tersedia' => null,
            'tanggal_selesai_tidak_tersedia' => null,
            'is_hidden' => false,
        ]);

        ListMotor::create([
            'gambar_motor' => 'images/scoopy_new.png',
            'nama_motor' => 'Scoopy New',
            'tipe_motor' => 'Matic',
            'merk_motor' => 'Honda',
            'stok_motor' => 2,
            'harga_motor_per_1_hari' => (150000 * 0.25) + 150000,
            'harga_motor_per_1_minggu' => (900000 * 0.25) + 900000,
            'harga_motor_diantar' => (150000 * 0.1),
            'status_motor' => 'Tersedia',
            'tanggal_mulai_tidak_tersedia' => null,
            'tanggal_selesai_tidak_tersedia' => null,
            'is_hidden' => false,
        ]);

        ListMotor::create([
            'gambar_motor' => 'images/scoopy_fi.png',
            'nama_motor' => 'Scoopy Fi',
            'tipe_motor' => 'Matic',
            'merk_motor' => 'Honda',
            'stok_motor' => 2,
            'harga_motor_per_1_hari' => (110000 * 0.25) + 110000,
            'harga_motor_per_1_minggu' => (750000 * 0.25) + 750000,
            'harga_motor_diantar' => (110000 * 0.1),
            'status_motor' => 'Tersedia',
            'tanggal_mulai_tidak_tersedia' => null,
            'tanggal_selesai_tidak_tersedia' => null,
            'is_hidden' => false,
        ]);

        ListMotor::create([
            'gambar_motor' => 'images/beat.png',
            'nama_motor' => 'Beat',
            'tipe_motor' => 'Matic',
            'merk_motor' => 'Honda',
            'stok_motor' => 2,
            'harga_motor_per_1_hari' => (125000 * 0.25) + 125000,
            'harga_motor_per_1_minggu' => (750000 * 0.25) + 750000,
            'harga_motor_diantar' => (125000 * 0.1),
            'status_motor' => 'Tersedia',
            'tanggal_mulai_tidak_tersedia' => null,
            'tanggal_selesai_tidak_tersedia' => null,
            'is_hidden' => false,
        ]);

        ListMotor::create([
            'gambar_motor' => 'images/xeon.png',
            'nama_motor' => 'Xeon',
            'tipe_motor' => 'Matic',
            'merk_motor' => 'Yamaha',
            'stok_motor' => 2,
            'harga_motor_per_1_hari' => (100000 * 0.25) + 100000,
            'harga_motor_per_1_minggu' => (600000 * 0.25) + 600000,
            'harga_motor_diantar' => (100000 * 0.1),
            'status_motor' => 'Tersedia',
            'tanggal_mulai_tidak_tersedia' => null,
            'tanggal_selesai_tidak_tersedia' => null,
            'is_hidden' => false,
        ]);

        ListMotor::create([
            'gambar_motor' => 'images/soul_gt.png',
            'nama_motor' => 'Soul GT',
            'tipe_motor' => 'Matic',
            'merk_motor' => 'Yamaha',
            'stok_motor' => 2,
            'harga_motor_per_1_hari' => (100000 * 0.25) + 100000,
            'harga_motor_per_1_minggu' => (600000 * 0.25) + 600000,
            'harga_motor_diantar' => (100000 * 0.1),
            'status_motor' => 'Tersedia',
            'tanggal_mulai_tidak_tersedia' => null,
            'tanggal_selesai_tidak_tersedia' => null,
            'is_hidden' => false,
        ]);

        ListMotor::create([
            'gambar_motor' => 'images/mio_j.png',
            'nama_motor' => 'Mio J',
            'tipe_motor' => 'Matic',
            'merk_motor' => 'Yamaha',
            'stok_motor' => 2,
            'harga_motor_per_1_hari' => (100000 * 0.25) + 100000,
            'harga_motor_per_1_minggu' =>(600000 * 0.25) + 600000,
            'harga_motor_diantar' => (100000 * 0.1),
            'status_motor' => 'Tersedia',
            'tanggal_mulai_tidak_tersedia' => null,
            'tanggal_selesai_tidak_tersedia' => null,
            'is_hidden' => false,
        ]);

        ListMotor::create([
            'gambar_motor' => 'images/mio_sporty.png',
            'nama_motor' => 'Mio Sporty',
            'tipe_motor' => 'Matic',
            'merk_motor' => 'Yamaha',
            'stok_motor' => 2,
            'harga_motor_per_1_hari' => (80000 * 0.25) + 80000,
            'harga_motor_per_1_minggu' =>(500000 * 0.25) + 500000,
            'harga_motor_diantar' => (80000 * 0.1),
            'status_motor' => 'Tersedia',
            'tanggal_mulai_tidak_tersedia' => null,
            'tanggal_selesai_tidak_tersedia' => null,
            'is_hidden' => false,
        ]);
    }
}
