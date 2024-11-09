<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Schema\Blueprint;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if($this->app->environment('production')) {
            \URL::forceScheme('https');
        }
        
        Paginator::useTailwind();
        Blueprint::macro('auditable', function () {
            $this->unsignedBigInteger('created_by')->nullable();
            $this->unsignedBigInteger('updated_by')->nullable();
            $this->unsignedBigInteger('deleted_by')->nullable();

            // Tambahkan foreign key ke tabel users, dengan onDelete set null
            $this->foreign('created_by')->references('id')->on('users')->onDelete('set null');
            $this->foreign('updated_by')->references('id')->on('users')->onDelete('set null');
            $this->foreign('deleted_by')->references('id')->on('users')->onDelete('set null');
        });
    }
}
