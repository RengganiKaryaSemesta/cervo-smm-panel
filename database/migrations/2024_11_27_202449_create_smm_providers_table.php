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
        Schema::create('smm_providers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('api_key');
            $table->string('api_url');
            $table->timestamps();
            $table->softDeletes();
            $table->auditable();
            $table->code();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('smm_providers');
    }
};
