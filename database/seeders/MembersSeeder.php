<?php

namespace Database\Seeders;

use App\Models\Member;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class MembersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset auto-increment id menjadi 1
        // DB::statement('ALTER TABLE coaches AUTO_INCREMENT = 1');
        // Data coach yang akan di-seed
        $members = [
            [
                'nama' => 'Yogi Saputra',
                'email' => 'yogi@gmail.com',
                'password' => Hash::make('123'),
                'no_telp' => '081245559870',
                'alamat' => 'Denpasar',
            ],
            [
                'nama' => 'Andre Gams',
                'email' => 'andre.com',
                'password' => Hash::make('123'),
                'no_telp' => '0812455523265',
                'alamat' => 'Denpasar',
            ],
            // Tambahkan data lainnya sesuai kebutuhan
        ];

        // Looping data dan tambahkan ke database
        foreach ($members as $member) {
            Member::create($member);
        }
    }
}
