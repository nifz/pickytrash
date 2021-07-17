<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $create_user = User::create([
            'name' => 'Mochammad Hanif',
            'email' => 'me@hanifz.com',
            'password' => Hash::make('qweqwe123'),
            'role' => 3,
        ]);

        Type::create([
            'type' => 'Botol Plastik',
            'price' => 100,
            'image' => 'img/sampah/botolplastik.png',
        ]);
        Type::create([
            'type' => 'Kardus',
            'price' => 50,
            'image' => 'img/sampah/kertaskarton.png',
        ]);
        Type::create([
            'type' => 'Botol Kaca',
            'price' => 100,
            'image' => 'img/sampah/botolkaca.png',
        ]);
        Type::create([
            'type' => 'Kertas Koran',
            'price' => 50,
            'image' => 'img/sampah/kertaskoran.png',
        ]);
        
        TypeBank::create([
            'name' => "BCA",
        ]);
        TypeBank::create([
            'name' => "OVO",
        ]);

        StatusSell::create([
            'name' => 'Mengajukan Penjualan Sampah.',
        ]);
        StatusSell::create([
            'name' => 'Menerima Pengajuan Penjualan Sampah.',
        ]);
        StatusSell::create([
            'name' => 'Menuju Perjalanan.',
        ]);
        StatusSell::create([
            'name' => 'Telah Sampai Ditempat Tujuan.',
        ]);
        StatusSell::create([
            'name' => 'Menerima Sampah.',
        ]);
        StatusSell::create([
            'name' => 'Pengajuan Penjualan Sampah Telah Diterima.',
        ]);
        StatusSell::create([
            'name' => 'Pengajuan Tidak Sesuai, Penjualan Dibatalkan.',
        ]);
    }
}
