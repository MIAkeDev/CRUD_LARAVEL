<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductApiController;
use App\Jobs\ProcessProductReport;

Route::get('/products', [ProductApiController::class, 'index']);
Route::get('/products/report', function(){
    ProcessProductReport::dispatch();
    return response()->json([
        'success' => true,
        'message' => '¡El reporte se está procesando en segundo plano! Puedes seguir usando el sistema.'
    ]);
});