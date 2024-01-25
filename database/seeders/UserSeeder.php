<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        User::create(
            [
                'uuid' => generateUuid(),
                'nama' => 'Owner 1',
                'email' => 'admin54@ruangbaca.me',
                'password' => 'Bacaruang54',
                'role' => 'owner',
                'active' => 1,
            ]
        );
    }
}
