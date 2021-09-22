<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;


use App\Models\User;
use App\Models\RoleTypes;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [
            [
                'name' => 'Admin',
                'email' => 'admin@admin.com',
                'password' => bcrypt('Admin@123'),
                'user_role' => RoleTypes::ADMIN,
                'role' => 'Admin'
            ]         
        ];

        foreach ($items as $item) {
            $newUser = User::firstOrCreate([
                'name' => $item['name'],
                'email' => $item['email'],
                'password' => $item['password'],
                'user_role' => $item['user_role'],
            ]);

            $role = Role::firstOrCreate(['name' => $item['role']]);
            $role->syncPermissions(Permission::all());
            $newUser->assignRole([$role->id]);          
        }
    }
}
