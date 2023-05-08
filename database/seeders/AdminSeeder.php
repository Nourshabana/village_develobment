<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'first_name' => 'Nour',
            'last_name' => 'Shabana',
            'email'=>'nourahmed200189@gmail.com',
            'gender'=>'male',
            'role'=>'admin',
            'birth_date'=>'2001-08-09',
            'password'=>Hash::make('password'),
        ])->assignRole('admin');

        
    }
}
