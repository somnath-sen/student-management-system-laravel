<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupportMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'ticket_id',
        'sender_id',
        'sender_role',
        'body',
    ];

    /**
     * Message belongs to a ticket
     */
    public function ticket()
    {
        return $this->belongsTo(SupportTicket::class, 'ticket_id');
    }

    /**
     * Message belongs to a sender (user)
     */
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    /**
     * Whether this message was sent by admin
     */
    public function isAdmin(): bool
    {
        return $this->sender_role === 'admin';
    }
}
