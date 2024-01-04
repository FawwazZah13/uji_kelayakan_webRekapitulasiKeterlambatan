<?php

namespace Database\Seeders;

use App\Models\users;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'email' => 'admin@gmail.com',
                'name' => 'Admin',
                'password' => Hash::make('123'),
                'role' => 'admin',
            ],
        ];
        users::insert($data);
    }
    }

