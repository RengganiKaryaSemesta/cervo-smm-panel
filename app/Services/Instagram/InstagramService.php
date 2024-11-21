<?php

namespace App\Services\Instagram;

use App\Enums\InstagramServiceStatus;
use App\Models\InstagramAccount;
use App\Models\InstagramService as InstagramServiceModel;
use App\Enums\InstagramServiceType;
use App\Services\Instagram\Actions\LikeAction;
use Illuminate\Support\Facades\Http;
use App\Enums\InstagramServiceItemStatus;

class InstagramService
{
    /**
     * Create a new class instance.
     */
    public function like(InstagramServiceModel $instagramServiceModel) : array
    {
        $accountCount      = $instagramServiceModel->account_count;
        $url               = $instagramServiceModel->url;
        $availableAccounts = $this->getAvailableAccounts(
            $instagramServiceModel,
            $accountCount
        );
        // Simpan data akun yang melakukan like
        $failed  = false;
        $success = false;
        foreach ($availableAccounts as $account) {
            $likeAction = new LikeAction(
                $instagramServiceModel,
                $account
            );
            $result     = $likeAction->execute();
            if ($result) {
                $success = true;
            }
            else {
                $failed = true;
                break;
            }
        }
        $instagramServiceModel->update(
            [
                'status'      => ($failed && $success)
                    ? InstagramServiceStatus::PartialFailure->value
                    : ($success
                        ? InstagramServiceStatus::Completed->value
                        : InstagramServiceStatus::Failed->value),
                'finished_at' => now(),
            ]
        );
        return $availableAccounts->toArray();
    }
    public function getAvailableAccounts(InstagramServiceModel $instagramServiceModel, int $count) : \Illuminate\Support\Collection
    {
        $instagramServiceModels = InstagramServiceModel::where(
            'url',
            $instagramServiceModel->url
        )
            ->where(
                'type',
                $instagramServiceModel->type
            )
            ->get();
        $usedAccountIds         = $instagramServiceModels->flatMap(
            function ($service) {
                return $service->instagramServiceItems()->where(
                    'status',
                    InstagramServiceItemStatus::Completed->value
                )->pluck('instagram_account_id');
            }
        )->unique()->toArray();
        $availableAccounts      = InstagramAccount::whereNotIn(
            'id',
            $usedAccountIds
        )
            ->where(
                'status',
                1
            )
            ->take($count)
            ->get();

        // Periksa apakah jumlah akun yang tersedia mencukupi
        if ($availableAccounts->count() === 0) {
            $instagramServiceModel->update(
                [
                    'finished_at' => now(),
                    'status'      => InstagramServiceStatus::Failed->value,
                    'error_msg'   => "Tidak cukup akun Instagram yang tersedia untuk melakukan like. Dibutuhkan {$count}, tetapi hanya tersedia {$availableAccounts->count()}.Tidak cukup akun Instagram yang tersedia untuk melakukan like. Dibutuhkan {$count}, tetapi hanya tersedia {$availableAccounts->count()}.",
                ]
            );
            return throw new \Exception("Tidak cukup akun Instagram yang tersedia untuk melakukan like. Dibutuhkan {$count}, tetapi hanya tersedia {$availableAccounts->count()}.");
        }
        return $availableAccounts;
    }
    static public function comment()
    {
    }
    static public function follow()
    {
    }
}
