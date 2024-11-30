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
            'instagram_service_items',
            function (Blueprint $table) {
                $table->dropForeign(['instagram_account_id']);  // Sesuaikan dengan kolom foreign key yang tepat
            });

        // Menambahkan foreign key dengan onDelete('cascade')
        Schema::table(
            'instagram_service_items',
            function (Blueprint $table) {
                $table->foreign('instagram_account_id')
                    ->references('id')->on('instagram_accounts')
                    ->onDelete('cascade');
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down() : void
    {
        Schema::table(
            'instagram_service_items',
            function (Blueprint $table) {
                $table->dropForeign(['instagram_account_id']);
                $table->foreign('instagram_account_id')
                    ->references('id')->on('instagram_accounts')
                    ->onDelete('restrict');
            });
    }
};
