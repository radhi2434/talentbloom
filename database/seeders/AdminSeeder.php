<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            [
                'email' => 'admin@talentbloom.com',
            ],
            [
                'name' => 'System Admin',
                'ic_number' => '860712116975',
                'password' => Hash::make('abc123'),
                'role' => 'admin',
            ]
        );
    }
}
