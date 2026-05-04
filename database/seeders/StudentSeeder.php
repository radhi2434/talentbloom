<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            [
                'email' => 'teacher@talentbloom.com',
            ],
            [
                'name' => 'Mr Ilham',
                'ic_number' => '0403240108779',
                'password' => Hash::make('abc123'),
                'role' => 'teacher',
            ]
        );
    }
}
