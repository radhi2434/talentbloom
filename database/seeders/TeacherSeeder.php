<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TeacherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            [
                'email' => 'student@talentbloom.com',
            ],
            [
                'name' => 'Aqilah Radhiah',
                'ic_number' => '840302865560',
                'password' => Hash::make('abc123'),
                'role' => 'student',
            ]
        );
    }
}
