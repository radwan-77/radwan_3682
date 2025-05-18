<?php

use App\Http\Controllers\authController;
use App\Http\Controllers\courseController;
use App\Http\Controllers\studentController;
use App\Http\Controllers\studentCourseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('login', [authController::class, 'login']);
Route::post('register', [authController::class, 'register']);


Route::middleware("auth:snactum")->group(function () {
    //----------------------------route for course--------------------------
    Route::apiResource("course", courseController::class);
    //----------------------------route for student--------------------------
    Route::apiResource("student", studentController::class);
    // Custom route to graduate a student (separate from standard destroy)
    Route::delete('studentGraduate/{id}', [studentController::class, 'graduate']);
    Route::delete("studentDismisse/{id}", [studentController::class, "dismisse"]);
    Route::delete("studentActivate/{id}", [studentController::class, "reActivate"]);
    //----------------------------route for studentCourse--------------------------
    Route::apiResource("studentCourse", studentCourseController::class);
    //-----------------------------route for auth--------------------------
    Route::get('profile', [authController::class, 'profile']);
    Route::get('logout', [authController::class, 'logout']);
});
