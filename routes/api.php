<?php

use App\Http\Controllers\courseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get("course", [courseController::class, "index"]);
Route::get("course/{id}", [courseController::class, "show"]);
Route::post("course", [courseController::class, "store"]);
Route::put("course/{id}", [courseController::class, "update"]);
Route::delete("course/{id}", [courseController::class, "destroy"]);
