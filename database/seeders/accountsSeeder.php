<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AccountsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admins = [
            [
                'userid' => Str::uuid(),
                'fullName' => 'Kevin Jay Gutierrez',
                'email' => 'kevin.gutierrez@example.com',
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'status' => 'active',
                'createdAt' => now('Asia/Manila'),
                'updatedAt' => now('Asia/Manila'),
            ],
            [
                'userid' => Str::uuid(),
                'fullName' => 'Lexter Angelo Alonzo',
                'email' => 'lexter.alonzo@example.com',
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'status' => 'active',
                'createdAt' => now('Asia/Manila'),
                'updatedAt' => now('Asia/Manila'),
            ],
            [
                'userid' => Str::uuid(),
                'fullName' => 'Edrick M. Estorel',
                'email' => 'edrick.estorel@example.com',
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'status' => 'active',
                'createdAt' => now('Asia/Manila'),
                'updatedAt' => now('Asia/Manila'),
            ],
            [
                'userid' => Str::uuid(),
                'fullName' => 'John Patrick Nacional',
                'email' => 'john.nacional@example.com',
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'status' => 'inactive',
                'createdAt' => now('Asia/Manila'),
                'updatedAt' => now('Asia/Manila'),
            ]
        ];

        DB::table('users')->insert($admins);
    }
}