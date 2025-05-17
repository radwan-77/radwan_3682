<?php

namespace App\Http\Controllers;

use App\Models\Student;
// use Illuminate\Container\Attributes\Storage;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class studentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $student = Student::all();
        return response()->json(["data" => $student, "message" => "success"]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "no" => ["required", "unique:students"],
            "name" => ["required"],
            "email" => ["required", "email", "unique:students"],
            "password" => ["required", "string"],
            "image" => ["nullable", "image", "mimes:jpeg,png,jpg,svg"]
        ]);
        // data without attribute data will vanshied
        $studentdata =  $request->except("image");
        if ($request->hasFile("image")) {
            $image = $request->file("image");
            $path = $image->store("student", "public");
            $studentdata["imgUrl"] = Storage::url($path);

            // $imageName = time() . "_" . $image->getClientOriginalName();
            // $image->move(public_path("images"), $imageName);
            // $studentdata["imgUrl"] = "images/" . $imageName;
        }
        Student::create($studentdata);
        return response()->json(["data" => $studentdata, "message" => "Student created successfully"]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $student = Student::findOrFail($id);
        return response()->json(["data" => $student]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            "no" => ["required", "unique:students"],
            "name" => ["required"],
            "email" => ["required", "email", "unique:students"],
            "password" => ["required", "string"],
            "image" => ["nullable", "image", "mimes:jpeg,png,jpg,svg"]
        ]);
        $studentdata =  $request->except("image");
        if ($request->hasFile("image")) {
            $image = $request->file("image");
            $path = $image->store("student", "public");
            $studentdata["imgUrl"] = Storage::url($path);
        }
        $student = Student::findOrFail($id);
        $student->update($studentdata);
        return response()->json(["data" => $studentdata,  "message" => "Student updated successfully"]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $student = Student::findOrFail($id);
        $student->isActive = 0;
        $student->isDismissed = 1;
        $student->save();
        return response()->json(["message" => "Student is dismissed successfully"]);
    }
    public function graduate(string $id)
    {
        $student = Student::findOrFail($id);
        $student->isActive = 0;
        $student->isGraduated = 1;
        $student->save();
        return response()->json(["message" => "Student is graduated successfully"]);
    }
    // dismissed
}
