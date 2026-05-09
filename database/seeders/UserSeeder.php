<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@sistema.com'],
            [
                'name' => 'Administrador',
                'password' => Hash::make('12345678'),
                'role' => 'administrador',
            ]
        );

        User::updateOrCreate(
            ['email' => 'analista@sistema.com'],
            [
                'name' => 'Analista de Ventas',
                'password' => Hash::make('12345678'),
                'role' => 'analista',
            ]
        );

        User::updateOrCreate(
            ['email' => 'gerente@sistema.com'],
            [
                'name' => 'Gerente Comercial',
                'password' => Hash::make('12345678'),
                'role' => 'gerente',
            ]
        );
    }
}