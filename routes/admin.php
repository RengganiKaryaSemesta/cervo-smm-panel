<?php
use App\Http\Controllers\GenerateBarcodePdfController;


Route::get(
    '/login',
    \App\Livewire\Auth\Login::class
)->middleware('guest')->name('login');

Route::middleware('auth')->group(
    function () {
        Route::get(
            '/',
            \App\Livewire\Admin\Dashboard::class
        )->name('dashboard');
        Route::get(
            '/instagram-account-managements',
            \App\Livewire\Admin\InstagramAccountManagement\Content::class
        )
            ->name('instagram-account-managements')->can('read instagram account management');
        Route::get(
            '/user-managements',
            \App\Livewire\Admin\UserManagement\Content::class
        )
            ->name('user-managements')->can('read user management');
        Route::get(
            '/role-managements',
            \App\Livewire\Admin\RoleManagement\Content::class
        )
            ->name('role-managements')->can('read role management');
        Route::get(
            '/log-activities',
            \App\Livewire\Admin\LogActivity\Content::class
        )
            ->name('log-activities')->can('read log activities management');
    }
);