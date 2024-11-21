<?php

use App\Enums\InstagramServiceType;
use Illuminate\Support\Facades\Schema;
use App\Enums\InstagramServiceItemStatus;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up() : void
    {
        Schema::create(
            'instagram_service_items',
            function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('instagram_account_id');
                $table->unsignedBigInteger('instagram_service_id');
                $table->longText('comment')->nullable();
                $table->enum(
                    'type',
                    array_column(
                        collect(InstagramServiceType::cases())->toArray(),
                        'value'
                    )
                );
                $table->enum(
                    'status',
                    array_column(
                        collect(InstagramServiceItemStatus::cases())->toArray(),
                        'value'
                    )
                );
                $table->timestamps();
                $table->softDeletes();
                $table->auditable();
                // relasi dan indexing
                $table->foreign('instagram_account_id')->references('id')->on('instagram_accounts')->restrictOnDelete();
                $table->foreign('instagram_service_id')->references('id')->on('instagram_services')->cascadeOnDelete();
            }
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down() : void
    {
        Schema::dropIfExists('instagram_service_items');
    }
};
