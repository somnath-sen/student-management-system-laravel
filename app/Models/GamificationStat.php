<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GamificationStat extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'total_points',
        'level',
        'current_streak',
        'last_login_date',
    ];

    protected $casts = [
        'last_login_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
