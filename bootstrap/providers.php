<?php

return [
    App\Providers\AppServiceProvider::class,
    Spatie\Permission\PermissionServiceProvider::class,
    \Barryvdh\DomPDF\ServiceProvider::class,
    Milon\Barcode\BarcodeServiceProvider::class,
    Barryvdh\Debugbar\ServiceProvider::class,
    Maatwebsite\Excel\ExcelServiceProvider::class,
];
