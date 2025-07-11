<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminUser = User::create([
            'name' => 'Qiyana Bouquet Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('qiyanaB12345')
        ]);

        $adminUser->assignRole('admin');
    }
}
