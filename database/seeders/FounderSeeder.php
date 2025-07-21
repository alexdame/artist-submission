<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class FounderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
public function run()
{
    User::create([
        'name' => 'Founder',
        'email' => 'founder@platform.com',
        'password' => Hash::make('founder123'), // Change this after first login
        'role' => 'founder'
    ]);
}
}
