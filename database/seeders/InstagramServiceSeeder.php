<?php

namespace Database\Seeders;

use App\Enums\InstagramServiceItemStatus;
use App\Enums\InstagramServiceStatus;
use App\Enums\InstagramServiceType;
use App\Models\InstagramService;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class InstagramServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run() : void
    {
        $permission = [
            Permission::create(
                [
                    'name'        => 'read instagram services management',
                    'guard_name'  => 'web',
                    'description' => 'Allow to read instagram services',
                ]
            ),
            Permission::create(
                [
                    'name'        => 'create instagram services management',
                    'guard_name'  => 'web',
                    'description' => 'Allow to create instagram services',
                ]
            ),
            Permission::create(
                [
                    'name'        => 'update instagram services management',
                    'guard_name'  => 'web',
                    'description' => 'Allow to update instagram services',
                ]
            ),
            Permission::create(
                [
                    'name'        => 'delete instagram services management',
                    'guard_name'  => 'web',
                    'description' => 'Allow to delete instagram services',
                ]
            ),
        ];

        $role = Role::where(
            'name',
            'Super Admin'
        )->first();
        $role->givePermissionTo($permission);
        if (env('APP_ENV') == 'local') {
            $like = InstagramService::create(
                [
                    'url'           => 'https://ig.dummy.com',
                    'account_count' => 2,
                    'type'          => InstagramServiceType::Like->value,
                    'status'        => InstagramServiceStatus::PartialFailure->value,
                    'started_at'    => now(),
                    'finished_at'   => now(),
                ]
            );
            $like->instagramServiceItems()->create(
                [
                    'instagram_account_id' => 1,
                    'comment'              => null,
                    'type'                 => InstagramServiceType::Like->value,
                    'status'               => InstagramServiceItemStatus::Completed,
                ]
            );
            $like->instagramServiceItems()->create(
                [
                    'instagram_account_id' => 2,
                    'comment'              => null,
                    'type'                 => InstagramServiceType::Like->value,
                    'status'               => InstagramServiceItemStatus::Failed,
                ]
            );
            $follow = InstagramService::create(
                [
                    'url'           => 'https://ig.dummy.com',
                    'account_count' => 2,
                    'type'          => InstagramServiceType::Follow->value,
                    'status'        => InstagramServiceStatus::Completed->value,
                    'started_at'    => now(),
                    'finished_at'   => now(),
                ]
            );
            $follow->instagramServiceItems()->create(
                [
                    'instagram_account_id' => 1,
                    'comment'              => null,
                    'type'                 => InstagramServiceType::Follow->value,
                    'status'               => InstagramServiceItemStatus::Completed,
                ]
            );
            $comment = InstagramService::create(
                [
                    'url'           => 'https://ig.dummy.com',
                    'account_count' => 2,
                    'type'          => InstagramServiceType::Comment->value,
                    'status'        => InstagramServiceStatus::PartialFailure->value,
                    'started_at'    => now(),
                    'finished_at'   => now(),
                ]
            );
            $comment->instagramServiceItems()->create(
                [
                    'instagram_account_id' => 1,
                    'comment'              => "Saya raja",
                    'type'                 => InstagramServiceType::Comment->value,
                    'status'               => InstagramServiceItemStatus::Completed,
                ]
            );
            $comment->instagramServiceItems()->create(
                [
                    'instagram_account_id' => 2,
                    'comment'              => "hehehe",
                    'type'                 => InstagramServiceType::Comment->value,
                    'status'               => InstagramServiceItemStatus::Failed,
                ]
            );
        }
    }
}
