<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Créer les utilisateurs de l'agence
        User::create([
            'name' => 'Abdellah',
            'email' => 'abdellah@agence.ma',
            'password' => Hash::make('password123')
        ]);

        User::create([
            'name' => 'Mouad',
            'email' => 'mouad@agence.ma',
            'password' => Hash::make('password123')
        ]);

        // Compte admin général
        User::create([
            'name' => 'Admin',
            'email' => 'admin@agence.ma',
            'password' => Hash::make('admin123')
        ]);
    }
}
