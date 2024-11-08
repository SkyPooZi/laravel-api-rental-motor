<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TabelUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = Hash::make('admin123');
        $a = Hash::make('a123');
        $b = Hash::make('b123');
        $c = Hash::make('c123');
        $d = Hash::make('d123');
        $e = Hash::make('e123');
        $f = Hash::make('f123');

        User::create([
            'nama_pengguna' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => $admin,
            'nomor_hp' => '+6285866200334',
            'peran' => 'admin',
        ]);

        User::create([
            'nama_pengguna' => 'a',
            'email' => 'a@gmail.com',
            'password' => $a,
        ]);

        User::create([
            'nama_pengguna' => 'b',
            'email' => 'b@gmail.com',
            'password' => $b,
        ]);

        User::create([
            'nama_pengguna' => 'c',
            'email' => 'c@gmail.com',
            'password' => $c,
        ]);

        User::create([
            'nama_pengguna' => 'd',
            'email' => 'd@gmail.com',
            'password' => $d,
        ]);

        User::create([
            'nama_pengguna' => 'e',
            'email' => 'e@gmail.com',
            'password' => $e,
        ]);

        User::create([
            'nama_pengguna' => 'f',
            'email' => 'f@gmail.com',
            'password' => $f,
        ]);
    }
}
