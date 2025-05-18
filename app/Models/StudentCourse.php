<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentCourse extends Model
{
    protected $fillable = [
        'studentId',
        'courseId',
        'mark',
    ];
    protected $appends = [
        'avg',
    ];
    public function student()
    {
        return $this->belongsTo(Student::class, 'studentId', 'id');
    }
    public function course()
    {
        return $this->belongsTo(Course::class, 'courseId', 'id');
    }
    public function getAvgAttribute()
    {
        $count =  StudentCourse::where("studentId", $this->studentId)->count();
        $sum =  StudentCourse::where("studentId", $this->studentId)->sum("mark");
        if ($count == 0) {
            return 0;
        } else {
            return $sum / $count;
        }
    }
}
