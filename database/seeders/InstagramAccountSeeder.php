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
                "cookie"   => 'csrftoken=mOQFi9X6CUpRblMr0u9w_D; wd=1536x730; dpr=1.25; mid=ZzfqtgALAAFDo39ua6VF_RuGraqR; datr=tuo3Z7AJc223s3Qne-r1-MYs; ig_did=7C3747C1-1DF3-4B7A-A10E-073DAD7B41E8; ig_nrcb=1; sessionid=9419178101%3AMnQfKLNaAOwgsr%3A18%3AAYdRwtwY8qCCxqR7HLmeONsZqqcMZhsp5dDc3lIBRA; ds_user_id=9419178101; rur="EAG\0549419178101\0541763306200:01f72d8a6eb99d2ae4de1dc57f36ac8ba26146b1cfff35ca8ad54a34b5ccbb5de0a5bdb0"',
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
