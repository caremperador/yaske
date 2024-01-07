<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleAssignSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // Asegúrate de que los roles existan
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $premiumRole = Role::firstOrCreate(['name' => 'premium']);

        // Usuarios y sus detalles
        $usuarios = [
            [
                'email' => 'filtrosperu@gmail.com',
                'name' => 'Eduardo Aranguri',
                'password' => bcrypt('14e30s15b'),
                'role' => $adminRole
            ],
            [
                'email' => 'admin@admin.com',
                'name' => 'admin',
                'password' => bcrypt('123456'),
                'role' => $adminRole
            ],
            [
                'email' => 'Jannet.rivero.pedemonte@gmail.com',
                'name' => 'Jannet',
                'password' => bcrypt('14e30s15b'),
                'role' => $premiumRole
            ]
        ];

        foreach ($usuarios as $usuario) {
            // Encuentra o crea el usuario
            $user = User::firstOrCreate(
                ['email' => $usuario['email']],
                ['name' => $usuario['name'], 'password' => $usuario['password']]
            );

            // Asigna el rol si el usuario no lo tiene
            if (!$user->hasRole($usuario['role']->name)) {
                $user->assignRole($usuario['role']);
            }
        }
    }
}
