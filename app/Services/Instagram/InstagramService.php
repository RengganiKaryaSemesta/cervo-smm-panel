<?php

namespace App\Services\Instagram;

use App\Enums\InstagramServiceStatus;
use App\Models\InstagramAccount;
use App\Models\InstagramService as InstagramServiceModel;
use App\Enums\InstagramServiceType;
use App\Services\Instagram\Actions\CommentAction;
use App\Services\Instagram\Actions\FollowAction;
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
    public function follow(InstagramServiceModel $instagramServiceModel) : array
    {
        $accountCount      = $instagramServiceModel->account_count;
        $availableAccounts = $this->getAvailableAccounts(
            $instagramServiceModel,
            $accountCount
        );
        // Simpan data akun yang melakukan like
        $failed  = false;
        $success = false;
        foreach ($availableAccounts as $account) {
            $action = new FollowAction(
                $instagramServiceModel,
                $account
            );
            $result     = $action->execute();
            if ($result==1) {
                $success = true;
            }
            else {
                $failed = true;
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
    public function comment(InstagramServiceModel $instagramServiceModel, $comments = []) : array
    {
        $availableAccounts =  InstagramAccount::limit($instagramServiceModel->account_count)
            ->get();
        // Simpan data akun yang melakukan like
        $failed  = false;
        $success = false;
        foreach ($availableAccounts as $account) {
            $action = new CommentAction(
                $instagramServiceModel,
                $account,
                $comments
            );
            $result = $action->execute();
            if ($result) {
                $success = true;
            }
            else {
                $failed = true;
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
                $instagramServiceModel->type->value
            )
            ->get();
            dd($instagramServiceModels->type);
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
                    'error_msg'   => "Tidak cukup akun Instagram yang tersedia untuk melakukan proses. Kemungkinan sudah semua akun Instagram yang tersedia telah digunakan.",
                ]
            );
            return throw new \Exception("Tidak cukup akun Instagram yang tersedia untuk melakukan proses. Kemungkinan sudah semua akun Instagram yang tersedia telah digunakan.");
        }
        return $availableAccounts;
    }
}
