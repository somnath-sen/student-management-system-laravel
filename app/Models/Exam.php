<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    protected $fillable = [
        'course_id',
        'subject_name',
        'subject_code',
        'exam_date',
        'exam_time',
        'is_active',
    ];

    protected $casts = [
        'exam_date' => 'date',
        'is_active' => 'boolean',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
