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
    /**
     * Each resource is scoped to the verbs its controller actually implements.
     * A bare Route::resource() registers all seven, so any unimplemented verb
     * (e.g. GET /housing/chores/{chore}) fataled with "Call to undefined method"
     * instead of returning a 404.
     */
    Route::resource('/plans', PlanController::class)->only(['index', 'store', 'show']);
    Route::get('/chores/screen', [ChoreController::class, 'screen'])->name('chores.screen');
    Route::resource('/chores', ChoreController::class)->only(['index', 'store']);
    Route::resource('/equipments', EquipmentController::class)->only(['index', 'store']);
    Route::apiResource('plans.items', PlanItemController::class);
    Route::get('/boards/{id}', [PlanController::class, 'show'])->name('boards');
});
