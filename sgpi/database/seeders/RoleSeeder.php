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

        Permission::create(['name' => 'provider.create'])->syncRoles([$role1,$role2]);
        Permission::create(['name' => 'provider.edit'])->syncRoles([$role1,$role2,$role3]); 
        Permission::create(['name' => 'provider.delete'])->syncRoles([$role1,$role2]);


    }
}
