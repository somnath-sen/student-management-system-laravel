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
        'parent_name', 
        'emergency_phone', 
        'blood_group', 
        'home_address',
        'last_lat',
        'last_lng',
        'location_updated_at',
    ];

    protected $casts = [
        'location_updated_at' => 'datetime',
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