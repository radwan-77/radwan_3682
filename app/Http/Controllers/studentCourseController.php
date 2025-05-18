<?php

namespace App\Http\Controllers;

use App\Http\Resources\studentCourseResource;
use App\Models\StudentCourse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Exists;

class studentCourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $studentCourse = StudentCourse::all();
        return studentCourseResource::collection($studentCourse);
    }

    /**
     * Store a newly created resource in storage. 
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            "studentId" => ["required", "exists:students,id"],
            "courseId" => ["required", "exists:courses,id"],
            "mark" => ["required", "numeric"]
        ]);
        $studentCourse = StudentCourse::create($validated);
        return response()->json([
            "message" => "studentCourse created successfully",
            "data" => new studentCourseResource($studentCourse)
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $studentCourse = StudentCourse::findOrFail($id);
        return new studentCourseResource($studentCourse);
        // new اترد ب row 

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id) {}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id) {}
}
