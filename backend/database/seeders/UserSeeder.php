<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::firstOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'name'     => 'Administrador',
                'password' => Hash::make('password'),
                'rol'      => 'admin',
                'activo'   => true,
            ]
        );
        $admin->assignRole('admin');

        $encargado = User::firstOrCreate(
            ['email' => 'encargado@admin.com'],
            [
                'name'     => 'Encargado',
                'password' => Hash::make('password'),
                'rol'      => 'encargado',
                'activo'   => true,
            ]
        );
        $encargado->assignRole('encargado');
    }
}
