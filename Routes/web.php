<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Modules\Plan\Http\Controllers\PlanController;
use Modules\Plan\Http\Controllers\ChoreController;
use Modules\Plan\Http\Controllers\PlanItemController;
use Modules\Plan\Http\Controllers\EquipmentController;

Route::middleware(['auth:sanctum', 'atmosphere.teamed', 'verified'])->prefix('housing')->group(function() {
    Route::resource('/plans', PlanController::class);
    Route::resource('/chores', ChoreController::class);
    Route::resource('/equipments', EquipmentController::class);
    Route::apiResource('plans.items', PlanItemController::class);
    Route::get('/boards/{id}', [PlanController::class, 'show'])->name('boards');
});
