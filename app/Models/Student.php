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
        // ... any other existing fields ...
        'parent_name', 
        'emergency_phone', 
        'blood_group', 
        'home_address'
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
