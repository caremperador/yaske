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

        /**
         * Primero, aseguramos que los roles necesarios existan en la base de datos.
         * Usamos el método firstOrCreate, que intenta encontrar un registro en la base de datos
         * que coincida con los criterios especificados (en este caso, el 'name' del rol).
         * Si no encuentra un registro coincidente, crea uno nuevo con esos datos.
         */
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $premiumRole = Role::firstOrCreate(['name' => 'premium']);
        $revendedorRole = Role::firstOrCreate(['name' => 'revendedor']);

        /**
         * Definimos una matriz (array) de usuarios. Cada elemento del array es un array asociativo
         * que contiene los detalles del usuario (email, nombre, contraseña) y el rol que se le asignará.
         */
        $usuarios = [
            [
                'email' => 'admin@admin.com',
                'name' => 'admin',
                'password' => bcrypt('14e30s15b'), // Usamos bcrypt para encriptar la contraseña
                'role' => $adminRole
            ],
            [
                'email' => 'admin2@admin.com',
                'name' => 'admin2',
                'password' => bcrypt('123456'), // Encriptación de la contraseña
                'role' => $adminRole
            ],
            [
                'email' => 'revendedor@gmail.com',
                'name' => 'revendedor',
                'password' => bcrypt('123456'), // Encriptación de la contraseña
                'role' => $revendedorRole
            ],
            [
                'email' => 'premium@gmail.com',
                'name' => 'premium',
                'password' => bcrypt('14e30s15b'), // Encriptación de la contraseña
                'role' => $premiumRole
            ]
        ];

        /**
         * Iteramos sobre cada elemento de la matriz de usuarios.
         * Para cada usuario, utilizamos el método firstOrCreate para buscar o crear un nuevo registro
         * en la base de datos. Buscamos por email y, si no existe, creamos uno nuevo con los detalles proporcionados.
         */
        foreach ($usuarios as $usuario) {
            // Encuentra o crea el usuario
            $user = User::firstOrCreate(
                ['email' => $usuario['email']],
                ['name' => $usuario['name'], 'password' => $usuario['password']]
            );

            /**
             * Verificamos si el usuario ya tiene el rol asignado. Si no es así, usamos el método assignRole
             * para asignarle el rol. El método assignRole es parte del paquete Spatie's Laravel Permission
             * y se encarga de gestionar las relaciones entre usuarios y roles.
             */
            if (!$user->hasRole($usuario['role']->name)) {
                $user->assignRole($usuario['role']);
            }
        }
    }
}
