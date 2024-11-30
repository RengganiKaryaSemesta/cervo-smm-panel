<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('smm_providers', function (Blueprint $table) {
            $table->string( 'api_service')->nullable();
        });
        // ambil semua data smm_provider dan update api service menjadi ApiSmmProvider
        DB::table('smm_providers')->update(['api_service' => 'ApiSmmProvider']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('smm_providers', function (Blueprint $table) {
            $table->dropColumn('api_service');
        });
    }
};
