<?php

use App\Enums\InstagramServiceType;
use App\Enums\InstagramServiceStatus;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up() : void
    {
        Schema::create(
            'instagram_services',
            function (Blueprint $table) {
                $table->id();
                $table->longText('url');
                $table->bigInteger('account_count');
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
                        collect(InstagramServiceStatus::cases())->toArray(),
                        'value'
                    )
                );
                $table->timestamp('started_at');
                $table->timestamp('finished_at');
                $table->timestamps();
                $table->softDeletes();
                $table->auditable();
                $table->code();
            }
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down() : void
    {
        Schema::dropIfExists('instagram_services');
    }
};
