<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Reset auto-increment id menjadi 1
        // DB::statement('ALTER TABLE admins AUTO_INCREMENT = 1');
        // Data admin yang akan di-seed
        $admins = [
            [
                'nama' => 'Admin',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('123'),
                'no_telp' => '081245552123',
                'alamat' => 'Denpasar',
            ],
            [
                'nama' => 'Admin 2',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('123'),
                'no_telp' => '0812455522543',
                'alamat' => 'Denpasar',
            ],
            // Tambahkan data lainnya sesuai kebutuhan
        ];

        // Looping data dan tambahkan ke database
        foreach ($admins as $admin) {
            Admin::create($admin);
        }
    }
}
