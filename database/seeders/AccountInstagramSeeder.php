<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AccountInstagramSeeder extends Seeder
{
    
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
       
        $permissions = [
            ['name' => 'instagramAccount.create', 'description' => 'Create a instagramAccount'],
            ['name' => 'instagramAccount.read', 'description' => 'View a instagramAccount'],
            ['name' => 'instagramAccount.update', 'description' => 'Edit a instagramAccount'],
            ['name' => 'instagramAccount.delete', 'description' => 'Delete a instagramAccount'],
        ];

        // Create permissions if they don't exist
        foreach ($permissions as $permissionData) {
            $permission = Permission::firstOrCreate(
                ['name' => $permissionData['name']],
                ['description' => $permissionData['description']]
            );

            // Assign the permission to Super Admin role
            $role = Role::where('name', 'Super Admin')->first();
            if ($role && !$role->hasPermissionTo($permission)) {
                $role->givePermissionTo($permission);
            }
        }
    }
}
