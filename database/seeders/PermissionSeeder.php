<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            'role-list',
            'role-edit',
            'product-list',
            'product-create',
            'product-edit',
            'product-delete',
         ];

        foreach ($permissions as $permission) {
            Permission::firstOrcreate(['name' => $permission]);
        }

        $roles = ['Admin','User'];        
        
        foreach ($roles as $role) {
            $newRole = Role::firstOrCreate(['name' => $role]);
            if ($role == 'Admin') {
                $newRole->givePermissionTo($permissions);
            }else {
                $newRole->givePermissionTo([
                    'product-list',
                    'product-create',
                    'product-edit',
                    'product-delete'
                ]);
            }
         }
    }
}
