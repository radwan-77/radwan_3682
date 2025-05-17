<?php

use App\Http\Controllers\courseController;
use App\Http\Controllers\studentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
//----------------------------route for course--------------------------
Route::apiResource("course", courseController::class);
//----------------------------route for student--------------------------
Route::apiResource("student", studentController::class);
// Custom route to graduate a student (separate from standard destroy)
Route::delete('studentGraduated/{id}', [studentController::class, 'graduate']);
Route::delete("studentDismissed/{id}", [studentController::class, "dismissed"]);
Route::delete("studentActivated/{id}", [studentController::class, "reActivate"]);
