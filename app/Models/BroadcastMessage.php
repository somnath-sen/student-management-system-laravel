<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BroadcastMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'teacher_id',
        'subject_id',
        'message',
        'is_important',
        'type',
    ];

    protected $casts = [
        'is_important' => 'boolean',
    ];

    /**
     * Message belongs to a teacher
     */
    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    /**
     * Message belongs to a subject
     */
    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    /**
     * Message has many read receipts
     */
    public function reads()
    {
        return $this->hasMany(MessageRead::class, 'message_id');
    }

    /**
     * Count of students who have seen this message
     */
    public function seenCount()
    {
        return $this->reads()->where('seen', true)->count();
    }

    /**
     * Check if a specific student has seen this message
     */
    public function seenByStudent($studentId): bool
    {
        return $this->reads()->where('student_id', $studentId)->where('seen', true)->exists();
    }
}
