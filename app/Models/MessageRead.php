<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MessageRead extends Model
{
    use HasFactory;

    protected $fillable = [
        'message_id',
        'student_id',
        'seen',
        'seen_at',
    ];

    protected $casts = [
        'seen'    => 'boolean',
        'seen_at' => 'datetime',
    ];

    /**
     * Belongs to a broadcast message
     */
    public function message()
    {
        return $this->belongsTo(BroadcastMessage::class, 'message_id');
    }

    /**
     * Belongs to a student
     */
    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
