<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'subject_code',
        'name',
    ];

    /**
     * Subject belongs to a course
     */
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Subject has many marks
     */
    public function marks()
    {
        return $this->hasMany(Mark::class);
    }

    /**
     * Subject has many broadcast messages
     */
    public function broadcastMessages()
    {
        return $this->hasMany(BroadcastMessage::class);
    }
}
