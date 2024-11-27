<?php

namespace Database\Seeders;

use App\Models\SmmProvider;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SmmProviderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run() : void
    {
        SmmProvider::create(
            [
                'name'    => 'djuragansosmed',
                'api_url' => 'https://djuragansosmed.com/api/v2',
                'api_key' => '98cd1a08cb5024a98d7c102e09f06539',
            ]
        );
        $permission = [
            Permission::create(
                [
                    'name'        => 'read smm provider management',
                    'guard_name'  => 'web',
                    'description' => 'Allow to read smm provider',
                ]
            ),
            Permission::create(
                [
                    'name'        => 'create smm provider management',
                    'guard_name'  => 'web',
                    'description' => 'Allow to create smm provider',
                ]
            ),
            Permission::create(
                [
                    'name'        => 'update smm provider management',
                    'guard_name'  => 'web',
                    'description' => 'Allow to update smm provider',
                ]
            ),
            Permission::create(
                [
                    'name'        => 'delete smm provider management',
                    'guard_name'  => 'web',
                    'description' => 'Allow to delete smm provider',
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
