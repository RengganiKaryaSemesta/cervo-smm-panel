<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up() : void
    {
        Schema::table(
            'smm_provider_orders',
            function (Blueprint $table) {
                $table->string('service')->nullable();
                $table->string('target')->nullable();
                $table->string('status')->nullable();
                $table->string('start_count')->nullable();
                $table->string('remains')->nullable();
                $table->string('charge')->nullable();
            }
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down() : void
    {
        Schema::table(
            'smm_provider_orders',
            function (Blueprint $table) {
                $table->dropColumn('service');
                $table->dropColumn('target');
                $table->dropColumn('status');
                $table->dropColumn('start_count');
                $table->dropColumn('remains');
                $table->dropColumn('charge');
            }
        );
    }
};
