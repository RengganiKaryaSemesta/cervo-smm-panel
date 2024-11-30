<?php

namespace App\Console\Commands;

use App\Models\InstagramAccount;
use Carbon\Carbon;
use App\Models\User;
use App\Models\SmmProvider;
use Illuminate\Console\Command;
use App\Models\InstagramService;
use App\Models\SmmProviderOrder;
use App\Models\InstagramServiceItem;

class CleanUpSoftDeletedData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cleanup:softdeleted';

    // Deskripsi command
    protected $description = 'Hapus data soft deleted yang sudah lebih dari 3 bulan';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Menjalankan pembersihan data yang soft deleted lebih dari 3 bulan...');

        $dateThreshold = Carbon::now()->subMonths(3); // Mengatur batas 3 bulan
        // $dateThreshold = Carbon::now()->subMinutes(10); // Mengatur batas 3 bulan
        // Menghapus data soft deleted lebih dari 3 bulan dari model-model yang relevan

        InstagramService::onlyTrashed()->where(
            'deleted_at',
            '<',
            $dateThreshold)->forceDelete();
        InstagramServiceItem::onlyTrashed()->where(
            'deleted_at',
            '<',
            $dateThreshold)->forceDelete();
        SmmProvider::onlyTrashed()->where(
            'deleted_at',
            '<',
            $dateThreshold)->forceDelete();
        SmmProviderOrder::onlyTrashed()->where(
            'deleted_at',
            '<',
            $dateThreshold)->forceDelete();
        InstagramAccount::onlyTrashed()->where(
            'deleted_at',
            '<',
            $dateThreshold)->forceDelete();
        User::onlyTrashed()->where(
            'deleted_at',
            '<',
            $dateThreshold)->forceDelete();

        $this->info('Pembersihan data selesai.');
    }
}
