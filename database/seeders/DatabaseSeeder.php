<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Wallet;
use App\Models\Type;
use App\Models\TypeBank;
use App\Models\StatusSell;
use DB;
use Hash;

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

        Wallet::create([
            'id_users' => $create_user->id,
            'amount' => 0,
        ]);

        Type::create([
            'type' => 'Botol Plastik',
            'price' =>  3000,
            'image' => 'img/sampah/botolplastik.png',
        ]);
        Type::create([
            'type' => 'Kardus',
            'price' => 2000,
            'image' => 'img/sampah/kertaskarton.png',
        ]);
        Type::create([
            'type' => 'Botol Kaca',
            'price' => 2500,
            'image' => 'img/sampah/botolkaca.png',
        ]);
        Type::create([
            'type' => 'Kertas Koran',
            'price' => 1000,
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
