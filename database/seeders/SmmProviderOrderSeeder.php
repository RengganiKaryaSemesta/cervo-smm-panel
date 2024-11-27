<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SmmProviderOrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permission = [
            Permission::create(
                [
                    'name'        => 'read smm provider order management',
                    'guard_name'  => 'web',
                    'description' => 'Allow to read smm provider order',
                ]
            ),
            Permission::create(
                [
                    'name'        => 'create smm provider order management',
                    'guard_name'  => 'web',
                    'description' => 'Allow to create smm provider order',
                ]
            ),
            Permission::create(
                [
                    'name'        => 'update smm provider order management',
                    'guard_name'  => 'web',
                    'description' => 'Allow to update smm provider order',
                ]
            ),
            Permission::create(
                [
                    'name'        => 'delete smm provider order management',
                    'guard_name'  => 'web',
                    'description' => 'Allow to delete smm provider order',
                ]
            ),
        ];

        $role = Role::where(
            'name',
            'Super Admin'
        )->first();
        $role->givePermissionTo($permission);
    }
}
