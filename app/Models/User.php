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
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
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
}
