<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // Crée un compte admin par défaut
        Admin::create([
            'name'     => 'Administrateur',
            'email'    => 'admin@driver-valence.fr',
            'password' => Hash::make('admin123'),
        ]);
    }
}
