<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Crear roles
        $empleadoRole = Role::create(['name' => 'empleado']);
        $adminRole = Role::create(['name' => 'admin']);

        // Crear permisos
        $ventas = Permission::create(['name' => 'ventas']);
        
        // Asignar permisos al rol 'empleado'
        $empleadoRole->givePermissionTo([$ventas, $hacerEgresos]);

        // Asignar permisos al rol 'admin' (puedes agregar otros permisos si es necesario)
        $adminRole->givePermissionTo([$ventas, $hacerEgresos]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Eliminar los permisos y roles si se necesita revertir la migración
        $empleadoRole = Role::findByName('empleado');
        $adminRole = Role::findByName('admin');
        $ventas = Permission::findByName('ventas');

        // Eliminar permisos asignados
        $empleadoRole->revokePermissionTo([$ventas, $hacerEgresos]);
        $adminRole->revokePermissionTo([$ventas, $hacerEgresos]);

        // Eliminar roles y permisos
        $empleadoRole->delete();
        $adminRole->delete();
        $ventas->delete();
        $hacerEgresos->delete();
    }
};
