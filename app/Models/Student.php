<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use App\Models\Course;

class Student extends Model
{
    protected $fillable = [
        'user_id',
        'course_id',
        'roll_number',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
