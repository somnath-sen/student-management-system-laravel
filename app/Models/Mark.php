<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mark extends Model
{
    protected $fillable = [
        'student_id',
        'subject_id',
        'teacher_id',
        'marks_obtained',
        'total_marks',
        'is_locked',
        'is_published',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    // existing code...
    public function marks()
    {
        return $this->hasMany(Mark::class);
    }
}
