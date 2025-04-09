<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PlaceController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/create-place', [PlaceController::class, 'create']);
Route::get('/get-places', [PlaceController::class, 'places']);
Route::put('/edit-place', [PlaceController::class, 'edit']);
Route::delete('/delete-place', [PlaceController::class, 'delete']);