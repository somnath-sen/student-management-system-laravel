<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupportTicket extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'subject',
        'question',
        'status',
        'admin_reply',
        'replied_at',
    ];

    protected $casts = [
        'replied_at' => 'datetime',
    ];

    /**
     * Relationship: ticket belongs to a user
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relationship: ticket has many chat messages
     */
    public function messages()
    {
        return $this->hasMany(SupportMessage::class, 'ticket_id')->orderBy('created_at');
    }

    /**
     * Whether the chat thread is still open (not solved)
     */
    public function getChatEnabledAttribute(): bool
    {
        return $this->status !== 'solved';
    }

    /**
     * Scope: only pending/submitted tickets
     */
    public function scopePending($query)
    {
        return $query->where('status', 'submitted');
    }

    /**
     * Scope: by status
     */
    public function scopeByStatus($query, string $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Get human-readable status label
     */
    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'submitted' => 'Submitted',
            'in_progress' => 'In Progress',
            'solved' => 'Solved',
            default => 'Unknown',
        };
    }

    /**
     * Get status step index (0, 1, 2) for timeline
     */
    public function getStatusStepAttribute(): int
    {
        return match ($this->status) {
            'submitted' => 0,
            'in_progress' => 1,
            'solved' => 2,
            default => 0,
        };
    }
}
