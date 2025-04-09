<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PlaceController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('/place')->group(function () {
    Route::post('/create', [PlaceController::class, 'create']);
    Route::get('/places', [PlaceController::class, 'places']);
    Route::put('/edit/{placeID}', [PlaceController::class, 'edit']);
    Route::delete('/delete/{placeID}', [PlaceController::class, 'delete']);
});
