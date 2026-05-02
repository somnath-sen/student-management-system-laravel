<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Mass assignable attributes
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'telegram_chat_id',
        'telegram_connect_token',
        'telegram_connected_at',
    ];


    /**
     * Hidden attributes
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Casts
     */
    protected function casts(): array
    {
        return [
            'email_verified_at'      => 'datetime',
            'password'               => 'hashed',
            'last_login_at'          => 'datetime',
            'last_seen_at'           => 'datetime',
            'telegram_connected_at'  => 'datetime',
        ];
    }

    /**
     * Check if Telegram is connected
     */
    public function hasTelegramConnected(): bool
    {
        return ! empty($this->telegram_chat_id);
    }


    /**
     * User → Role relationship
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * User → Student profile
     */
    public function student()
    {
        return $this->hasOne(Student::class);
    }

    /**
     * User → Teacher profile
     */
    public function teacher()
    {
        return $this->hasOne(Teacher::class);
    }
    
    /**
     * User (Parent) → Children (Students)
     */
    public function children()
    {
        return $this->belongsToMany(Student::class, 'parent_student', 'parent_id', 'student_id');
    }

    /**
     * Gamification Relationships
     */
    public function gamificationStat()
    {
        return $this->hasOne(GamificationStat::class);
    }

    public function badges()
    {
        return $this->belongsToMany(Badge::class);
    }

    public function activityLogs()
    {
        return $this->hasMany(ActivityLog::class);
    }

    /**
     * Gamification Engine
     */
    public function addXP($amount, $title, $description, $type = 'XP')
    {
        $stats = $this->gamificationStat()->firstOrCreate(
            ['user_id' => $this->id],
            [
                'total_points' => 0,
                'level' => 1,
                'current_streak' => 0,
                'last_login_date' => null
            ]
        );

        $stats->total_points += $amount;
        
        // Every 1000 XP = 1 Level
        $newLevel = floor($stats->total_points / 1000) + 1;
        if ($newLevel > $stats->level) {
            $stats->level = $newLevel;
            // You could log a level up activity here too if you want!
        }
        
        $stats->save();

        // Save activity log
        $this->activityLogs()->create([
            'type' => $type,
            'title' => $title,
            'description' => $description,
            'points_awarded' => $amount,
        ]);

        $this->checkBadgeUnlocks();
    }

    public function checkBadgeUnlocks()
    {
        $stats = $this->gamificationStat;
        if (!$stats) return;

        $unlockedBadgeIds = $this->badges()->pluck('badges.id')->toArray();

        $availableBadges = Badge::whereNotIn('id', $unlockedBadgeIds)
            ->where('points_required', '<=', $stats->total_points)
            ->get();

        foreach ($availableBadges as $badge) {
            $this->badges()->attach($badge->id);
            
            // Log the badge unlock
            $this->activityLogs()->create([
                'type' => 'Badge',
                'title' => "Unlocked: {$badge->name}",
                'description' => "Congratulations! You've earned the {$badge->name} badge.",
                'points_awarded' => 0,
            ]);
        }
    }

    /**
     * Activity Tracking Helpers
     */
    public function getActivityStatusAttribute()
    {
        if (!$this->last_seen_at) return 'Offline';
        
        $minutes = $this->last_seen_at->diffInMinutes(now());
        
        if ($minutes < 5) return 'Online';
        if ($minutes < 120) return 'Recently Active';
        
        return 'Offline';
    }

    public function getActivityColorAttribute()
    {
        return match($this->activity_status) {
            'Online' => 'bg-emerald-500',
            'Recently Active' => 'bg-amber-500',
            default => 'bg-rose-500',
        };
    }
}
