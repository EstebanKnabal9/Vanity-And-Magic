<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear el rol de admin
        $adminRole = Role::firstOrCreate(['name' => 'admin']);

        // Crear permisos generalizados
        $permisos = [
            'crear',
            'editar',
            'eliminar',
            'ver',
        ];

        foreach ($permisos as $permiso) {
            Permission::firstOrCreate(['name' => $permiso]);
        }

        // Asignar todos los permisos al rol admin
        $adminRole->syncPermissions(Permission::all());

        // Asignar el rol al usuario administrador
        $admin = User::where('email', 'admin@admin.com')->first();
        if ($admin) {
            $admin->assignRole($adminRole);
        }
    }
}
