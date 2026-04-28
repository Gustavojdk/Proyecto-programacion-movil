<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesSeeder extends Seeder
{
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            'admin.trufis.crear',
            'admin.trufis.ver',
            'admin.trufis.editar',
            'admin.trufis.eliminar',
            'admin.rutas.crear',
            'admin.rutas.ver',
            'admin.rutas.editar',
            'admin.rutas.eliminar',
            'admin.usuarios.crear',
            'admin.usuarios.ver',
            'admin.usuarios.editar',
            'admin.usuarios.eliminar',
            'admin.sindicatos.crear',
            'admin.sindicatos.ver',
            'admin.sindicatos.editar',
            'admin.sindicatos.eliminar',
            'admin.radiotaxis.crear',
            'admin.radiotaxis.ver',
            'admin.radiotaxis.editar',
            'admin.radiotaxis.eliminar',
            'admin.normativas.crear',
            'admin.normativas.ver',
            'admin.normativas.editar',
            'admin.normativas.eliminar',
            'admin.reportes.ver',
            'admin.settings.ver',
            'admin.settings.editar',
            'admin.referencias.ver',
            'admin.referencias.crear',
            'admin.referencias.editar',
            'admin.referencias.eliminar',
        ];

        foreach ($permissions as $name) {
            Permission::firstOrCreate(['name' => $name, 'guard_name' => 'web']);
        }

        $adminRole = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $adminRole->syncPermissions($permissions);

        $encargadoPerms = array_filter($permissions, fn ($p) => str_ends_with($p, '.ver'));
        $encargadoRole = Role::firstOrCreate(['name' => 'encargado', 'guard_name' => 'web']);
        $encargadoRole->syncPermissions(array_values($encargadoPerms));
    }
}
