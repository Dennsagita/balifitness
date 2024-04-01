<?php

namespace Database\Seeders;

use App\Models\Coach;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CoachSeeder extends Seeder
{
    public function run()
    {
        // Reset auto-increment id menjadi 1
        // DB::statement('ALTER TABLE coaches AUTO_INCREMENT = 1');
        // Data coach yang akan di-seed
        $coaches = [
            [
                'nama' => 'Coach 1',
                'email' => 'coach1@gmail.com',
                'password' => Hash::make('123'),
                'no_telp' => '081245554333',
                'alamat' => 'Denpasar',
            ],
            [
                'nama' => 'Coach 2',
                'email' => 'coach2@gmail.com',
                'password' => Hash::make('123'),
                'no_telp' => '0812455521542',
                'alamat' => 'Denpasar',
            ],
            // Tambahkan data lainnya sesuai kebutuhan
        ];

        // Looping data dan tambahkan ke database
        foreach ($coaches as $coach) {
            Coach::create($coach);
        }
    }
}
