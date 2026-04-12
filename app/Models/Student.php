<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Course;

class Student extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'course_id',
        'roll_number',
        'phone',
        'parent_name',
        'emergency_phone', 
        'blood_group', 
        'home_address',
        'last_lat',
        'last_lng',
        'location_updated_at',
        'is_panicking',
        'panic_lat',
        'panic_lng',
        'panic_triggered_at',
    ];

    protected $casts = [
        'location_updated_at' => 'datetime',
        'panic_triggered_at'  => 'datetime',
        'is_panicking'        => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
    
    public function parents()
    {
        return $this->belongsToMany(User::class, 'parent_student', 'student_id', 'parent_id');
    }

    public function messageReads()
    {
        return $this->hasMany(MessageRead::class);
    }

    /**
     * Count unread broadcast messages for this student
     * across all subjects in their course.
     */
    public function unreadBroadcastCount(): int
    {
        $subjectIds = \App\Models\Subject::where('course_id', $this->course_id)->pluck('id');

        $messageIds = \App\Models\BroadcastMessage::whereIn('subject_id', $subjectIds)->pluck('id');

        $readIds = \App\Models\MessageRead::where('student_id', $this->id)
            ->where('seen', true)
            ->pluck('message_id');

        return $messageIds->diff($readIds)->count();
    }
}