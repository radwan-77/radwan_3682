<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class courseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $course = Course::all();
        return response()->json(["data" => $course]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            "name" => ["required", "string"],
            "symbol" => ["required", "unique:courses"],
            "mark" => ["required", "numeric"],

        ]);
        Course::create($validated);
        return response()->json(["data" => $validated, "message" => "Course created successfully"]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $course = Course::findOrFail($id);
        return response()->json(["data" => $course]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            "name" => ["required", "string"],
            "symbol" => ["required", "unique:courses"],
            "mark" => ["required", "numeric"],

        ]);
        $course = Course::findOrFail($id);
        $course->update($validated);
        return response()->json(["data" => $validated,  "message" => "Course updated successfully"]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $course = Course::findOrFail($id);
        $course->delete();
        return response()->json(["message" => " Course is deleted successfully"]);
    }
}
