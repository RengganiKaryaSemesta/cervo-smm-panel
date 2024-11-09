<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;

class SuperAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'name' => 'ACH Rizal Dev',
            'email' => 'achrizal15@gmail.com',
            'username' => 'rizaldev',
            'phone' => '085234104446',
            'password' => Hash::make(123456),
        ]);
        $userAccounting = User::create([
            'name' => 'Rizal Accounting',
            'email' => 'achriAccounting@gmail.com',
            'username' => 'acc',
            'phone' => '085234104441',
            'password' => Hash::make(123456),
        ]);
        $userWarehouse = User::create([
            'name' => 'Rizal Warehouse',
            'email' => 'achriWarehouse@gmail.com',
            'username' => 'wh',
            'phone' => '085234104441',
            'password' => Hash::make(123456),
        ]);
        // ROLE USER
        $roleUser = Role::create(['name' => 'Super Admin', 'guard_name' => 'web', 'description' => 'This role has all access']);
        $accountingRole = Role::create(['name' => 'Accounting Manager', 'guard_name' => 'web', 'description' => 'Role untuk akunting']);
        $whRole = Role::create(['name' => 'Warehouse Manager', 'guard_name' => 'web', 'description' => 'Role untuk gudang']);

        $userPermissions = [
            Permission::create(['name' => 'read user management', 'guard_name' => 'web', 'description' => 'Allow to read user']),
            Permission::create(['name' => 'create user management', 'guard_name' => 'web', 'description' => 'Allow to create user']),
            Permission::create(['name' => 'update user management', 'guard_name' => 'web', 'description' => 'Allow to update user']),
            Permission::create(['name' => 'delete user management', 'guard_name' => 'web', 'description' => 'Allow to delete user']),
            Permission::create(['name' => 'restore user management', 'guard_name' => 'web', 'description' => 'Allow to restore user']),
            Permission::create(['name' => 'read log activities management', 'guard_name' => 'web', 'description' => 'Allow to log activity user']),
        ];
        $rolesPermissions = [
            Permission::create(['name' => 'read role management', 'guard_name' => 'web', 'description' => 'Allow to read role']),
            Permission::create(['name' => 'create role management', 'guard_name' => 'web', 'description' => 'Allow to create role']),
            Permission::create(['name' => 'update role management', 'guard_name' => 'web', 'description' => 'Allow to update role']),
            Permission::create(['name' => 'delete role management', 'guard_name' => 'web', 'description' => 'Allow to delete role']),
        ];
        // PERMISSIONS USER
        $roleUser->syncPermissions(array_merge($rolesPermissions, $userPermissions));

        $user->assignRole($roleUser);
        $userAccounting->assignRole($accountingRole);
        $userWarehouse->assignRole($whRole);
    }
}
