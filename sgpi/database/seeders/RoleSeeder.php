<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role1 = Role::create(['name' => 'Admin']);
        $role2 = Role::create(['name' => 'Encargado']);
        $role3 = Role::create(['name' => 'Becario']);
        $role4 = Role::create(['name' => 'Estudiante']);

        // SECCION DE INICIO
        Permission::create(['name' => 'home.index'])->syncRoles([$role1,$role2,$role3,$role4]);
        
        // SECCION PROVIDER
        Permission::create(['name' => 'provider.index'])->syncRoles([$role1,$role2,$role3]);
        Permission::create(['name' => 'provider.create'])->syncRoles([$role1,$role2]);
        Permission::create(['name' => 'provider.edit'])->syncRoles([$role1,$role2,$role3]); 
        Permission::create(['name' => 'provider.destroy'])->syncRoles([$role1,$role2]);
        
        // SECCION GESTION DE MATERIALES
        Permission::create(['name' => 'materials.index'])->syncRoles([$role1,$role2,$role3]);
        Permission::create(['name' => 'materials.create'])->syncRoles([$role1,$role2]);
        Permission::create(['name' => 'materials.edit'])->syncRoles([$role1,$role2,$role3]); 
        Permission::create(['name' => 'materials.destroy'])->syncRoles([$role1,$role2]);

        // SECCION PRÉSTAMO DE MATERIALES
        Permission::create(['name' => 'loans.index'])->syncRoles([$role1,$role2,$role3,$role4]);
        // Permission::create(['name' => 'loans.create'])->syncRoles([$role1,$role2,$role3,$role4]);
        
        // SECCION ESTASÍSTICAS
        Permission::create(['name' => 'statistics.index'])->syncRoles([$role1,$role2,$role3]);

        // SECCION DE USUARIOS
        Permission::create(['name' => 'user.index'])->syncRoles([$role1]);
        Permission::create(['name' => 'user.edit'])->syncRoles([$role1]); 
        
        // SECCION DE LABORATORIOS
        Permission::create(['name' => 'labs.index'])->syncRoles([$role1]);
        Permission::create(['name' => 'labs.edit'])->syncRoles([$role1]); 
    }
}
