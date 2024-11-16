<?php

namespace Database\Seeders;

use App\Models\Rack;
use App\Models\StockIn;
use App\Models\User;
use App\Models\Grade;
use App\Models\PurchaseOrder;
use Illuminate\Database\Seeder;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\PurchaseOrderItem;
use Database\Factories\GradeFactory;
use App\Models\PurchaseOrderShipment;
use Database\Factories\PurchaseOrderFactory;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            SuperAdminUserSeeder::class,
            IndoRegionSeeder::class,
            InstagramAccountSeeder::class
        ]);
    }
}
