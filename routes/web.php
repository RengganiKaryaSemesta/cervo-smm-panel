<?php

use Illuminate\Support\Facades\Route;

Route::as('admin.')
    ->group(__DIR__ . '/admin.php');
Route::get('/never',function(){

})->name('never');