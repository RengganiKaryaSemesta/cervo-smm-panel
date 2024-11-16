<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\InstagramAccount;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class InstagramAccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run() : void
    {
        InstagramAccount::create(
            [
                "username" => "testing",
                "email"    => "testing@contoh.com",
                "password" => "123456",
                "cookie"   => "ig_did=703ED08E-C9C1-40F6-BC32-4940403D3B8F; csrftoken=zwGPkkUAaZ40bvQSKzZtvKkHIpm9Ub8R; datr=7vA2ZzkjpAYCboiy-wKeeTqg; wd=1598x818; dpr=1; mid=Zzbw7gAEAAFDXjD47A9S9HdJUppS; ig_nrcb=1; ds_user_id=8187754200; sessionid=8187754200%3AnDjAsVX7I5PpXW%3A23%3AAYfFyCjsh3O_0D9CTWOqLrrEaT_Z3rvPiYczPpya4g",
                "status"   => 1,
            ]
        );
        $permission = [
            Permission::create([
                'name'        => 'read instagram account management',
                'guard_name'  => 'web',
                'description' => 'Allow to read instagram account',
            ]),
            Permission::create([
                'name'        => 'create instagram account management',
                'guard_name'  => 'web',
                'description' => 'Allow to create instagram account',
            ]),
            Permission::create([
                'name'        => 'update instagram account management',
                'guard_name'  => 'web',
                'description' => 'Allow to update instagram account',
            ]),
            Permission::create([
                'name'        => 'delete instagram account management',
                'guard_name'  => 'web',
                'description' => 'Allow to delete instagram account',
            ]),
        ];

        $role = Role::where(
            'name',
            'Super Admin'
        )->first();
        $role->givePermissionTo($permission);
    }
}
